<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'Fix Asset Detail View <span class="japanesse light-green"></span>',
    'tab_title' => 'Fix Asset Detail View',
    'breadcrumbs_title' => 'Fix Asset Detail View'
];

?>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Image Preview</h3>
            </div>
            <div class="panel-body">
                <?php
                $filename = $fixed_asset_data->primary_picture . '.jpg';
                $path1 = \Yii::$app->basePath . '\\web\\uploads\\ASSET_IMG\\' . $filename;
                if (file_exists($path1)) {
                    echo Html::img('@web/uploads/ASSET_IMG/' . $filename, ['class' => 'attachment-img', 'width' => '100%']);
                } else {
                    echo Html::img('@web/uploads/image-not-available.png', ['class' => 'attachment-img', 'width' => '100%']);
                }
                
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Fix Asset Information</h3>
            </div>
            <div class="panel-body">
                <strong>Fixed Asset ID</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->asset_id; ?>
                </p>
                
                <strong>Fixed Asset Description</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->computer_name; ?>
                </p>
                
                <strong>Qty</strong>
                <p class="text-muted">
                    <?= number_format($fixed_asset_data->qty); ?>
                </p>

                <strong>PIC Name</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->NAMA_KARYAWAN == null ? '<em>(Not Set)</em>' : $fixed_asset_data->NAMA_KARYAWAN; ?>
                </p>

                <strong>Department</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->section_name; ?> (<?= $fixed_asset_data->cost_centre; ?>)
                </p>

                <strong>Location</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->LOC . ' - ' . $fixed_asset_data->location; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Scrap Information</h3>
            </div>
            <div class="panel-body">
                <strong>Discontinue (Scrap)</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->Discontinue; ?>
                </p>

                <strong>Disposal Date</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->DateDisc == null ? '-' : date('Y-m-d', strtotime($fixed_asset_data->DateDisc)); ?>
                </p>

                <strong>Slip No.</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->scrap_slip_no == null ? '-' : $fixed_asset_data->scrap_slip_no; ?>
                </p>

                <strong>PIC</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->scrap_by_id == null ? '-' : $fixed_asset_data->scrap_by_id . ' - ' . $fixed_asset_data->scrap_by_name; ?>
                </p>

                <strong>Proposal</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->scrap_proposal_file == null ? '-' : Html::a('<i class="fa fa-file"></i> Attachment', [$fixed_asset_data->scrap_proposal_file]); ?>
                </p>

                <strong>BAC</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->bac_file == null ? '-' : Html::a('<i class="fa fa-file"></i> Attachment', [$fixed_asset_data->bac_file]); ?>
                </p>

                <strong>Disposal Image</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->scraping_file == null ? '-' : Html::a('<i class="fa fa-file"></i> Attachment', [$fixed_asset_data->scraping_file]); ?>
                </p>
            </div>
        </div>
    </div>
</div>