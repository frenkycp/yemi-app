<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\TpPartList;
    use app\models\search\TpPartListSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* TpPartListController implements the CRUD actions for TpPartList model.
*/
class TpPartListController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all TpPartList models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new TpPartListSearch;
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
* Displays a single TpPartList model.
* @param integer $tp_part_list_id
*
* @return mixed
*/
public function actionView($tp_part_list_id)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($tp_part_list_id),
]);
}

/**
* Creates a new TpPartList model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new TpPartList;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'tp_part_list_id' => $model->tp_part_list_id]);
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
* Updates an existing TpPartList model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $tp_part_list_id
* @return mixed
*/
public function actionUpdate($tp_part_list_id)
{
$model = $this->findModel($tp_part_list_id);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing TpPartList model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $tp_part_list_id
* @return mixed
*/
public function actionDelete($tp_part_list_id)
{
try {
$this->findModel($tp_part_list_id)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$tp_part_list_id',',');
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
* Finds the TpPartList model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $tp_part_list_id
* @return TpPartList the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($tp_part_list_id)
{
if (($model = TpPartList::findOne($tp_part_list_id)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
