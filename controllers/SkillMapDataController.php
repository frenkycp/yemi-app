<?php

namespace app\controllers;

use app\models\Karyawan;
use app\models\SkillMaster;
use app\models\SkillMasterKaryawan;
use app\models\SernoMaster;
use yii\helpers\ArrayHelper;
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
            'skill', 'nik', 'skill_value', 'category'
        ]);
        $model->addRule(['skill', 'nik', 'skill_value'], 'required');
        $model->skill_value = 3;

        $tmp_arr1 = ArrayHelper::map(SernoMaster::find()->select(['gmc', 'model', 'color', 'dest'])->all(), 'gmc', 'fullDescription');
        $tmp_arr2 = ArrayHelper::map(SkillMaster::find()->select(['skill_id', 'skill_desc'])->where(['<>', 'skill_group', 'Z'])->all(), 'skill_id', 'description');
        $skill_dropdown_arr = array_merge($tmp_arr2, $tmp_arr1);

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
        		$tmp_skill_master = SkillMasterKaryawan::find()
        		->where([
        			'NIK' => $model->nik
        		])
        		->one();

        		if ($tmp_skill_master->NIK == null) {
        			$sql = "{CALL SKILL_CREATE(:NIK, :USER_ID, :USER_DESC)}";
		        	$params = [
						':NIK' => $model->nik,
						':USER_ID' => $tmp_karyawan->NIK_SUN_FISH,
						':USER_DESC' => $tmp_karyawan->NAMA_KARYAWAN,
					];

					try {
					    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
					    \Yii::$app->session->setFlash("warning", $model->nik . ' - ' . $tmp_skill_master->NAMA_KARYAWAN . ' doesn\'t have skill map data. Default skill map has been added for this user.');
					    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
					} catch (Exception $ex) {
						\Yii::$app->session->setFlash('danger', "Error : $ex");
					}
        		}
        		$sql = "{CALL SKILL_UPDATE(:NIK, :skill_id, :skill_value, :USER_ID, :USER_DESC)}";
	        	$params = [
					':NIK' => $model->nik,
					':skill_id' => $model->skill,
					':skill_value' => $model->skill_value,
					':USER_ID' => $tmp_karyawan->NIK_SUN_FISH,
					':USER_DESC' => $tmp_karyawan->NAMA_KARYAWAN,
				];

				try {
				    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
				    \Yii::$app->session->setFlash("success", 'Skill for ' . $model->nik . ' - ' . $tmp_skill_master->NAMA_KARYAWAN . ' has been updated...');
				    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
				} catch (Exception $ex) {
					\Yii::$app->session->setFlash('danger', "Error : $ex");
				}
	        	
        	}

        	
        }
        $model->nik = null;

		return $this->render('skill-update', [
			'model' => $model,
			'skill_dropdown_arr' => $skill_dropdown_arr,
		]);
	}
}
