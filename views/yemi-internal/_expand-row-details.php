<?php
use app\models\SernoInput;

$serno_input_arr = SernoInput::find()
->where([
	'plan' => $model->pk
])
->all();

echo $model->pk;

echo '<table class="table table-bordered table-striped table-hover">';
echo '<tr>
	<th>Serial Number</th>
</tr>';
foreach ($serno_input_arr as $serno_input) {
	echo '<tr>
		<td>' . $serno_input->sernum . '</td>
	</tr>';
}
echo '</table>';
?>