<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\ShippingMonthlySummary;
    use app\models\search\ShippingMonthlySummarySearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* ShippingMonthlySummaryController implements the CRUD actions for ShippingMonthlySummary model.
*/
class ShippingMonthlySummaryController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all ShippingMonthlySummary models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new ShippingMonthlySummarySearch;
    $dataProvider = $searchModel->search($_GET);

Tabs::clearLocalStorage();

Url::remember();
\Yii::$app->session['__crudReturnUrl'] = null;

return $this->render('index', [
'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
]);
}

/**
* Displays a single ShippingMonthlySummary model.
* @param string $period
*
* @return mixed
*/
public function actionView($period)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($period),
]);
}

/**
* Creates a new ShippingMonthlySummary model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new ShippingMonthlySummary;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'period' => $model->period]);
} elseif (!\Yii::$app->request->isPost) {
$model->load($_GET);
}
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
$model->addError('_exception', $msg);
}
return $this->render('create', ['model' => $model]);
}

/**
* Updates an existing ShippingMonthlySummary model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param string $period
* @return mixed
*/
public function actionUpdate($period)
{
$model = $this->findModel($period);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing ShippingMonthlySummary model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param string $period
* @return mixed
*/
public function actionDelete($period)
{
try {
$this->findModel($period)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$period',',');
if ($isPivot == true) {
return $this->redirect(Url::previous());
} elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
Url::remember(null);
$url = \Yii::$app->session['__crudReturnUrl'];
\Yii::$app->session['__crudReturnUrl'] = null;

return $this->redirect($url);
} else {
return $this->redirect(['index']);
}
}

/**
* Finds the ShippingMonthlySummary model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param string $period
* @return ShippingMonthlySummary the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($period)
{
if (($model = ShippingMonthlySummary::findOne($period)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
