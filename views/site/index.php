<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Share;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Yahoo share</h1>

        <p class="lead"></p>


    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
        <?php if (!Yii::$app->user->isGuest) { ?>
                

                    <?php
                    // Забираем данные в свою переменную
                    $dataPost   = Yii::$app->request->post();
                    // Имя компании
                    $sh         = empty($dataPost['sh'])           ? 'GOOGL'       : trim(rawurlencode($dataPost['sh'])) ;
                    // Стартовая дата
                    $for        = empty($dataPost['for_datep'])    ? '2015-01-01'  : $dataPost['for_datep'] ;
                    // Конечная дата
                    $to         = empty($dataPost['to_datep'])     ? '2015-12-31'  : $dataPost['to_datep'] ;
                    // 
                    
        

                    $data = file_get_contents('http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.historicaldata%20where%20symbol%20%3D%20%22' . $sh . '%22%20and%20startDate%20%3D%20%22' . $for . '%22%20and%20endDate%20%3D%20%22' . $to . '%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=');
                    $object = json_decode($data);
        
                    //echo $object->query->count;
                    //var_dump($object->query->results->quote);
                    ?>
        <?php if (!empty($object->query->results->quote)) { ?>

                    <div style="width:100%">
                        <div>
                            <canvas id="canvas" height="450" width="600"></canvas>
                        </div>
                    </div>


                    <script>
                        var lineChartData = {
                            
                            labels: [
                                    <?php
                                    $mount = '';
                                    foreach (array_reverse($object->query->results->quote) as $key => $item) {

                                        $date = new DateTime($item->Date);
                                        if ($mount != $date->format('F') || $date->format('d') == 15 ) {
                                            echo '"', $date->format('Y-m-d') , '"', $key == $object->query->count - 1 ? '' : ',';
                                        }
                                        $mount = $date->format('F');
                                    }
                                    ?>
                            ],
                            datasets: [
                                {
                                    label: "My First dataset",
                                    fillColor: "rgba(220,220,220,0.2)",
                                    strokeColor: "rgba(220,220,220,1)",
                                    pointColor: "rgba(220,220,220,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    //data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
                                    data: [
                                    <?php
                                    foreach (array_reverse($object->query->results->quote) as $key => $item) {
                                       
                                        $date = new DateTime($item->Date);
                                        if ($mount != $date->format('F') || $date->format('d') == 15) {
                                            echo '"', $item->Close, '"', $key == $object->query->count - 1 ? '' : ',';
                                        }
                                        $mount = $date->format('F');
                                    }
                                    ?>
                                    ]
                                }
                            ]

                        }

                        window.onload = function () {
                            var ctx = document.getElementById("canvas").getContext("2d");
                            window.myLine = new Chart(ctx).Line(lineChartData, {
                                responsive: true
                            });

                            $('#for-datep').datepicker({
                                dateFormat: "yy-mm-dd"
                            });

                            $('#to-datep').datepicker({
                                dateFormat: "yy-mm-dd"
                            });
                        }


                    </script>

                </div>
            <?php }} ?>
            <?php if (!Yii::$app->user->isGuest) { ?>
            <h3>Найти в ручную</h3>


            <?php
            $form = ActiveForm::begin([
                        'id' => 'sh-form',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-1 control-label'],
                        ],
            ]);
            ?>



            <div class="row show-grid">
                
                <div class="col-lg-12">
                    <input type="text" name="sh" id="sh" value="<?php echo empty($dataPost['sh']) ? 'GOOGL' : $dataPost['sh'] ?>" />
                </div>
            </div>
            <div class="row show-grid">
                <div class="col-lg-3">
                    <div class="ui-widget">
                        <label for="for-datep">От: </label>
                        <input id="for-datep" name="for_datep" value="<?php echo empty($dataPost['for_datep']) ? '2015-01-01' : $dataPost['for_datep'] ?>" />
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ui-widget">
                        <label for="to-datep">До: </label>
                        <input id="to-datep" name="to_datep" value="<?php echo empty($dataPost['to_datep']) ? '2015-12-31' : $dataPost['to_datep'] ?>" />
                    </div>
                </div>
            </div>
            <?= Html::submitButton('Искать', ['class' => 'btn btn-primary', 'name' => 'sh-button']) ?>
            <?php ActiveForm::end(); ?>
            <?php } ?>
            <!--<form method="post" action="">
                <input type="text" value="" name="sh" placeholder="GOOGL" />
                <input type="submit" value="Найти" />
            </form>-->
            
            <?php
            if (!Yii::$app->user->isGuest) {?>
            <div class="row show-grid">
                <div class="col-lg-3">
                    <h2>List share</h2>

                    <ul class="list-share">
                        <?php 
                        $shModel = new Share();
                        foreach ($shModel->getShare() as $key => $item) { ?>
                        <li><?php echo $item->share; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php }?>

        </div>

    </div>
</div>
