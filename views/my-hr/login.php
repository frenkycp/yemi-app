<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
                    'enableClientValidation' => false,
                    'options' => [
                        'class' => 'md-float-material form-material'
                    ],
                ]); ?>
                <div class="auth-box card">
                    <div class="card-block">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <h3 class="text-center">My HR Login</h3>
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