<?php

namespace ElasticExportKuponaDE;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\DataExchangeServiceProvider;


/**
 * Class ElasticExportKuponaDEServiceProvider
 * @package ElasticExportKuponaDE
 */
class ElasticExportKuponaDEServiceProvider extends DataExchangeServiceProvider
{
    /**
     * Abstract function for registering the service provider.
     */
    public function register()
    {

    }

    /**
     * Adds the export format to the export container.
     *
     * @param ExportPresetContainer $container
     */
    public function exports(ExportPresetContainer $container)
    {
        $container->add(
            'KuponaDE-Plugin',
            'ElasticExportKuponaDE\ResultField\KuponaDE',
            'ElasticExportKuponaDE\Generator\KuponaDE',
            '',
            true
        );
    }
}