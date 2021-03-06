<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\CrusherTbl;
    use app\models\search\CrusherTblSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* CrusherTblController implements the CRUD actions for CrusherTbl model.
*/
class CrusherTblController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all CrusherTbl models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new CrusherTblSearch;
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
* Displays a single CrusherTbl model.
* @param integer $trans_id
*
* @return mixed
*/
public function actionView($trans_id)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($trans_id),
]);
}

/**
* Creates a new CrusherTbl model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
	date_default_timezone_set('Asia/Jakarta');
$model = new CrusherTbl;

try {
	$model->created_datetime = date('Y-m-d H:i:s');
	$model->created_by_id = \Yii::$app->user->identity->username;
	$model->created_by_name = \Yii::$app->user->identity->name;
if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
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
* Updates an existing CrusherTbl model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $trans_id
* @return mixed
*/
public function actionUpdate($trans_id)
{
	date_default_timezone_set('Asia/Jakarta');
$model = $this->findModel($trans_id);
$model->date = date('Y-m-d', strtotime($model->date));
$model->modified_datetime = date('Y-m-d H:i:s');
	$model->modified_by_id = \Yii::$app->user->identity->username;
	$model->modified_by_name = \Yii::$app->user->identity->name;

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing CrusherTbl model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $trans_id
* @return mixed
*/
public function actionDelete($trans_id)
{
try {
$this->findModel($trans_id)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$trans_id',',');
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
* Finds the CrusherTbl model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $trans_id
* @return CrusherTbl the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($trans_id)
{
if (($model = CrusherTbl::findOne($trans_id)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
