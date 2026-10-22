<?php

declare(strict_types=1);

namespace Pyz\Zed\AntelopeLocationGui;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class AntelopeLocationGuiConfig extends AbstractBundleConfig
{
    public const string URL_ANTELOPE_LOCATION_LIST = '/antelope-location-gui/index';
    public const string URL_ANTELOPE_LOCATION_CREATE = '/antelope-location-gui/index/create';
    public const string URL_ANTELOPE_LOCATION_EDIT = '/antelope-location-gui/index/edit';
    public const string PARAM_ID_LOCATION = 'id-location';
}