<?php

namespace ElasticExportKuponaDE\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;
use Plenty\Modules\Helper\Models\KeyValue;


/**
 * Class KuponaDE
 * @package ElasticExportKuponaDE\Generator
 */
class KuponaDE extends CSVPluginGenerator
{
    /**
     * @var ElasticExportCoreHelper
     */
    private $elasticExportCoreHelper;

    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

    /**
     * @var array
     */
    private $idlVariations = array();


    /**
     * KuponaDE constructor.
     * @param ArrayHelper $arrayHelper
     */
    public function __construct(ArrayHelper $arrayHelper)
    {
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * Generates and populates the data into the CSV file.
     *
     * @param array $resultData
     * @param array $formatSettings
     */
    protected function generatePluginContent($resultData, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportCoreHelper = pluginApp(ElasticExportCoreHelper::class);

        if(is_array($resultData) && count($resultData['documents']) > 0)
        {
            $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

            $this->setDelimiter(";");

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

            // Create a List with all VariationIds
            $variationIdList = array();
            foreach($resultData['documents'] as $variation)
            {
                $variationIdList[] = $variation['id'];
            }

            // Get the missing ES fields from IDL(ItemDataLayer)
            if(is_array($variationIdList) && count($variationIdList) > 0)
            {
                /**
                 * @var \ElasticExportKuponaDE\IDL_ResultList\KuponaDE $idlResultList
                 */
                $idlResultList = pluginApp(\ElasticExportKuponaDE\IDL_ResultList\KuponaDE::class);
                $idlResultList = $idlResultList->getResultList($variationIdList, $settings, $filter);
            }

            // Creates an array with the variationId as key to surpass the sorting problem
            if(isset($idlResultList) && $idlResultList instanceof RecordList)
            {
                $this->createIdlArray($idlResultList);
            }

            foreach($resultData['documents'] as $variation)
            {
                // Get and set the price and rrp
                $price = number_format((float)$this->idlVariations[$variation['id']]['variationRecommendedRetailPrice.price'], 2, '.', '');
                $rrp = number_format((float)$this->elasticExportCoreHelper->getRecommendedRetailPrice($this->idlVariations[$variation['id']]['variationRecommendedRetailPrice.price'], $settings), 2, '.', '');

                // Get shipping costs
                $shippingCost = $this->elasticExportCoreHelper->getShippingCost($variation['data']['item']['id'], $settings);
                if(!is_null($shippingCost))
                {
                    $shippingCost = number_format((float)$shippingCost, 2, ',', '');
                }
                else
                {
                    $shippingCost = '';
                }

                $data = [
                    'prod_number'           => $variation['id'],
                    'prod_name'             => $this->elasticExportCoreHelper->getName($variation, $settings),
                    'prod_price'            => $price,
                    'prod_price_old'        => $rrp,
                    'currency_symbol'       => $this->idlVariations[$variation['id']]['variationRecommendedRetailPrice.currency'],
                    'prod_url'              => $this->elasticExportCoreHelper->getUrl($variation, $settings, true, false),
                    'category'              => $this->elasticExportCoreHelper->getCategory((int)$variation['data']['defaultCategories'][0]['id'], $settings->get('lang'), $settings->get('plentyId')),
                    'category_url'          => '',
                    'valid_from_date'       => '',
                    'valid_to_date'         => '',
                    'prod_description'      => $this->elasticExportCoreHelper->getPreviewText($variation, $settings, 256),
                    'prod_description_long' => $this->elasticExportCoreHelper->getDescription($variation, $settings, 256),
                    'img_small'             => $this->getImages($variation, $settings, ';', 'preview'),
                    'img_medium'            => $this->getImages($variation, $settings, ';', 'middle'),
                    'img_large'             => $this->getImages($variation, $settings, ';', 'normal'),
                    'ean_code'              => $variation['data']['barcodes']['code'],
                    'versandkosten'         => $shippingCost,
                    'lieferzeit'            => $this->elasticExportCoreHelper->getAvailability($variation, $settings),
                    'platform'              => '',
                    'grundpreis'            => $this->elasticExportCoreHelper->getBasePrice($variation, $this->idlVariations[$variation['id']], $settings->get('lang')),

                ];

                $this->addCSVContent(array_values($data));
            }
        }
    }

    /**
     * Get images.
     *
     * @param  array    $variation
     * @param  KeyValue $settings
     * @param  string   $separator = ','
     * @param  string   $imageType = 'normal'
     * @return string
     */
    public function getImages($variation, KeyValue $settings, string $separator = ',', string $imageType = 'normal'):string
    {
        $list = $this->elasticExportCoreHelper->getImageList($variation, $settings, $imageType);

        if(count($list))
        {
            return implode($separator, $list);
        }

        return '';
    }

    /**
     * Creates an array with the rest of data needed from the ItemDataLayer.
     *
     * @param RecordList $idlResultList
     */
    private function createIdlArray($idlResultList)
    {
        if($idlResultList instanceof RecordList)
        {
            foreach($idlResultList as $idlVariation)
            {
                if($idlVariation instanceof Record)
                {
                    $this->idlVariations[$idlVariation->variationBase->id] = [
                        'itemBase.id' => $idlVariation->itemBase->id,
                        'variationBase.id' => $idlVariation->variationBase->id,
                        'variationRetailPrice.price' => $idlVariation->variationRetailPrice->price,
                        'variationRetailPrice.currency' => $idlVariation->variationRetailPrice->currency,
                        'variationRecommendedRetailPrice.price' => $idlVariation->variationRecommendedRetailPrice->price,
                    ];
                }
            }
        }
    }
}
