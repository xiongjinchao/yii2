<?php

use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
?>
<div class="studio-content-wrapper">
    <section class="content-header">
        <div class="header-help pull-right"><i class="fa  fa-question-circle"></i> 帮助和服务</div>
        <?=Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>

    <section class="footer">
        <i class="glyphicon glyphicon-fire logo-image"></i> <?=Yii::$app->name;?>
    </section>

</div>
