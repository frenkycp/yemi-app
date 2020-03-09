<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\typeahead\TypeaheadBasic;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SkillMapDataSearch $searchModel
*/

$this->title = [
    'page_title' => 'Skill Update (WIP/GMC) <span class="japanesse light-green"></span>',
    'tab_title' => 'Skill Update (WIP/GMC)',
    'breadcrumbs_title' => 'Skill Update (WIP/GMC)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    //'layout' => 'horizontal',
    'action' => Url::to(['skill-update']),
]); ?>

<div class="panel panel-primary">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4">
                <?= $form->field($model, 'skill')->widget(TypeaheadBasic::classname(), [
                        'data' => $skill_dropdown_arr,
                        'options' => [
                            'onkeyup' => 'this.value=this.value.toUpperCase()',
                            'onfocusout' => 'this.value=this.value.toUpperCase()',
                            'placeholder' => 'Choose',
                        ],
                        'pluginOptions' => ['highlight'=>true],
                    ]); ?>
				<?= ''; /*$form->field($model, 'skill')->widget(Select2::classname(), [
	                'data' => $skill_dropdown_arr,
	                'options' => [
	                    'placeholder' => 'Choose...',
	                ],
	                'pluginOptions' => [
	                    'allowClear' => true
	                ],
	            ]);*/ ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'skill_value')->textInput(['type' => 'number']); ?>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'nik')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                        'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                    ])
                    ->where([
                        'AKTIF' => 'Y',
                    ])
                    ->andWhere(['<>', 'DEPARTEMEN', 'ADMINISTRATION'])
                    ->all(), 'NIK_SUN_FISH', 'nikSunFishNama'),
                    'options' => [
                        'placeholder' => 'Choose...',
                        'id' => 'emp_id',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label('NIK'); ?>
			</div>
		</div>
	</div>

	<div class="panel-footer">
		<?= Html::submitButton('Submit',
        [
        'id' => 'btn-submit',
        'class' => 'btn btn-success'
        ]
        );
        ?>
	</div>
</div>

<?php ActiveForm::end(); ?>