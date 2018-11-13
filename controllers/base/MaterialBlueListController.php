<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\models\VisualPickingList;
    use app\models\search\MaterialBlueListSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* MaterialBlueListController implements the CRUD actions for VisualPickingList model.
*/
class MaterialBlueListController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;


/**
* Lists all VisualPickingList models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new MaterialBlueListSearch;
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
* Displays a single VisualPickingList model.
* @param integer $seq_no
*
* @return mixed
*/
public function actionView($seq_no)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($seq_no),
]);
}

/**
* Creates a new VisualPickingList model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new VisualPickingList;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'seq_no' => $model->seq_no]);
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
* Updates an existing VisualPickingList model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $seq_no
* @return mixed
*/
public function actionUpdate($seq_no)
{
$model = $this->findModel($seq_no);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing VisualPickingList model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $seq_no
* @return mixed
*/
public function actionDelete($seq_no)
{
try {
$this->findModel($seq_no)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$seq_no',',');
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
* Finds the VisualPickingList model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $seq_no
* @return VisualPickingList the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($seq_no)
{
if (($model = VisualPickingList::findOne($seq_no)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
