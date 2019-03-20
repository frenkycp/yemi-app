<?php

namespace app\controllers;

use app\models\search\MrbsEntrySearch;
use app\models\RoomTbl;
use app\models\RoomEventTbl;
use app\models\Karyawan;
use yii\web\Controller;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "MrbsEntryController".
*/
class MrbsEntryController extends \app\controllers\base\MrbsEntryController
{
	/**
	* Lists all MrbsEntry models.
	* @return mixed
	*/
	public function actionIndex()
	{
		$this->layout = 'mrbs/main';
	    $searchModel  = new MrbsEntrySearch;
	    if (\Yii::$app->request->get('tgl_start') == null) {
	    	$searchModel->tgl_start = date('Y-m-d');
	    }
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionStartMeeting($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->layout = 'mrbs/main';
		$mrbs_entry = $this->findModel($id);
		$room_id = '' . $mrbs_entry->room_id;
		$room_desc = $mrbs_entry->room->sort_key;
		$room_event = $mrbs_entry->name;
		$pic = $mrbs_entry->create_by;
		$start_time = date('Y-m-d H:i:s', $mrbs_entry->start_time);
		$end_time = date('Y-m-d H:i:s', $mrbs_entry->end_time);

		$room_tbl = RoomTbl::find()->where([
			'room_id' => $room_id
		])->one();

		if ($room_tbl->room_id == null) {
			$room_tbl = new RoomTbl();
		}
		$room_tbl->room_id = $room_id;
		$room_tbl->room_desc = $room_desc;
		$room_tbl->room_event = $room_event;
		$room_tbl->room_status = 'NOT AVAILABLE';
		$room_tbl->pic = $pic;
		$room_tbl->start_time = $start_time;
		$room_tbl->end_time = $end_time;

		if (!$room_tbl->save()) {
			\Yii::$app->session->setFlash("danger", 'Failed. Error : ' . json_encode($room_tbl->errors()));
			return $this->redirect(Url::previous());
		}

		return $this->redirect(Url::to(['edit-member', 'room_id' => $room_id, 'event_id' => $id]));
	}

	public function actionEditMember($room_id, $event_id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->layout = 'mrbs/main';
		$model = new \yii\base\DynamicModel([
		    'nik'
		]);
	    $model->addRule('nik', 'required')
	        ->addRule('nik', 'string',['max'=>32]);

        $total_member = RoomEventTbl::find()
        ->where([
        	'room_id' => $room_id,
        	'event_id' => $event_id
        ])
        ->asArray()
        ->all();

    	if($model->load(\Yii::$app->request->post())){
    		$room_event_tbl = RoomEventTbl::find()->where([
    			'nik' => $model->nik,
    			'room_id' => $room_id
    		])->one();

    		if ($room_event_tbl->seq != null) {
    			\Yii::$app->session->setFlash("warning", 'NIK : ' . $model->nik . ' is already a member...');
    		} else {
    			$karyawan = Karyawan::find()
    			->where(['NIK' => $model->nik])
    			->one();

    			if ($karyawan->NIK == null) {
    				\Yii::$app->session->setFlash("warning", 'NIK : ' . $model->nik . ' is not found...');
    			} else {
    				$user_id = '150826';
    				$user_desc = 'FRENKY CAHYA PURNAMA';
    				$room_tbl = RoomTbl::find()->where([
		    			'room_id' => $room_id
		    		])->one();

		    		$new_member = new RoomEventTbl();
		    		$new_member->event_id = $event_id;
		    		$new_member->room_id = $room_tbl->room_id;
		    		$new_member->room_desc = $room_tbl->room_desc;
		    		$new_member->room_event = $room_tbl->room_event;
		    		$new_member->start_time = date('Y-m-d H:i:s', $room_tbl->start_time);
		    		$new_member->end_time = date('Y-m-d H:i:s', $room_tbl->end_time);
		    		$new_member->NIK = $karyawan->NIK;
		    		$new_member->NAMA_KARYAWAN = $karyawan->NAMA_KARYAWAN;
		    		$new_member->user_id = $user_id;
		    		$new_member->user_desc = $user_desc;
		    		$new_member->last_update = date('Y-m-d H:i:s');

		    		if ($new_member->save()) {
		    			\Yii::$app->session->setFlash("success", 'NIK : ' . $model->nik . ' has been added...');
		    		} else {
		    			\Yii::$app->session->setFlash("danger", 'Failed : ' . json_encode($model->errors()));
		    		}

    			}
    			
    		}
    		$model->nik = null;

    		
	        // do somenthing with model
	        //return $this->redirect(['view']);
	    }
		
		
		return $this->render('edit-member', [
			'model' => $model,
			'total_member' => $total_member,
		]);
	}
}
