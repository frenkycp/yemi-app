<?php
require(\Yii::getAlias('@webroot') . '/fpdm/fpdm.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

        $fields = [
            'nama' => 'My name'
        ];
        $basepath = \Yii::getAlias('@webroot') . '/uploads/';
        $pdf = new \FPDM('ijin_dokter2.pdf');
        $pdf->Load($fields, false);
        $pdf->Merge();
        $pdf->Output();