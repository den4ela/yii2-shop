<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Админ-панель';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Панель управления</h1>
    </div>

    <div class="body-content">
        <h3>Статистика:</h3>
        <div class="row">
            <div class="col-lg-4">
                <h2>Пользователи</h2>

                <p><?=$user_count-1 ?></p>

            </div>
            <div class="col-lg-4">
                <h2>Товары</h2>

                <p><?=$product_count ?></p>

            </div>
            <div class="col-lg-4">
                <h2>Заказы</h2>

                <p><?=$order_count ?></p>

            </div>
        </div>
		
		<h3>Основной баннер</h3>

		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
	
	    <?= $form->field($upload_form, 'files')->fileInput(['multiple' => false]) ?>
	
	    <?=Html::submitButton('Загрузить', ['class' => 'btn btn-info']) ?>
	
	    <?php ActiveForm::end(); ?>
		
		<?=Html::a('Удалить', ['site/delete-banner'], ['class' => 'btn btn-warning']) ?>
	
	
	    <?=Html::img(\backend\models\SiteSettings::getMainBannerUrl()) ?>
		
    </div>
</div>
