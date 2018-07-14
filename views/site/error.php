<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = strpos($name, '403') !== false ? 'Akses Ditolak' : $name;
?>
<!-- Main content -->
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?= strpos($name, '403') !== false ? 'Akses Ditolak' : $name ?></h3>

            <p>
                <?= strpos($name, '403') !== false ? 'Anda tidak mempunyai hak untuk mengakses halaman ini.' : nl2br(Html::encode($message)) ?>
            </p>

            <p>
                <?php
                if (strpos($name, '403') !== false) {
                    echo 'Silahkan hubungi administrator jika menurut anda ini adalah kesalahan server. Terima Kasih. Anda bisa mengakses <a href="' . Yii::$app->homeUrl . '">link ini</a> untuk kembali ke halaman utama.';
                } else {
                    echo 'The above error occurred while the Web server was processing your request. Please contact us if you think this is a server error. Thank you. Meanwhile, you may <a href="' . Yii::$app->homeUrl . '">return to dashboard</a>.';
                }
                ?>
            </p>

            <form class='search-form' style="display: none;">
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Search"/>

                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>
