<?php
use yii\helpers\Html;
use app\models\Karyawan;
use app\models\SunfishViewEmp;

/* @var $this \yii\web\View */
/* @var $content string */
$session = \Yii::$app->session;
$nik = $session['my_hr_user'];
$model_karyawan = Karyawan::find()->where([
    'NIK' => $nik
])->one();

$nik_sunfish = $session['my_hr_user_sunfish'];
$model_karyawan_sunfish = SunfishViewEmp::find()->where([
    'Emp_no' => $nik_sunfish
])->one();

$current_controller = \Yii::$app->controller->id;
$current_action = \Yii::$app->controller->action->id;
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
            <?= Html::a('<span class="glyphicon glyphicon-home"></span>', Yii::$app->homeUrl . 'my-hr', ['class' => 'navbar-brand']) ?>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="<?= \Yii::$app->controller->id == 'my-hr' && $current_action == 'index' ? 'active' : ''; ?>">
                <?= Html::a('My Information', ['index']) ?>
            </li>
            
            <li class="dropdown <?= $current_action == 'index-laporan'
            || $current_action == 'create-laporan'
            || $current_action == 'index-facility'
            || $current_action == 'create-facility'
            || $current_action == 'index-bpjs' ? 'active' : ''; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Question & Answer <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="<?= $_GET['category'] == 'HR' ? 'active' : ''; ?>">
                    <?= Html::a('with HR', ['index-laporan', 'category' => 'HR']) ?>
                </li>
                <li class="<?= $_GET['category'] == 'FACILITY' ? 'active' : ''; ?>">
                    <?= Html::a('My Facility', ['index-facility', 'category' => 'FACILITY']); ?>
                </li>
                <li class="<?= $current_controller == 'my-hr' && $current_action == 'index-bpjs' ? 'active' : ''; ?>">
                    <?= Html::a('My BPJS', ['index-bpjs']); ?>
                </li>
                <li style="<?= $model_karyawan->JABATAN_SR == 'FOREMAN' || $model_karyawan->JABATAN_SR == 'SENIOR FOREMAN' || $model_karyawan->JABATAN_SR == 'MANAGER' ? '' : 'display: none;'; ?>" class="<?= $_GET['category'] == 'MIS' ? 'active' : ''; ?>">
                    <?= Html::a('with MIS', ['index-laporan', 'category' => 'MIS']) ?>
                </li>
              </ul>
            </li>
            <li >
                <?= Html::a('<i class="fa fa-share"></i> <span>Information Center</span>', '//10.110.52.3/hr/karyawan'); ?>
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
                    $filename =$session['my_hr_user'] . '.jpg';
                    $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                    if (file_exists($path)) {
                        echo Html::img('@web/uploads/yemi_employee_img/' .$session['my_hr_user'] . '.jpg', [
                            'class' => 'user-image',
                        ]);
                    } else {
                        echo Html::img('@web/uploads/profpic_03.png', [
                            'class' => 'user-image',
                        ]);
                    }
                ?>
                <!--<img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?= ucwords(strtolower($session['my_hr_name'])); ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                    <?php
                        $filename =$session['my_hr_user'] . '.jpg';
                        $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                        if (file_exists($path)) {
                            echo Html::img('@web/uploads/yemi_employee_img/' .$session['my_hr_user'] . '.jpg', [
                                'class' => 'img-circle',
                            ]);
                        } else {
                            echo Html::img('@web/uploads/profpic_03.png', [
                                'class' => 'img-circle',
                            ]);
                        }
                    ?>

                  <p style="font-size: 15px;">
                    <?= ucwords(strtolower($model_karyawan->NAMA_KARYAWAN)); ?><br/><?= $model_karyawan_sunfish->cost_center_name; ?>
                    <small>Member since : <?= date('d M\' Y', strtotime($model_karyawan->TGL_MASUK_YEMI)); ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer bg-purple-active color-pallete">
                  <div class="pull-left">
                    <?= Html::a('<i class="fa fa-key"></i>&nbsp;&nbsp;Password', ['change-password', 'nik' => $nik], ['class' => 'btn btn-flat btn-warning']) ?>
                  </div>
                  <div class="pull-right">
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