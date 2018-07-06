<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\SplHdr;
    use app\models\search\HrgaSplDataSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* HrgaSplDataController implements the CRUD actions for SplHdr model.
*/
class HrgaSplDataController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all SplHdr models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new HrgaSplDataSearch;
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
* Displays a single SplHdr model.
* @param string $SPL_HDR_ID
*
* @return mixed
*/
public function actionView($SPL_HDR_ID)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($SPL_HDR_ID),
]);
}

/**
* Creates a new SplHdr model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new SplHdr;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'SPL_HDR_ID' => $model->SPL_HDR_ID]);
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
* Updates an existing SplHdr model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param string $SPL_HDR_ID
* @return mixed
*/
public function actionUpdate($SPL_HDR_ID)
{
$model = $this->findModel($SPL_HDR_ID);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing SplHdr model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param string $SPL_HDR_ID
* @return mixed
*/
public function actionDelete($SPL_HDR_ID)
{
try {
$this->findModel($SPL_HDR_ID)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$SPL_HDR_ID',',');
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
* Finds the SplHdr model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param string $SPL_HDR_ID
* @return SplHdr the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($SPL_HDR_ID)
{
if (($model = SplHdr::findOne($SPL_HDR_ID)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
