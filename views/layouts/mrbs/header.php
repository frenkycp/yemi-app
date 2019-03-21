<?php
use yii\helpers\Html;
use app\models\Karyawan;

/* @var $this \yii\web\View */
/* @var $content string */
$session = \Yii::$app->session;
$nik = $session['mrbs_user'];
$model_karyawan = Karyawan::find()->where([
    'NIK' => $nik
])->one();
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
            <?= Html::a('Meeting Room Booking System', Yii::$app->homeUrl . 'mrbs-entry', ['class' => 'navbar-brand']) ?>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <?php
                    $filename =$session['mrbs_user'] . '.jpg';
                    $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                    if (file_exists($path)) {
                        echo Html::img('@web/uploads/yemi_employee_img/' .$session['mrbs_user'] . '.jpg', [
                            'class' => 'user-image',
                        ]);
                    } else {
                        echo Html::img('@web/uploads/profpic_02.png', [
                            'class' => 'user-image',
                        ]);
                    }
                ?>
                <!--<img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?= ucwords(strtolower($session['mrbs_name'])); ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                    <?php
                        $filename =$session['mrbs_user'] . '.jpg';
                        $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                        if (file_exists($path)) {
                            echo Html::img('@web/uploads/yemi_employee_img/' .$session['mrbs_user'] . '.jpg', [
                                'class' => 'img-circle',
                            ]);
                        } else {
                            echo Html::img('@web/uploads/profpic_02.png', [
                                'class' => 'img-circle',
                            ]);
                        }
                    ?>

                  <p style="font-size: 15px;">
                    <?= ucwords(strtolower($model_karyawan->NAMA_KARYAWAN)); ?> - <?= ucwords(strtolower($model_karyawan->DEPARTEMEN)); ?>
                    <small>Member since : <?= date('d M\' Y', strtotime($model_karyawan->TGL_MASUK_YEMI)); ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer bg-purple-active color-pallete">
                  <div class="text-center">
                    <?= Html::a('<i class="fa fa-power-off"></i>&nbsp;&nbsp;Sign out', ['logout'], ['class' => 'btn btn-flat btn-danger']) ?>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>