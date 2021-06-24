<?php
namespace app\controllers;

use app\models\TreeAccDigilibExtend;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
 * summary
 */
class AccDigilibController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionGetTreeUrl($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $menu = TreeAccDigilibExtend::findOne($id);
        return $menu->url;
    }
    
    public function actionIndex()
    {
		return $this->render('index');
    }
}