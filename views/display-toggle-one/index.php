<?php
use yii\web\View;

$this->title = [
    'page_title' => 'TV Display <span class="text-green">',
    'tab_title' => 'TV Display',
    'breadcrumbs_title' => 'TV Display'
];

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
        window.setInterval(refreshPage, 15000);
    }
    function refreshPage() {
        var src = $('#frame1').attr('src');
        var link_arr = [
            'http://10.110.52.5:86/daily-container-display',
            'http://10.110.52.5:86/finish-good-stock-display',
            'http://10.110.52.5:86/monthly-container-display'
        ];
        var index = link_arr.indexOf(src);
        var arr_length = link_arr.length;
        index++;
        if(index == arr_length){
            index = 0;
        }
        var new_src = link_arr[index];

        $('#frame1').attr('src',new_src);
        //alert(new_src);
    }
";
$this->registerJs($script, View::POS_HEAD );
?>

<iframe id="frame1" src="http://10.110.52.5:86/daily-container-display" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">
    Your browser doesn't support iframes
</iframe>