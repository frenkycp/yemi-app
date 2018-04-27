<?php

namespace app\controllers;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
/**
* This is the class for controller "TpPartListController".
*/
class TpPartListController extends \app\controllers\base\TpPartListController
{
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
                
                /**  Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = $reader->load($inputFileName);
                
                return $spreadsheet->getSheet(1);
                
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