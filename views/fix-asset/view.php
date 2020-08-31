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
    
    <div class="col-md-5">
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

                <strong>Acquisition Date</strong>
                <p class="text-muted">
                    <?= $fixed_asset_data->purchase_date == null ? '-' : date('Y-m-d', strtotime($fixed_asset_data->purchase_date)); ?>
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
    <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Image Preview</h3>
            </div>
            <div class="panel-body text-center" style="height: 380px; margin: auto;">
                <?php
                $filename = $fixed_asset_data->primary_picture . '.jpg';
                $path1 = \Yii::$app->basePath . '\\web\\uploads\\ASSET_IMG\\' . $filename;
                if (file_exists($path1)) {
                    echo Html::img('@web/uploads/ASSET_IMG/' . $filename, ['class' => 'attachment-img', 'style' => 'max-width: 100%; max-height: 100%;']);
                } else {
                    echo Html::img('@web/uploads/image-not-available.png', ['class' => 'attachment-img', 'style' => 'max-width: 100%; max-height: 100%;']);
                }
                
                ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Sub Expense</h3>
    </div>
    <div class="panel-body no-padding">
        <table class="table table-responsice table-bordered table-striped">
            <thead>
                <tr class="bg-navy color-palette">
                    <th class="text-center">No.</th>
                    <th>Detail</th>
                    <th class="text-center">Acquisition Date</th>
                    <th>Vendor</th>
                    <th class="text-center">Voucher Number</th>
                    <th class="text-center">Payment Date</th>
                    <th class="text-center">Depr. Date</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Currency</th>
                    <th class="text-center">Rate</th>
                    <th class="text-center">At Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$asset_dtr) {
                    echo '<tr>
                        <td colspan="12">No history data ...</td>
                    </tr>';
                } else {
                    $no = 1;
                    foreach ($asset_dtr as $key => $value) {
                        if ($value->dateacqledger == null) {
                            $acq_date = '-';
                        } else {
                            $acq_date = date('Y-m-d', strtotime($value->dateacqledger));
                        }

                        if ($value->date_of_payment == null) {
                            $payment_date = '-';
                        } else {
                            $payment_date = date('Y-m-d', strtotime($value->date_of_payment));
                        }

                        if ($value->depr_date == null) {
                            $depr_date = '-';
                        } else {
                            $depr_date = date('Y-m-d', strtotime($value->depr_date));
                        }

                        echo '<tr>
                            <td class="text-center">' . $value->fixed_asset_subid . '</td>
                            <td>' . $value->description . '</td>
                            <td class="text-center date-format">' . $acq_date . '</td>
                            <td>' . $value->vendor . '</td>
                            <td class="text-center">' . $value->voucher_number . '</td>
                            <td class="text-center date-format">' . $payment_date . '</td>
                            <td class="text-center date-format">' . $depr_date . '</td>
                            <td class="text-center">' . number_format($value->qty) . '</td>
                            <td class="text-center">' . number_format($value->price_unit) . '</td>
                            <td class="text-center">' . $value->currency . '</td>
                            <td class="text-center">' . number_format($value->rate) . '</td>
                            <td class="text-center">' . number_format($value->at_cost) . '</td>
                        </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>