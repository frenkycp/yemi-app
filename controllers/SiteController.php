<?php

namespace app\controllers;

//use app\components\NodeLogger;
use app\components\RoleAccessBehaviour;
use app\models\Action;
use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;
use app\models\CisClientIpAddress;
use app\models\Karyawan;
use app\models\RekapAbsensiView;
use app\models\AbsensiTbl;

class SiteController extends Controller
{

    public function behaviors()
    {
        //NodeLogger::sendLog(Action::getAccess($this->id));
        //apply role_action table for privilege (doesn't apply to super admin)
        return Action::getAccess($this->id);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionGetDisiplinDetail($nik, $period)
    {
        $abensi_data_arr = AbsensiTbl::find()->where([
            'NIK' => $nik,
            'PERIOD' => $period,
            'DISIPLIN' => 0
        ])->all();

        $data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<thead><tr>
            <th style="text-align: center;">Tanggal</th>
            <th>Keterangan</th>
        </tr></thead>'
        ;
        $data .= '<tbody>';
        foreach ($abensi_data_arr as $key => $value) {
            $data .= '
            <tr>
                <td style="text-align: center;">' . date('l, d M\' Y', strtotime($value['DATE'])) . '</td>
                <td>' . $value['CATEGORY'] . '</td>
            </tr>
            ';
        }
        $data .= '</tbody>';
        $data .= '</table>';
        return $data;
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->identity->role->name == 'YEMI') {
            $nik = \Yii::$app->user->identity->name;
            $model_karyawan = Karyawan::find()->where([
                'NIK' => $nik
            ])->one();
            $model_rekap_absensi = RekapAbsensiView::find()->where(['NIK' => $nik])->orderBy('PERIOD')->all();
            return $this->render('index_nik', [
                'model_karyawan' => $model_karyawan,
                'model_rekap_absensi' => $model_rekap_absensi,
            ]);
        }
        return $this->render('index2');
    }

    public function actionProfile()
    {
        $model = User::find()->where(["id"=>Yii::$app->user->id])->one();
        $oldMd5Password = $model->password;
        $oldPhotoUrl = $model->photo_url;

        $model->password = "";

        if ($model->load($_POST)){
            //password
            if($model->password != ""){
                $model->password = md5($model->password);
            }else{
                $model->password = $oldMd5Password;
            }

            # get the uploaded file instance
            $image = UploadedFile::getInstance($model, 'photo_url');
            if ($image != NULL) {
                # store the source file name
                $model->photo_url = $image->name;
                $arr = explode(".", $image->name);
                $extension = end($arr);

                # generate a unique file name
                $model->photo_url = Yii::$app->security->generateRandomString() . ".{$extension}";

                # the path to save file
                $path = Yii::getAlias("@app/web/uploads/") . $model->photo_url;
                $image->saveAs($path);
            }else{
                $model->photo_url = $oldPhotoUrl;
            }

            if($model->save()){
                Yii::$app->session->addFlash("success", "Profile successfully updated.");
            }else{
                Yii::$app->session->addFlash("danger", "Profile cannot updated.");
            }
            return $this->redirect(["profile"]);
        }
        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $this->layout = "main-login";

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->addFlash("success", "Register success, please login");
            return $this->redirect(["site/login"]);
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        $this->layout = "main-login";

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            //log last login column
            $user = Yii::$app->user->identity;
            $user->last_login = new Expression("NOW()");
            $user->save();

            $ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);

            if ($ip != '::1') {
                $client_ip = new CisClientIpAddress();
                $client_ip->ip_address = $ip;
                $client_ip->login_as = Yii::$app->user->identity->name;
                $client_ip->login_as_id = Yii::$app->user->identity->id;

                if (!$client_ip->save()) {
                    return json_encode($client_ip->errors);
                }
            }

            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        //log last login column
        $user = Yii::$app->user->identity;
        $user->last_logout = new Expression("NOW()");
        $user->save();

        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
