<?php

use kartik\tree\TreeView;
use app\models\MenuTreeCustom;
use yii\web\View;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'MITA Menu (Simplified) <span class="japanesse light-green"></span>',
    'tab_title' => 'MITA Menu (Simplified)',
    'breadcrumbs_title' => 'MITA Menu (Simplified)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$script = "
    $('document').ready(function() {
        $('#tree-id').on('treeview:beforeselect', function(event, key, data, textStatus, jqXHR) {
		    console.log(key);
		    $.ajax({
	            type: 'POST',
	            url: '" . Url::to(['display/get-tree-url']) . "?id='+key,
	            success: function(return_data){
	                //alert(return_data);
	                if(return_data != null) {
	                	window.open(return_data);
	                } else {
	                	//alert('No link...');
	                }
	            },
	        });
		});
    });
";
$this->registerJs($script, View::POS_HEAD );

$tree_arr = [
    // single query fetch to render the tree
    // use the Product model you have in the previous step
    'query' => MenuTreeCustom::find()->addOrderBy('root, lft'), 
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
    'rootOptions' => ['label'=>'<span class="text-primary">MITA Menu</span>'],
    'options' => [
    	'id' => 'tree-id'
    ],
];

if (\Yii::$app->user->identity->role_id == 1) {
	$tree_arr = [
	    // single query fetch to render the tree
	    // use the Product model you have in the previous step
	    'query' => MenuTreeCustom::find()->addOrderBy('root, lft'), 
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
	    'rootOptions' => ['label'=>'<span class="text-primary">MITA Menu</span>'],
	    'options' => [
	    	'id' => 'tree-id'
	    ],
	];
}

echo TreeView::widget($tree_arr);