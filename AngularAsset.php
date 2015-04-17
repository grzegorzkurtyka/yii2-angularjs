<?php
/**
 * @link http://schibsted.pl/
 * @copyright Copyright (c) 2014 TesJin Group
 * @copyright Copyright (c) 2015 Schibsted Tech Polska
 * @license BSD-3-Clause
 */

namespace yii\angularjs;

use yii;
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
        'angular-resource',
        'angular-ui-router',
    ];

    public $vendorFiles = [
        '@vendor/bower/angular/angular',
        '@vendor/bower/angular-resource/angular-resource',
        '@vendor/bower/angular-ui-router/release/angular-ui-router',
    ];

    /**
     * Initalize
     */
    public function init()
    {
        $this->publishOptions['beforeCopy'] = [$this, 'beforeCopyAssets'];
        $this->js = array_map(function ($js) {
            return YII_DEBUG ? $js . '.js' : $js . '.min.js';
        }, $this->jsSources);
        parent::init();
    }

    /**
     * Copy defined files from other vendors
     *
     * @return bool
     */
    public function beforeCopyAssets()
    {
        $destDir = Yii::getAlias($this->sourcePath);
        $exts = ['.js', '.min.js'];

        foreach ($this->vendorFiles as $sourcePath) {
            foreach ($exts as $ext) {
                $srcPath = Yii::getAlias($sourcePath . $exts);
                $destPath = $destDir . DIRECTORY_SEPARATOR . basename($srcPath);
                copy($srcPath, $destPath);
            }
        }
        return true;
    }
}
