<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\MrbsEntry $model
*/

$this->title = [
    'page_title' => '<span class="page-title">Add Member</span>',
    'tab_title' => 'Add Member',
    'breadcrumbs_title' => 'Add Member'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$this->registerCss(".content-header {text-align: center; }");
?>
<?php $form = ActiveForm::begin([
'id' => 'MrbsEntry',
//'layout' => 'horizontal',
'enableClientValidation' => true,
'errorSummaryCssClass' => 'error-summary alert alert-danger',
/*'fieldConfig' => [
         'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
         'horizontalCssClasses' => [
             'label' => 'col-sm-2',
             #'offset' => 'col-sm-offset-4',
             'wrapper' => 'col-sm-8',
             'error' => '',
             'hint' => '',
         ],
     ],*/
]
);
?>

<?= $form->field($model, 'nik', [
    'inputOptions' => [
        'autofocus' => 'autofocus'
    ]
])->textInput(['placeholder' => 'Input NIK Here', 'class' => 'text-center form-control'])->label(false); ?>

<?php ActiveForm::end(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Member List</h3>
            </div>
            <div class="panel-body">
                <?php
                if (count($total_member) == null) {
                    echo '<span class="text-center">No member on this meeting...</span>';
                } else {
                    echo '<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">NIK</th>
                                <th class="text-center">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                    foreach ($total_member as $key => $value) {
                        $filename = $value['NIK'] . '.jpg';
                        $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                        if (file_exists($path)) {
                            $img_url = '@web/uploads/yemi_employee_img/' . $filename;
                        } else {
                            $img_url = '@web/uploads/profpic_02.png/';
                        }
                        echo '<tr>
                            <td class="text-center">' . Html::img($img_url) . '</td>
                            <td class="text-center">' . $value['NAMA_KARYAWAN'] . '</td>
                        </tr>';
                    }

                    echo '</tbody></table>';
                }
                ?>
                
            </div>
        </div>
    </div>
</div>