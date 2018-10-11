<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputOptions' => ['autofocus' => 'autofocus'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo" style="margin-bottom: 0px;">
        <img style="margin-right: auto; margin-left: auto; display: block; width: 100%;" src="<?= Yii::getAlias('@web') ?>/welcome.png">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= ''; //$form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center" style="display: none;">
            <p>- OR -</p>
            <?= Html::a('<i class="fa fa-user"></i> Open My HR Information Board', ['my-hr/index'], ['class' => 'btn btn-block btn-social btn-facebook', 'target' => '_blank']); ?>
            <!--<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-group"></i> Open My HR Inforamtion Board</a>-->
        </div>
        <!-- /.social-auth-links -->

        <!-- <a href="#">I forgot my password</a><br> -->
        <?= ''; //Html::a("Register a new membership", ["site/register"], ["class"=>"text-center"]) ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
