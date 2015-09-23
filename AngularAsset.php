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
 * Extra bundles (optional) can be configured via AssetManager:
 *
 * ```php
 * 'assetManager' => [
 *      'bundles' => [
 *          'yii\angularjs\AngularAsset' => [
 *              'extraBundles' => ['angular-ui-router'],
 *          ]
 *     ],
 *  ],
 * ```
 *
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
    ];

    public $extraBundles = [];

    public $locale;

    public $vendorFiles = [
        '@vendor/bower/angular/angular',
        '@vendor/bower/angular-resource/angular-resource',
        '@vendor/bower/angular-ui-router/release/angular-ui-router',
        '@vendor/bower/angular-gettext/dist/angular-gettext',
        '@vendor/bower/angular-mocks/angular-mocks',
        '@vendor/bower/ngprogress/build/ngprogress',
        '@vendor/bower/angular-sanitize/angular-sanitize',
        '@vendor/bower/angular-ui-bootstrap-bower/ui-bootstrap',
        '@vendor/bower/angular-ui-bootstrap-bower/ui-bootstrap-tpls',
        '@vendor/bower/angular-combine/dist',
    ];

    /**
     * Initalize
     */
    public function init()
    {
        $this->locales = is_array($this->locales) ? $this->locales : [$this->locales];
        if (!empty($this->locale)) {
            $this->vendorFiles[] = '@vendor/bower/angular-i18n/angular-locale_' . $this->locale;
            $this->jsSources[] = 'angular-locale_' . $this->locale;
        }

        foreach ($this->extraBundles as $extraBundle) {
            $this->jsSources[] = $extraBundle;
        }

        $this->publishOptions['beforeCopy'] = [$this, 'beforeCopyAssets'];
        $this->js = array_map(function ($js) {
            return $js . '.js';
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
                $srcPath = Yii::getAlias($sourcePath . $ext);
                if (!file_exists($srcPath)) {
                    $srcPath = Yii::getAlias($sourcePath . '.js');
                }
                $destPath = $destDir . DIRECTORY_SEPARATOR . basename($srcPath);
                copy($srcPath, $destPath);
            }
        }
        return true;
    }
}
