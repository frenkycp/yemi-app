<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\KlinikInput;
    use app\models\search\ClinicDataSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* ClinicDataController implements the CRUD actions for KlinikInput model.
*/
class ClinicDataController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all KlinikInput models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new ClinicDataSearch;
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
* Displays a single KlinikInput model.
* @param string $pk
*
* @return mixed
*/
public function actionView($pk)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($pk),
]);
}

/**
* Creates a new KlinikInput model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new KlinikInput;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'pk' => $model->pk]);
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
* Updates an existing KlinikInput model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param string $pk
* @return mixed
*/
public function actionUpdate($pk)
{
$model = $this->findModel($pk);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing KlinikInput model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param string $pk
* @return mixed
*/
public function actionDelete($pk)
{
try {
$this->findModel($pk)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$pk',',');
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
* Finds the KlinikInput model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param string $pk
* @return KlinikInput the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($pk)
{
if (($model = KlinikInput::findOne($pk)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
