<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\SkillMasterKaryawan;
    use app\models\search\SkillMapDataSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* SkillMapDataController implements the CRUD actions for SkillMasterKaryawan model.
*/
class SkillMapDataController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all SkillMasterKaryawan models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new SkillMapDataSearch;
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
* Displays a single SkillMasterKaryawan model.
* @param string $ID
*
* @return mixed
*/
public function actionView($ID)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($ID),
]);
}

/**
* Creates a new SkillMasterKaryawan model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new SkillMasterKaryawan;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'ID' => $model->ID]);
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
* Updates an existing SkillMasterKaryawan model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param string $ID
* @return mixed
*/
public function actionUpdate($ID)
{
$model = $this->findModel($ID);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing SkillMasterKaryawan model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param string $ID
* @return mixed
*/
public function actionDelete($ID)
{
try {
$this->findModel($ID)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$ID',',');
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
* Finds the SkillMasterKaryawan model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param string $ID
* @return SkillMasterKaryawan the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($ID)
{
if (($model = SkillMasterKaryawan::findOne($ID)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
