<?php

namespace app\controllers;

use app\models\Karyawan;
/**
* This is the class for controller "SkillMapDataController".
*/
class SkillMapDataController extends \app\controllers\base\SkillMapDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionSkillUpdate()
	{
		$model = new \yii\base\DynamicModel([
            'gmc', 'nik', 'skill_value', 'category'
        ]);
        $model->addRule(['gmc', 'nik', 'skill_value'], 'required');
        $model->skill_value = 3;

        if ($model->load($_POST)) {
        	$id = \Yii::$app->user->identity->username;
        	$tmp_karyawan = Karyawan::find()
        	->where([
        		'OR',
        		['NIK' => $id],
        		['NIK_SUN_FISH' => $id]
        	])
        	->one();

        	if ($tmp_karyawan->NIK_SUN_FISH != null) {
        		
	        	$sql = "{CALL SKILL_UPDATE(:NIK, :skill_id, :skill_value, :USER_ID, :USER_DESC)}";
	        	$params = [
					':NIK' => $model->nik,
					':skill_id' => $model->gmc,
					':skill_value' => $model->skill_value,
					':USER_ID' => $tmp_karyawan->NIK_SUN_FISH,
					':USER_DESC' => $tmp_karyawan->NAMA_KARYAWAN,
				];

				try {
				    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
				    \Yii::$app->session->setFlash("success", 'Skill for ' . $model->nik . ' - ' . $tmp_karyawan->NAMA_KARYAWAN . ' has been updated...');
				    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
				} catch (Exception $ex) {
					\Yii::$app->session->setFlash('danger', "Error : $ex, $lot_id aaaaaaa");
				}
        	}

        	
        }
        $model->nik = null;

		return $this->render('skill-update', [
			'model' => $model
		]);
	}
}
