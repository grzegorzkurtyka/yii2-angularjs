<?php
/**
 * @link http://schibsted.pl/
 * @copyright Copyright (c) 2014 TesJin Group
 * @copyright Copyright (c) 2015 Schibsted Tech Polska
 * @license BSD-3-Clause
 */

namespace yii\angularjs;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the [angular javascript library](https://angularjs.org/)
 *
 * @author Vladislav Orlov <orlov@tesjin.ru>
 * @author Grzegorz Kurtyka <grzegorz.kurtyka@schibsted.pl>
 */
class AngularAsset extends AssetBundle
{
    public $sourcePath = '@vendor/grzegorzkurtyka/yii2-angularjs/js';

    public $jsSources = [
        'angular',
        'angular-animate',
        'angular-cookies',
        'angular-loader',
        'angular-mocks',
        'angular-resource',
        'angular-route',
        'angular-sanitize',
        'angular-scenario',
        'angular-touch',
    ];

    /**
     * Initializes the bundle.
     * Depending on debug settings enables non-minimzed versions of the files
     */
    public function init() {
        parent::init();
        $this->js = array_map(function($js) {
            return YII_DEBUG ? $js . '.js' : $js . '.min.js';
        }, $this->jsSources);
    }
}
