<?php


namespace humhub\modules\custom_pages\assets;


use yii\web\AssetBundle;
use yii\web\View;

class CodeMirrorAssetBundle extends AssetBundle
{
    /**
     * v1.5 compatibility defer script loading
     *
     * Migrate to HumHub AssetBundle once minVersion is >=1.5
     *
     * @var bool
     */
    public $defer = true;

    public $jsOptions = ['position' => View::POS_HEAD];
    public $sourcePath = '@custom_pages/resources/codemirror';

    public $js = [
        'codemirror.js',
        'addon/hint/show-hint.js',
        'addon/hint/html-hint.js',
        'addon/hint/xml-hint.js',
        'mode/xml.js',
        'mode/javascript.js',
        'mode/css.js',
        'mode/htmlmixed.js',
    ];

    public $css = [
        'codemirror.css',
        'addon/hint/show-hint.css'
    ];

}