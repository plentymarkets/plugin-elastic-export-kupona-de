<?php

namespace ElasticExportKuponaDE\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use ElasticExport\Helper\ElasticExportPriceHelper;
use ElasticExport\Helper\ElasticExportStockHelper;
use ElasticExport\Services\FiltrationService;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
use Plenty\Plugin\Log\Loggable;


/**
 * Class KuponaDE
 * @package ElasticExportKuponaDE\Generator
 */
class KuponaDE extends CSVPluginGenerator
{
	use Loggable;

	const DELIMITER = ';';

    /**
     * @var ElasticExportCoreHelper
     */
    private $elasticExportHelper;

    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

	/**
	 * @var ElasticExportStockHelper $elasticExportStockHelper
	 */
    private $elasticExportStockHelper;

	/**
	 * @var ElasticExportPriceHelper $elasticExportPriceHelper
	 */
    private $elasticExportPriceHelper;

	/**
	 * @var array
	 */
    private $shippingCostCache = [];

    /**
     * @var FiltrationService
     */
    private $filtrationService;

    /**
     * KuponaDE constructor.
     *
     * @param ArrayHelper $arrayHelper
     */
    public function __construct(ArrayHelper $arrayHelper)
    {
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * Generates and populates the data into the CSV file.
     *
     * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
     * @param array $formatSettings
     */
    protected function generatePluginContent($elasticSearch, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);
        $this->elasticExportStockHelper = pluginApp(ElasticExportStockHelper::class);
        $this->elasticExportPriceHelper = pluginApp(ElasticExportPriceHelper::class);

		$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');
		$this->filtrationService = pluginApp(FiltrationService::class, ['settings' => $settings, 'filterSettings' => $filter]);

		$this->setDelimiter(self::DELIMITER);

		$this->setHeader();

		if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
		{
			$limitReached = false;
			$lines = 0;
			do
			{
				if($limitReached === true)
				{
					break;
				}

				$resultList = $elasticSearch->execute();

				$this->getLogger(__METHOD__)->error('ElasticExportKuponaDE::logs.esError', [
					'Error message ' => $resultList['error'],
				]);

				foreach($resultList['documents'] as $variation)
				{
					if($lines == $filter['limit'])
					{
						$limitReached = true;
						break;
					}

					if(is_array($resultList['documents']) && count($resultList['documents'] ?? []) > 0)
					{
						if($this->filtrationService->filter($variation))
						{
							continue;
						}

						try
						{
							$this->buildRow($variation, $settings);
							$lines = $lines +1;
						}
						catch(\Throwable $throwable)
						{
							$this->getLogger(__METHOD__)->error('ElasticExportKuponaDE::logs.fillRowError', [
								'Error message ' => $throwable->getMessage(),
								'Error line'    => $throwable->getLine(),
								'VariationId'   => $variation['id']
							]);
						}
					}
				}
			}while ($elasticSearch->hasNext());
		}
    }

	/**
	 * Sets the csv header
	 */
    private function setHeader()
	{
		$this->addCSVContent([
			'prod_number',
			'prod_name',
			'prod_price',
			'prod_price_old',
			'currency_symbol',
			'prod_url',
			'category',
			'category_url',
			'valid_from_date',
			'valid_to_date',
			'prod_description',
			'prod_description_long',
			'img_small',
			'img_medium',
			'img_large',
			'ean_code',
			'versandkosten',
			'lieferzeit',
			'platform',
			'grundpreis',

		]);
	}

	/**
	 * Builds a row for each variation
	 *
	 * @param $variation
	 * @param $settings
	 */
	private function buildRow($variation, $settings)
	{
		// Get and set the price and rrp
		$priceList = $this->elasticExportPriceHelper->getPriceList($variation, $settings);

		$price = $priceList['price'];
		$rrp = '';

		if((float)$price > 0 && (float)$priceList['recommendedRetailPrice'] > (float)$price)
		{
			$rrp = $priceList['recommendedRetailPrice'];
		}

		$currency = '';
		if($price > 0)
		{
			$currency = $priceList['currency'];
		}

		// Get shipping costs
		$shippingCost = "";

		if (isset($variation['data']['item']['id'])) {
			if (isset($this->shippingCostCache[$variation['data']['item']['id']]['shippingCost'])) {
				$shippingCost = $this->shippingCostCache[$variation['data']['item']['id']]['shippingCost'];
			} else {
				$shippingCost = $this->getShippingCost($variation['data']['item']['id'], $settings);
			}
		}

		$imageList = $this->elasticExportHelper->getImageListInOrder(
			$variation,
			$settings,
			0,
			$this->elasticExportHelper::VARIATION_IMAGES,
			$this->elasticExportHelper::SIZE_NORMAL, true
		);

		$previewUrls = '';
		$middleUrls = '';
		$normalUrls = '';
		$iteration = 1;
		foreach($imageList as $image)
		{
			if($iteration == 1)
			{
				$previewUrls = $previewUrls . $image['urlPreview'];
				$middleUrls = $middleUrls . $image['urlMiddle'];
				$normalUrls = $normalUrls . $image['url'];
			}
			else
			{
				$previewUrls = $previewUrls . ';'.$image['urlPreview'];
				$middleUrls = $middleUrls . ';'.$image['urlMiddle'];
				$normalUrls = $normalUrls . ';'.$image['url'];
			}

			$iteration ++;
		}

		$data = [
			'prod_number'           => $variation['id'],
			'prod_name'             => $this->elasticExportHelper->getMutatedName($variation, $settings),
			'prod_price'            => $price,
			'prod_price_old'        => $rrp,
			'currency_symbol'       => $currency,
			'prod_url'              => $this->elasticExportHelper->getMutatedUrl($variation, $settings, true, false),
			'category'              => $this->elasticExportHelper->getCategory((int)$variation['data']['defaultCategories'][0]['id'], $settings->get('lang'), $settings->get('plentyId')),
			'category_url'          => '',
			'valid_from_date'       => '',
			'valid_to_date'         => '',
			'prod_description'      => $this->elasticExportHelper->getMutatedPreviewText($variation, $settings, 256),
			'prod_description_long' => $this->elasticExportHelper->getMutatedDescription($variation, $settings, 256),
			'img_small'             => $previewUrls,
			'img_medium'            => $middleUrls,
			'img_large'             => $normalUrls,
			'ean_code'              => $this->elasticExportHelper->getBarcodeByType($variation, $settings->get('barcode')),
			'versandkosten'         => (string)$shippingCost,
			'lieferzeit'            => $this->elasticExportHelper->getAvailability($variation, $settings),
			'platform'              => '',
			'grundpreis'            => $this->elasticExportPriceHelper->getBasePrice($variation, (float)$price, $settings->get('lang'), '/', false, true, $priceList['currency']),

		];

		$this->addCSVContent(array_values($data));
	}

	/**
	 * @param int $itemId
	 * @param KeyValue $settings
	 * @return string
	 */
    private function getShippingCost($itemId, $settings):string {
		$shippingCost = $this->elasticExportHelper->getShippingCost($itemId, $settings);
		if(!is_null($shippingCost)) {
			$shippingCost = number_format((float)$shippingCost, 2, '.', '');
		} else {
			$shippingCost = '';
		}

		$this->shippingCostCache[$itemId] = $shippingCost;

		return $shippingCost;
	}
}
