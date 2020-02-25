<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\FixAssetDataSearch $searchModel
*/

/**
 * This is the base-model class for table "db_owner.ASSET_TBL".
 *
 * @property string $asset_id
 * @property string $qr
 * @property string $ip_address
 * @property string $computer_name
 * @property string $jenis
 * @property string $manufacture
 * @property string $manufacture_desc
 * @property string $cpu_desc
 * @property string $ram_desc
 * @property string $rom_desc
 * @property string $os_desc
 * @property string $fixed_asst_account
 * @property string $asset_category
 * @property string $purchase_date
 * @property integer $report_type
 * @property string $LAST_UPDATE
 * @property string $network
 * @property string $display
 * @property string $camera
 * @property string $battery
 * @property string $note
 * @property string $location
 * @property string $area
 * @property string $project
 * @property string $cur
 * @property double $price
 * @property double $price_usd
 * @property string $manager_name
 * @property string $department_pic
 * @property string $cost_centre
 * @property string $department_name
 * @property string $section_name
 * @property string $nik
 * @property string $NAMA_KARYAWAN
 * @property string $primary_picture
 * @property string $FINANCE_ASSET
 * @property double $qty
 * @property double $AtCost
 * @property string $Discontinue
 * @property string $DateDisc
 * @property string $status
 * @property string $label
 * @property string $aliasModel
 */

$this->title = [
    'page_title' => null,
    'tab_title' => 'Fixed Asset',
    'breadcrumbs_title' => 'Fixed Asset'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
");

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');
?>

<h1>
	<?php
	if ($schedule_data->schedule_id == null) {
		echo 'There is no stock take schedule...';
	} else {
		echo 'Stock Taking Progress (' . date('d M\' Y', strtotime($schedule_data->start_date)) . ' - ' . date('d M\' Y', strtotime($schedule_data->end_date)) . ')';
	}
	?>
</h1>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">
			
		</h3>
	</div>
	<div class="panel-body">
		
	</div>
</div>