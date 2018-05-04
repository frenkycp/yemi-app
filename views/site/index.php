<?php
use scotthuangzl\googlechart\GoogleChart;

$this->title = 'Centered Information System';

?>

<div class="row">
    <div class="col-md-3">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-aqua-active">
                <h5 class="widget-user-desc">SMT</h5>
                <div align="center">
                <?= GoogleChart::widget( array('visualization' => 'Gauge', 'packages' => 'gauge',
                            'data' => array(
                                array('Label', 'Value'),
                                array('Total(%)', 80)
                            ),
                            'options' => array(
                                'width' => 100,
                                'height' => 100,
                                'redFrom' => 0,
                                'redTo' => 30,
                                'yellowFrom' => 30,
                                'yellowTo' => 60,
                                'greenFrom' => 60,
                                'greenTo' => 100,
                                'minorTicks' => 5
                            )
                        ));
                        ?>
                    </div>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">20</h5>
                    <span class="description-text">PLAN</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">13</h5>
                    <span class="description-text">ACTUAL</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">7</h5>
                    <span class="description-text">OPEN</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <div align="center">
              <?= GoogleChart::widget( array('visualization' => 'Gauge', 'packages' => 'gauge',
                            'data' => array(
                                array('Label', 'Value'),
                                array('Total(%)', 80)
                            ),
                            'options' => array(
                                'width' => 100,
                                'height' => 100,
                                'redFrom' => 0,
                                'redTo' => 30,
                                'yellowFrom' => 30,
                                'yellowTo' => 60,
                                'greenFrom' => 60,
                                'greenTo' => 100,
                                'minorTicks' => 5
                            )
                        ));
                        ?>
                    </div>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Plan</b> <a class="pull-right">20</a>
                </li>
                <li class="list-group-item">
                  <b>Actual</b> <a class="pull-right">13</a>
                </li>
                <li class="list-group-item">
                  <b>Open</b> <a class="pull-right">7</a>
                </li>
              </ul>
            </div>
            </div>
        </div>
        <div class="col-md-3">
          <div class="box box-primary">
            <?php
              echo GoogleChart::widget(array('visualization' => 'PieChart',
                'data' => array(
                    array('Task', 'Hours per Day'),
                    array('Work', 11),
                    array('Eat', 2),
                    array('Commute', 2),
                    array('Watch TV', 2),
                    array('Sleep', 7)
                ),
                'options' => array('title' => 'My Daily Activity')));
            ?>
          </div>
        </div>
    </div>
</div>