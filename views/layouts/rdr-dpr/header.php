<?php
use yii\helpers\Html;
use app\models\Karyawan;

/* @var $this \yii\web\View */
/* @var $content string */
$session = \Yii::$app->session;
$nik = $session['rdr_nik'];
$model_karyawan = Karyawan::find()->where([
    'NIK' => $nik
])->one();
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
            <?= Html::a('<i class="fa fa-file-text-o"> </i><b style="padding-left: 5px;"></b> RDR - DPR', Yii::$app->homeUrl . 'rdr-dpr', ['class' => 'navbar-brand']) ?>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="<?= \Yii::$app->controller->id == 'rdr-dpr' && in_array(\Yii::$app->controller->action->id, ['data']) ? 'active' : ''; ?>">
                <?= Html::a('Incoming Data', ['data']) ?>
            </li>
            <li class="<?= \Yii::$app->controller->id == 'rdr-dpr' && in_array(\Yii::$app->controller->action->id, ['korlap-approval-data']) ? 'active' : ''; ?> dropdown">
                <?= Html::a('RDR Data', ['korlap-approval-data']); ?>
            </li>
          </ul>
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
                    $filename =$session['rdr_user'] . '.jpg';
                    $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                    if (file_exists($path)) {
                        echo Html::img('@web/uploads/yemi_employee_img/' .$session['rdr_user'] . '.jpg', [
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
                <span class="hidden-xs"><?= strtoupper($session['rdr_name']); ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                    <?php
                        $filename =$session['rdr_user'] . '.jpg';
                        $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                        if (file_exists($path)) {
                            echo Html::img('@web/uploads/yemi_employee_img/' .$session['rdr_user'] . '.jpg', [
                                'class' => 'img-circle',
                            ]);
                        } else {
                            echo Html::img('@web/uploads/profpic_02.png', [
                                'class' => 'img-circle',
                            ]);
                        }
                    ?>

                  <p style="font-size: 15px;">
                    <?= strtoupper($model_karyawan->NAMA_KARYAWAN); ?>
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