<?php

use kartik\tree\TreeView;
use app\models\TreeAccDigilibExtend;
use yii\web\View;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'Accounting Digital Library <span class="japanesse light-green"></span>',
    'tab_title' => 'Accounting Digital Library',
    'breadcrumbs_title' => 'Accounting Digital Library'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$script = "
    $('document').ready(function() {
        $('#tree-id').on('treeview:beforeselect', function(event, key, data, textStatus, jqXHR) {
		    console.log(key);
		    $.ajax({
	            type: 'POST',
	            url: '" . Url::to(['get-tree-url']) . "?id='+key,
	            success: function(return_data){
	                //alert(return_data);
	                if(return_data != null) {
	                	window.open(return_data);
	                } else {
	                	return false;
	                	//alert('No link...');
	                }
	            },
	        });
		});
    });
";
$this->registerJs($script, View::POS_HEAD );

if (\Yii::$app->user->identity->role_id == 1 || \Yii::$app->user->identity->role_id == 37) {
	$tree_arr = [
	    // single query fetch to render the tree
	    // use the Product model you have in the previous step
	    'query' => TreeAccDigilibExtend::find()->addOrderBy('root, lft'), 
	    'headingOptions' => ['label' => 'Menu'],
	    'fontAwesome' => true,     // optional
	    'isAdmin' => true,         // optional (toggle to enable admin mode)
	    'displayValue' => 1,        // initial display value
	    'softDelete' => true,       // defaults to true
	    'cacheSettings' => [        
	        'enableCache' => true   // defaults to true
	    ],
	    'mainTemplate' => '
	    <div class="row">
		    <div class="col-sm-6">
		        {wrapper}
		    </div>
		    <div class="col-sm-6">
		        {detail}
		    </div>
		</div>
	    ',
	    'topRootAsHeading' => true,
	    'rootOptions' => ['label'=>'<span class="text-primary">Accounting Digital Library</span>'],
	    'options' => [
	    	'id' => 'tree-id'
	    ],
	];
} else {
	$tree_arr = [
	    // single query fetch to render the tree
	    // use the Product model you have in the previous step
	    'query' => TreeAccDigilibExtend::find()->addOrderBy('root, lft'), 
	    'headingOptions' => ['label' => 'Menu'],
	    'fontAwesome' => true,     // optional
	    'isAdmin' => false,         // optional (toggle to enable admin mode)
	    'displayValue' => 1,        // initial display value
	    'softDelete' => true,       // defaults to true
	    'cacheSettings' => [        
	        'enableCache' => true   // defaults to true
	    ],
	    'topRootAsHeading' => true,
	    'mainTemplate' => '<div class="row">
		    <div class="col-sm-12">
		        {wrapper}
		    </div>
		</div>',
		'wrapperTemplate' => '
			{header}
			{tree}
		',
	    'rootOptions' => ['label'=>'<span class="text-primary">Accounting Digital Library</span>'],
	    'options' => [
	    	'id' => 'tree-id'
	    ],
	];
}

echo TreeView::widget($tree_arr);