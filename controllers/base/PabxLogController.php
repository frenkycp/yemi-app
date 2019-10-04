<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\PabxLog;
    use app\models\search\PabxLogSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* PabxLogController implements the CRUD actions for PabxLog model.
*/
class PabxLogController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all PabxLog models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new PabxLogSearch;
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
* Displays a single PabxLog model.
* @param integer $seq
*
* @return mixed
*/
public function actionView($seq)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($seq),
]);
}

/**
* Creates a new PabxLog model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new PabxLog;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'seq' => $model->seq]);
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
* Updates an existing PabxLog model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $seq
* @return mixed
*/
public function actionUpdate($seq)
{
$model = $this->findModel($seq);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing PabxLog model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $seq
* @return mixed
*/
public function actionDelete($seq)
{
try {
$this->findModel($seq)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$seq',',');
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
* Finds the PabxLog model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $seq
* @return PabxLog the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($seq)
{
if (($model = PabxLog::findOne($seq)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
