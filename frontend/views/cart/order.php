<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Order';

if(Yii::$app->user->isGuest){
    $cust_type = \common\models\Order::GUEST;
}else{
    $cust_type = \common\models\Order::USER;
}

?>
<div style="min-height:400px; ">
    <h2>Оформление заказа</h2>
    <h3>Информация:</h3>
    <div class="row" style="height:20px !important">
        <div class="col-xs-3"><strong>Название</strong></div>
        <div class="col-xs-3"><strong>Цена</strong></div>
        <div class="col-xs-2"><strong>Цвет</strong></div>
        <div class="col-xs-2"><strong>Количество</strong></div>
        <div class="col-xs-2"><strong>Итого</strong></div>
    </div>
    <?php foreach($products as $product): ?>
        <div class="row" style="height:20px !important">
            <div class="col-xs-3"><?=$product->title ?></div>
            <div class="col-xs-3">$<?=$product->getPrice() ?></div>
            <div class="col-xs-2"><?=\Yii::$app->session->get('item_'.$product->getId()) ?></div>
            <div class="col-xs-2"><?=$product->getQuantity() ?></div>
            <div class="col-xs-2">$<?=$product->getPrice()*$product->getQuantity() ?></div>
        </div>
    <?php endforeach; ?>
    <br>
    <strong>Итого: $<?=$total ?></strong>

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'customer_type')->hiddenInput(['value' => $cust_type])->label(false) ?>
    <div class="row">
        <h4>Личная информация:</h4>
        <div class="col-xs-5">
            <?= $form->field($model, 'surname')->label('Фамилия') ?>
        </div>
        <div class="col-xs-5">
            <?= $form->field($model, 'name')->label('Имя') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <h4>Адрес доставки:</h4>
            <?= $form->field($model, 'country')->label('Страна') ?>

            <?= $form->field($model, 'region')->label('Область') ?>

            <?= $form->field($model, 'city')->label('Город') ?>

            <?= $form->field($model, 'address')->label('Адрес') ?>

            <?= $form->field($model, 'zip_code')->label('Индекс') ?>
        </div>
        <div class="col-xs-5">
            <h4>Контакты:</h4>
            <?= $form->field($model, 'phone')->label('Телефон') ?>

            <?= $form->field($model, 'email') ?>
        </div>
    </div>

    <?= $form->field($model, 'notes')->textArea()->label('Доп. информация') ?>

    <?= $form->field($model, 'status')->hiddenInput(['value' => 'new'])->label(false) ?>

    <?= Html::submitButton('Заказать', ['class' => 'btn btn-default', 'style' => 'color:#cc0000']); ?>

    <?php ActiveForm::end() ?>
</div>