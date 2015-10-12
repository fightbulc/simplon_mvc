<?php

namespace Simplon\Mvc\App\Constants;

/**
 * Class AssetsConstants
 * @package Simplon\Mvc\App\Constants
 */
class AssetsConstants
{
    const BASE_APP = '/assets';
    const BASE_VENDOR = self::BASE_APP . '/vendor';

    const BLOCK_VENDOR = 'vendor';
    const BLOCK_PAGE = 'page';
    const BLOCK_PARTIAL = 'partial';
    const BLOCK_JSCODE_BEFORE = 'before';
    const BLOCK_JSCODE_AFTER = 'after';

    /**
     * vendor related assets
     */
    const VENDOR_CSS_NORMALIZE = self::BASE_VENDOR . '/normalize/current/normalize.css';
    const VENDOR_CSS_FLEXBOXGRID = self::BASE_VENDOR . '/flexboxgrid/current/flexboxgrid.min.css';
    const VENDOR_JS_VUEJS = self::BASE_VENDOR . '/vuejs/current/vue.min.js';
    const VENDOR_JS_QWEST = self::BASE_VENDOR . '/qwest/current/qwest.min.js';

    /**
     * app related assets
     */
    const APP_CSS_BASE = self::BASE_APP . '/css/backoffice/base.css';
    const APP_JS_BASE = self::BASE_APP . '/js/backoffice/base.js';
}