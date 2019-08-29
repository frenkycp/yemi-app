<?php

namespace app\controllers;

use app\models\search\MrbsEntrySearch;
use app\models\RoomTbl;
use app\models\RoomEventTbl;
use app\models\Karyawan;
use app\models\Visitor;
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
		$session = \Yii::$app->session;
        if (!$session->has('mrbs_user')) {
            return $this->redirect(['login']);
        }
        $room_tbl = RoomTbl::find()
        ->where([
        	'user_id' => $session['mrbs_user'],
        	'room_status' => 'NOT AVAILABLE'
        ])
        ->one();
        if ($room_tbl->room_id != null) {
        	return $this->redirect(['edit-member', 'room_id' => $room_tbl->room_id, 'event_id' => $room_tbl->event_id]);
        }
        
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

	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('mrbs_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = "adminty\my-hr-login";

        $model = new \yii\base\DynamicModel([
            'username', 'password'
        ]);
        $model->addRule(['username', 'password'], 'required');

        if($model->load(\Yii::$app->request->post())){
            $karyawan = Karyawan::find()
            ->where([
                'NIK' => $model->username,
                'PASSWORD' => $model->password,
            ])
            ->one();
            if ($karyawan->NIK !== null) {
                $session['mrbs_user'] = $model->username;
                $session['mrbs_name'] = $karyawan->NAMA_KARYAWAN;
                $room_tbl = RoomTbl::find()
                ->where([
                	'user_id' => $model->username,
                	'room_status' => 'NOT AVAILABLE'
                ])
                ->one();
                if ($room_tbl->room_id != null) {
                	return $this->redirect(['edit-member', 'room_id' => $room_tbl->room_id, 'event_id' => $room_tbl->event_id]);
                }
                return $this->redirect(['index']);
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Incorrect username or password...');
            }
            $model->username = null;
            $model->password = null;
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        $session = \Yii::$app->session;
        if ($session->has('mrbs_user')) {
            $session->remove('mrbs_user');
        }
        if ($session->has('mrbs_name')) {
            $session->remove('mrbs_name');
        }

        return $this->redirect(['login']);
    }

	public function actionStartMeeting($id)
	{
		$session = \Yii::$app->session;
        if (!$session->has('mrbs_user')) {
            return $this->redirect(['login']);
        }
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
		} else {
			if ($room_tbl->room_status == 'NOT AVAILABLE') {
				\Yii::$app->session->setFlash("warning", 'Failed to start. Room was used by another person ...');
				return $this->redirect(Url::previous());
			}
		}
		$room_tbl->room_id = $room_id;
		$room_tbl->event_id = $id;
		$room_tbl->room_desc = $room_desc;
		$room_tbl->room_event = $room_event;
		$room_tbl->room_status = 'NOT AVAILABLE';
		$room_tbl->pic = $pic;
		$room_tbl->user_id = $session['mrbs_user'];
		$room_tbl->user_desc = $session['mrbs_name'];
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
		$session = \Yii::$app->session;
        if (!$session->has('mrbs_user')) {
            return $this->redirect(['login']);
        }
		date_default_timezone_set('Asia/Jakarta');
		$this->layout = 'mrbs/main';
		$model = new \yii\base\DynamicModel([
		    'nik'
		]);
	    $model->addRule('nik', 'string',['max'=>32]);

        $room_tbl = RoomTbl::find()->where([
			'room_id' => $room_id
		])->one();

    	if($model->load(\Yii::$app->request->post())){
    		$room_event_tbl = RoomEventTbl::find()->where([
    			'nik' => $model->nik,
    			'room_id' => $room_id,
    			'event_id' => $event_id
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
    				$user_id = $session['mrbs_user'];
    				$user_desc = $session['mrbs_name'];

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

		$total_member = RoomEventTbl::find()
        ->where([
        	'room_id' => $room_id,
        	'event_id' => $event_id
        ])
        ->orderBy('last_update DESC')
        ->asArray()
        ->all();
		
		return $this->render('edit-member', [
			'model' => $model,
			'total_member' => $total_member,
			'room_tbl' => $room_tbl
		]);
	}

	public function actionAddVisitor()
	{
		$session = \Yii::$app->session;
        if (!$session->has('mrbs_user')) {
            return $this->redirect(['login']);
        }
		date_default_timezone_set('Asia/Jakarta');
		if (\Yii::$app->request->post('pk') !== null) {
			$pk = \Yii::$app->request->post('pk');
			$room_id = \Yii::$app->request->post('room_id');
			$room_desc = \Yii::$app->request->post('room_desc');
			$event_id = \Yii::$app->request->post('event_id');
			$start_time = date('Y-m-d H:i:s', \Yii::$app->request->post('start_time'));
			$end_time = date('Y-m-d H:i:s', \Yii::$app->request->post('end_time'));

			$visitor = Visitor::find()->where([
				'pk' => $pk
			])->one();

			$room_event_tbl = RoomEventTbl::find()->where([
    			'nik' => $visitor->visitor_id,
    			'room_id' => $room_id,
    			'event_id' => $event_id
    		])->one();

    		if ($room_event_tbl->seq != null) {
    			\Yii::$app->session->setFlash("warning", 'Visitor : ' . $visitor->visitor_name . ' from ' . $visitor->visitor_comp . ' is already a member...');
    		} else {
    			$user_id = $session['mrbs_user'];
				$user_desc = $session['mrbs_name'];

	    		$new_member = new RoomEventTbl();
	    		$new_member->event_id = $event_id;
	    		$new_member->member_category = 2;
	    		$new_member->company = $visitor->visitor_comp;
	    		$new_member->room_id = $room_id;
	    		$new_member->room_desc = $room_desc;
	    		$new_member->room_event = $room_event;
	    		$new_member->start_time = date('Y-m-d H:i:s', $start_time);
	    		$new_member->end_time = date('Y-m-d H:i:s', $end_time);
	    		$new_member->NIK = $visitor->visitor_id;
	    		$new_member->NAMA_KARYAWAN = $visitor->visitor_name;
	    		$new_member->user_id = $user_id;
	    		$new_member->user_desc = $user_desc;
	    		$new_member->last_update = date('Y-m-d H:i:s');

	    		if ($new_member->save()) {
	    			$visitor->meet = 1;
	    			if (!$visitor->save()) {
	    				return json_encode($visitor->errors());
	    			}
	    			\Yii::$app->session->setFlash("success", 'Visitor : ' . $visitor->visitor_name . ' from ' . $visitor->visitor_comp . ' has been added ...');
	    		} else {
	    			\Yii::$app->session->setFlash("danger", 'Failed : ' . json_encode($model->errors()));
	    		}
    		}

		}

		return $this->redirect(Url::to(['edit-member', 'room_id' => $room_id, 'event_id' => $event_id]));
	}

	public function actionFinishMeeting($room_id, $event_id)
	{
		$session = \Yii::$app->session;
        if (!$session->has('mrbs_user')) {
            return $this->redirect(['login']);
        }
		$room_tbl = RoomTbl::find()
		->where([
			'room_id' => $room_id,
			'event_id' => $event_id,
		])
		->one();

		$room_tbl->room_status = 'AVAILABLE';
		if (!$room_tbl->save()) {
			return json_encode($room_tbl->errors());
		}

		return $this->redirect(Url::to(['index']));
	}
}
