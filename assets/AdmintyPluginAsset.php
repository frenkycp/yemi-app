<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdmintyPluginAsset extends AssetBundle
{
	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'adminty_assets/css/bootstrap.min.css',
    	'adminty_assets/css/style.css',
    ];
    public $js = [
		/*'/adminty_assets/js/jquery.simplyCountable.js',
		'/adminty_assets/js/twitter-text.js',
		'/adminty_assets/js/twitter_count.js',  
		'/adminty_assets/js/status-counter.js',*/
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}