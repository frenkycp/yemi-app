<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dmstr\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control'],
    //'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];
?>

<section class="login-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form', 
                    'enableClientValidation' => true,
                    'errorSummaryCssClass' => 'error-summary alert alert-danger',
                    'options' => [
                        'class' => 'md-float-material form-material'
                    ],
                ]); ?>
                <div style="margin: 20px auto 0 auto; max-width: 450px;">
                    <?= Alert::widget() ?>
                </div>
                <div class="text-center">
                    <span class="badge bg-primary" style="font-size: 3em; padding: 10px 20px;">RDR - DPR Application</span>
                </div>
                
                <div class="auth-box card">
                    <div class="card-block">
                        <div class="text-center">
                            <?= Html::img('@web/uploads/ICON/form_02.png', [
                                'style' => 'width: 100px;'
                            ]); ?>
                        </div>
                        <br/>
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <h3 class="text-center">Login</h3>
                            </div>
                        </div>
                        <?= $form
                            ->field($model, 'username', $fieldOptions1)
                            ->label(false)
                            ->textInput(['placeholder' => 'Your NIK']) ?>

                        <?= $form
                            ->field($model, 'password')
                            ->label(false)
                            ->passwordInput(['placeholder' => 'Password']) ?>
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>