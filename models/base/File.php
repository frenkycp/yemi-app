<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\base;

class File extends \yii\base\Model
{
    public $uploadFile, $name, $location;

    public function rules()
    {
        return [
            [['uploadFile'], 'file', 'checkExtensionByMimeType' => false, 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'uploadFile' => 'File',
        ];
    }
    
    public function upload($filename)
    {
    	if ($this->validate()) {
    		$this->uploadFile->saveAs(\Yii::getAlias('@webroot') . '/files/' . $filename . '.' . $this->uploadFile->extension);
    		return true;
    	} else {
    		return false;
    	}
    }
}