<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
	    div.centered 
		{
		    text-align: center;
		}

		div.centered table 
		{
		    margin: 0 auto; 
		    text-align: left;
		}

		.summary-tbl{
	        border-top: 0;
	        border-collapse: collapse;
	        border-spacing: 0;
	    }
	    .summary-tbl tbody tr td{
	        border:1px solid #777474;
	        font-size: 14px;
	        background: white;
	        color: black;
	        vertical-align: middle;
	        letter-spacing: 1.1px;
	    }
	    .summary-tbl thead tr th{
	        border:1px solid #777474 !important;
	        background-color: rgb(255, 229, 153);
	        color: black;
	        font-size: 16px;
	        vertical-align: middle;
	    }
	     .tbl-header{
	        border:1px solid #8b8c8d !important;
	        background-color: #518469 !important;
	        color: black !important;
	        font-size: 16px !important;
	        border-bottom: 7px solid #797979 !important;
	        vertical-align: middle !important;
	    }
	    .summary-tbl tfoot tr td{
	        border:1px solid #777474;
	        font-size: 16px;
	        background: silver;
	        color: black;
	        vertical-align: middle;
	        /*padding: 20px 10px;*/
	        letter-spacing: 1.1px;
	    }
	    .text-center {text-align: center;}
	    .text-red {color: #dd4b39;}
    </style>
</head>
<body>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
