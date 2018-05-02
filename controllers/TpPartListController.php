<?php

namespace app\controllers;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
/**
* This is the class for controller "TpPartListController".
*/
class TpPartListController extends \app\controllers\base\TpPartListController
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionImport()
    {
        $model = new \app\models\TpPartList();
        $filename = 'tp_part_list';
        
        if($model->load(\Yii::$app->request->post()))
        {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
            if(!$model->upload($filename))
            {
                return json_encode($model->errors);
            }else{
                set_time_limit(0);
                $extension = '.' . $model->uploadFile->extension;
                $basepath = \Yii::getAlias('@webroot') . '/uploads/';
                $inputFileName = $basepath . $filename . $extension;
                $model->name = $inputFileName;
                
                /**  Identify the type of $inputFileName  **/
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                
                /**  Create a new Reader of the type that has been identified  **/
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                
                $reader->setReadDataOnly(TRUE);
                
                /**  Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = $reader->load($inputFileName);
                
                // Get the highest row and column numbers referenced in the worksheet
                $sheet = $spreadsheet->getSheetByName('TP PART LIST');
                $highestRow = $sheet->getHighestRow();
                //$partno = $sheet->getCellByColumnAndRow(1, 11)->getValue();
                //return $highestRow . ' - ' . $partno;
                
                for($row = 11; $row <= $highestRow; ++$row)
                {
                    $partno = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                    if($partno != NULL)
                    {
                        date_default_timezone_set('Asia/Jakarta');
                        
                        $part_name = $sheet->getCellByColumnAndRow(2, $row)->getValue();
                        $um = $sheet->getCellByColumnAndRow(3, $row)->getValue();
                        $hpl_desc = $sheet->getCellByColumnAndRow(4, $row)->getValue();
                        $analyst = $sheet->getCellByColumnAndRow(5, $row)->getValue();
                        $analyst_desc = $sheet->getCellByColumnAndRow(6, $row)->getValue();
                        $curr = $sheet->getCellByColumnAndRow(7, $row)->getValue();
                        $unit_price = $sheet->getCellByColumnAndRow(8, $row)->getValue();
                        $standard_price = $sheet->getCellByColumnAndRow(9, $row)->getValue();
                        $fix_lt = $sheet->getCellByColumnAndRow(10, $row)->getValue();
                        $dts_lt = $sheet->getCellByColumnAndRow(11, $row)->getValue();
                        $min_qty = $sheet->getCellByColumnAndRow(12, $row)->getValue();
                        $multi_qty = $sheet->getCellByColumnAndRow(13, $row)->getValue();
                        $ss_qty = $sheet->getCellByColumnAndRow(14, $row)->getValue();
                        $sloc = $sheet->getCellByColumnAndRow(15, $row)->getValue();
                        
                        $total_product = $sheet->getCellByColumnAndRow(17, $row)->getValue();
                        $total_assy = $sheet->getCellByColumnAndRow(18, $row)->getValue();
                        $total_spare_part = $sheet->getCellByColumnAndRow(19, $row)->getValue();
                        $total_requirement = $sheet->getCellByColumnAndRow(20, $row)->getValue();
                        
                        $newTPPL = \app\models\TpPartList::find()->where(['speaker_model' => $model->speaker_model, 'part_no' => $partno])->one();
                        if(!$newTPPL)
                        {
                            $newTPPL = new \app\models\TpPartList();
                        }
                        $newTPPL->last_modified = date('Y-m-d H:i:s');
                        $newTPPL->last_modified_by = \Yii::$app->user->identity->name;
                        $newTPPL->speaker_model = $model->speaker_model;
                        $newTPPL->part_no = $partno;
                        $newTPPL->part_name = $part_name;
                        $newTPPL->um = $um;
                        $newTPPL->hpl_desc = $hpl_desc;
                        $newTPPL->analyst = $analyst;
                        $newTPPL->analyst_desc = $analyst_desc;
                        $newTPPL->curr = $curr;
                        $newTPPL->unit_price = $unit_price;
                        $newTPPL->standard_price = $standard_price;
                        $newTPPL->fix_lt = $fix_lt;
                        $newTPPL->dts_lt = $dts_lt;
                        $newTPPL->min_qty = $min_qty;
                        $newTPPL->multi_qty = $multi_qty;
                        $newTPPL->ss_qty = $ss_qty;
                        $newTPPL->sloc = $sloc;
                        $newTPPL->total_product = $total_product;
                        $newTPPL->total_assy = $total_assy;
                        $newTPPL->total_spare_part = $total_spare_part;
                        $newTPPL->total_requirement = $total_requirement;
                        
                        if(!$newTPPL->save())
                        {
                            return json_encode($newTPPL->errors);
                        }
                    }
                    
                    //$newTPPL->save();
                }
                
                /*$objPHPExcel = \PHPExcel_IOFactory::load($model->name);
                $sheet = $objPHPExcel->getSheet(0);
                $sheetData = $sheet->toArray(null, true, true, false);
                $highestRow = $sheet->getHighestRow();
                $speakerModel = $model->speaker_model;*/
                //\Yii::$app->session->addFlash("success",'TP Part List for model ' . $speakerModel . ' successfully added...');
            }
            $session = \Yii::$app->session;
            $session->set('success', true);
            return $this->redirect(['index']);
        }
        
        return $this->render('import', ['model' => $model]);
    }
    
    /**
    * Updates an existing TpPartList model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $tp_part_list_id
    * @return mixed
    */
    public function actionUpdate($tp_part_list_id)
    {
        $model = $this->findModel($tp_part_list_id);
        $model->total_product = rtrim(rtrim(sprintf('%.8F', $model->total_product), '0'), ".");
        $model->total_assy = rtrim(rtrim(sprintf('%.8F', $model->total_assy), '0'), ".");
        $model->total_spare_part = rtrim(rtrim(sprintf('%.8F', $model->total_spare_part), '0'), ".");
        $model->total_requirement = rtrim(rtrim(sprintf('%.8F', $model->total_requirement), '0'), ".");

        if ($model->load($_POST) && $model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionReport()
    {
        $this->render('report');
        
        // Fill form with data array
        /* $basepath = \Yii::getAlias('@webroot') . '/uploads/';
        $pdf = new Pdf($basepath . 'ijin_dokter.pdf');
        $pdf->fillForm([
                'nama'=>'FRENKY CAHYA P',
            ])
                ->saveAs($basepath . 'ijin_dokter_filled.pdf'); */
    }
}

class ChunkReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    private $startRow = 0;
    private $endRow   = 0;

    /**  Set the list of rows that we want to read  */
    public function setRows($startRow, $chunkSize) {
        $this->startRow = $startRow;
        $this->endRow   = $startRow + $chunkSize;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //  Only read the heading row, and the configured rows
        if (($row == 1) || ($row >= $this->startRow && $row < $this->endRow)) {
            return true;
        }
        return false;
    }
}