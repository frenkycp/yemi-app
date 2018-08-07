<?php

namespace app\controllers;

use Yii;
use app\models\PlanReceiving;
use app\models\search\PlanReceivingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * PlanReceivingController implements the CRUD actions for PlanReceiving model.
 */
class PlanReceivingController extends Controller
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    /**
     * Lists all PlanReceiving models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanReceivingSearch();
        $searchModel->month_periode = date('Ym');
        if (Yii::$app->request->post('month_periode') !== null) {
            $searchModel->month_periode = Yii::$app->request->post('month_periode');
        }
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // validate if there is a editable input saved via AJAX
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $receiving_id = Yii::$app->request->post('editableKey');
            $model = PlanReceiving::findOne(['id' => $receiving_id]);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            $posted = current($_POST['PlanReceiving']);
            $post = ['PlanReceiving' => $posted];

            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();
                $output = '';

                if (isset($posted['unloading_time'])) {
                    $output = $model->unloading_time;
                }

                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlanReceiving model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PlanReceiving model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('Asia/Jakarta');
        $model = new PlanReceiving();

        if ($model->load(Yii::$app->request->post())) {
            $model->month_periode = date('Ym', strtotime($model->receiving_date));
            $model->created_date = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            if ($model->save()) {
                //return $this->redirect(['view', 'id' => $model->id]);
                return $this->redirect(['index']);
            }else {
                return json_encode($model->errors());
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PlanReceiving model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->month_periode = date('Ym', strtotime($model->receiving_date));
            $model->last_modified_date = date('Y-m-d H:i:s');
            $model->last_modified_by = Yii::$app->user->identity->id;
            if ($model->save()) {
                //return $this->redirect(['view', 'id' => $model->id]);
                return $this->redirect(['index']);
            }else {
                return json_encode($model->errors());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PlanReceiving model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $model = $this->findModel($id);
        $model->flag = 0;
        $model->deleted_date = date('Y-m-d H:i:s');
        $model->deleted_by = Yii::$app->user->identity->id;

        if ($model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }else {
            return json_encode($model->errors());
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlanReceiving model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PlanReceiving the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlanReceiving::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
