<?php
    use yii\helpers\Html;
?>
<div class="kv-detail-content" style="overflow:hidden">
    <h4>交易信息 <small>NO:<?=$model->trade_no;?></small></h4>

    <div class="row">
        <div class="col-sm-1 col-sm-offset-1">
            <?php
            if(!empty($model->orders)){
                foreach($model->orders as $key => $order) {
                    echo '<div class="text-center">';
                    if (!empty($order->picture_url)) {
                        echo Html::img('http://' . Yii::$app->params['domain']['image'] . $order->picture_url, ['class' => 'img-responsive img-thumbnail']);
                    } else {
                        echo Html::img('http://' . Yii::$app->params['domain']['image'] . $order->picture->path, ['class' => 'img-responsive img-thumbnail']);
                    }
                    echo $key == count($model->orders) - 1 ? '<div class="small text-muted">仅供参考</div>' : '';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="col-sm-7">
            <table class="table table-bordered table-condensed table-hover small kv-table">
                <tbody>
                <tr class="danger">
                    <th colspan="6" class="text-center text-danger">订单信息</th>
                </tr>
                <tr class="active">
                    <th>#</th>
                    <th>订单号</th>
                    <th>商品</th>
                    <th>SKU</th>
                    <th class="text-right">数量</th>
                    <th class="text-right">单价</th>
                </tr>
                <?php
                if(!empty($model->orders)){
                    foreach($model->orders as $key => $order){
                        echo '<tr>';
                        echo '<td>'.($key+1).'</td>';
                        echo '<td>'.$order->id.'</td>';
                        echo '<td>'.$order->product_name.'</td>';
                        echo '<td>'.$order->sku_name.'</td>';
                        echo '<td class="text-right">'.$order->num.'</td>';
                        echo '<td class="text-right">'.$order->price.'</td>';
                        echo '</tr>';
                    }
                }
                ?>
                <tr class="warning">
                    <th></th>
                    <th>小计</th>
                    <th colspan="4" class="text-right"><?=$model->total_amount; ?></th>
                </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-condensed table-hover small kv-table">
                <tbody>
                <tr class="success">
                    <th colspan="6" class="text-center text-success">物流信息</th>
                </tr>
                <tr class="active">
                    <th>#</th>
                    <th>快递公司</th>
                    <th>快递单号</th>
                    <th>物流状态</th>
                    <th>收货人姓名</th>
                    <th class="text-right">收货人电话</th>
                </tr>
                <?php
                if(!empty($model->orders)){
                    foreach($model->orders as $key => $order){
                        echo '<tr>';
                        echo '<td>'.($key+1).'</td>';
                        echo '<td>'.(isset($order->logistical)?$order->logistical->logistical_name:'无').'</td>';
                        echo '<td>'.(isset($order->logistical)?$order->logistical->logistical_no:'无').'</td>';
                        echo '<td>'.(isset($order->logistical)?$order->logistical->logistical_status:'无').'</td>';
                        echo '<td>'.$model->contact_name.'</td>';
                        echo '<td class="text-right">'.$model->contact_phone.'</td>';
                        echo '</tr>';
                    }
                }
                ?>
                <tr class="warning">
                    <th></th>
                    <th>收货人地址</th>
                    <th colspan="4" class="text-right"><?=$model->contact_address; ?></th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-2">
            <table class="table table-bordered table-condensed table-hover small kv-table">
                <tbody>
                <tr class="danger">
                    <th colspan="2" class="text-center text-danger">订单金额</th>
                </tr>
                <tr class="active">
                    <th>已付金额</th>
                    <td class="text-right"><?php echo $model->paid_amount;?></td>
                </tr>
                <tr class="active">
                    <th class="active">余额支付金额</th>
                    <td class="text-right">+ <?php echo $model->balance_amount;?></td>
                </tr>
                <tr class="active">
                    <th class="active">配送费用</th>
                    <td class="text-right">+ <?php echo $model->logistical_amount;?></td>
                </tr>
                <tr class="active">
                    <th class="active">积分抵用金额</th>
                    <td class="text-right">+ <?php echo $model->point_amount;?></td>
                </tr>
                <tr class="active">
                    <th class="active">优惠金额</th>
                    <td class="text-right">- <?php echo $model->discount_amount;?></td>
                </tr>
                <tr class="warning">
                    <th>订单总额</th>
                    <td class="text-right">= <?php echo $model->total_amount;?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
