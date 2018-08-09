<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\Html;

/**
* This is the class for controller "MntMinimumStockController".
*/
class MntMinimumStockController extends \app\controllers\base\MntMinimumStockController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionGetImagePreview($urutan)
	{
		//return \Yii::$app->urlManager->createUrl('uploads/NG_MNT/' . $urutan . '.jpg');
		//$src = \Yii::$app->request->BaseUrl . '/uploads/NG_MNT/' . $urutan . '.jpg';
		//$src = \Yii::$app->basePath. '\uploads\NG_MNT\\' . $urutan . '.jpg';
		$src = Html::img('http://wsus:81/product_image/' . $urutan . '.jpg', ['width' => '100%']);
		//return $src;
		return '<div class="text-center"><span><b>' . $urutan . '</b></span><hr>' . Html::img('http://wsus:81/product_image/' . $urutan . '.jpg',
			[
				'width' => '100%',
				'alt' => $urutan . '.jpg not found.'
			]) . '</div>';
		if (@getimagesize($src)) {
			return Html::img('@web/uploads/NG_MNT/' . $urutan . '.jpg', ['width' => '100%']);
		}
		return 'No Image Found...';
	}
}
