<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\GojekTbl;
    use app\models\search\GojekDriverPresenceSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* GojekDriverPresenceController implements the CRUD actions for GojekTbl model.
*/
class GojekDriverPresenceController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all GojekTbl models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new GojekDriverPresenceSearch;
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
* Displays a single GojekTbl model.
* @param string $GOJEK_ID
*
* @return mixed
*/
public function actionView($GOJEK_ID)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($GOJEK_ID),
]);
}

/**
* Creates a new GojekTbl model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new GojekTbl;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'GOJEK_ID' => $model->GOJEK_ID]);
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
* Updates an existing GojekTbl model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param string $GOJEK_ID
* @return mixed
*/
public function actionUpdate($GOJEK_ID)
{
$model = $this->findModel($GOJEK_ID);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing GojekTbl model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param string $GOJEK_ID
* @return mixed
*/
public function actionDelete($GOJEK_ID)
{
try {
$this->findModel($GOJEK_ID)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$GOJEK_ID',',');
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
* Finds the GojekTbl model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param string $GOJEK_ID
* @return GojekTbl the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($GOJEK_ID)
{
if (($model = GojekTbl::findOne($GOJEK_ID)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
