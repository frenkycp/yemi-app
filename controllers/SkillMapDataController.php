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

        // $tmp_arr1 = ArrayHelper::map(SernoMaster::find()->select(['gmc', 'model', 'color', 'dest'])->all(), 'gmc', 'fullDescription');
        // $tmp_arr2 = ArrayHelper::map(SkillMaster::find()->select(['skill_id', 'skill_desc'])->where(['<>', 'skill_group', 'Z'])->all(), 'skill_id', 'description');
        // $skill_dropdown_arr = array_merge($tmp_arr2, $tmp_arr1);
        $tmp_skill_dropdown_arr = SkillMaster::find()->select(['skill_id', 'skill_desc'])->asArray()->all();
        $skill_dropdown_arr = [];
        foreach ($tmp_skill_dropdown_arr as $key => $value) {
        	$skill_dropdown_arr[] = $value['skill_id'] . ' | ' . $value['skill_desc'];
        }

        if ($model->load($_POST)) {
        	$splitted_skill = explode(' | ', $model->skill);
        	$tmp_skill = SkillMaster::find()->where(['skill_id' => $splitted_skill[0]])->one();
        	if ($tmp_skill->skill_id == null) {
        		\Yii::$app->session->setFlash('danger', "Skill : $model->skill not found...Please input the correct skill...");
        		return $this->render('skill-update', [
					'model' => $model,
					'skill_dropdown_arr' => $skill_dropdown_arr,
				]);
        	}
        	//return $model->skill;
        	$id = \Yii::$app->user->identity->username;
        	$tmp_karyawan = Karyawan::find()
        	->where([
        		'OR',
        		['NIK' => $id],
        		['NIK_SUN_FISH' => $id]
        	])
        	->one();

            $tmp_arr = [];
        	if ($tmp_karyawan->NIK_SUN_FISH != null) {
        		foreach ($model->nik as $key => $value) {
                    // $tmp_arr[] = $value;
                    $tmp_skill_master = SkillMasterKaryawan::find()
                    ->where([
                        'NIK' => $value
                    ])
                    ->one();

                    if ($tmp_skill_master->NIK == null) {
                        $sql = "{CALL SKILL_CREATE(:NIK, :USER_ID, :USER_DESC)}";
                        $params = [
                            ':NIK' => $value,
                            ':USER_ID' => $tmp_karyawan->NIK_SUN_FISH,
                            ':USER_DESC' => $tmp_karyawan->NAMA_KARYAWAN,
                        ];

                        try {
                            $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
                            \Yii::$app->session->addFlash("warning", $value . ' - ' . $tmp_skill_master->NAMA_KARYAWAN . ' doesn\'t have skill map data. Default skill map has been added for this user.');
                            //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
                        } catch (Exception $ex) {
                            \Yii::$app->session->addFlash('danger', "Error : $ex");
                        }
                    }
                    $sql = "{CALL SKILL_UPDATE(:NIK, :skill_id, :skill_value, :USER_ID, :USER_DESC)}";
                    $params = [
                        ':NIK' => $value,
                        ':skill_id' => $splitted_skill[0],
                        ':skill_value' => $model->skill_value,
                        ':USER_ID' => $tmp_karyawan->NIK_SUN_FISH,
                        ':USER_DESC' => $tmp_karyawan->NAMA_KARYAWAN,
                    ];

                    try {
                        $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
                        \Yii::$app->session->addFlash("success", 'Skill for ' . $value . ' - ' . $tmp_skill_master->NAMA_KARYAWAN . ' has been updated...');
                        //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
                    } catch (Exception $ex) {
                        \Yii::$app->session->addFlash('danger', "Error : $ex");
                    }
                }
	        	
        	}
            // return json_encode($tmp_arr);
        	
        }
        $model->nik = null;

		return $this->render('skill-update', [
			'model' => $model,
			'skill_dropdown_arr' => $skill_dropdown_arr,
		]);
	}
}
