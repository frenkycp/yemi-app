<?php

namespace app\models;

use Yii;
use \app\models\base\TpPartList as BaseTpPartList;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tp_part_list".
 */
class TpPartList extends BaseTpPartList
{
    public $uploadFile, $name, $location;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['uploadFile'], 'file', 'checkExtensionByMimeType' => false, 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx'],
                [['speaker_model'], 'required'],
            ]
        );
    }
    
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'uploadFile' => 'File',
            ]
        );
    }
    
    public function upload($filename)
    {
    	if ($this->validate()) {
    		$this->uploadFile->saveAs(\Yii::getAlias('@webroot') . '/uploads/' . $filename . '.' . $this->uploadFile->extension);
    		return true;
    	} else {
    		return false;
    	}
    }
}
