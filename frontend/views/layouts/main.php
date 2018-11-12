<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

$cart = \Yii::$app->session;

$obj = \Yii::$app->cart;
$goods_add = $obj->getCount();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<link href='//fonts.googleapis.com/css?family=Glegoo:400,700' rel='stylesheet' type='text/css'>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
	
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <!-- header modal -->
	<div class="modal fade" id="myModal88" tabindex="-1" role="dialog" aria-labelledby="myModal88"
		aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;</button>
					<h4 class="modal-title" id="myModalLabel">Доступ к кабинету</h4>
				</div>
				<div class="modal-body modal-body-sub">
					<div class="row">
						<div class="col-md-8 modal_body_left modal_body_left1" style="border-right: 1px dotted #C2C2C2;padding-right:3em;">
							<div class="sap_tabs">	
								<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
									<ul>
									<?php if (Yii::$app->user->isGuest): ?>
										<li class="resp-tab-item" aria-controls="tab_item-0"><?=Html::a('<span>Войти</span>', ['site/login']) ?></li>
										<li class="resp-tab-item" aria-controls="tab_item-1"><?=Html::a('<span>Зарегистрироваться</span>', ['site/signup']) ?></li>
									<?php else: ?>
									    <li class="resp-tab-item" aria-controls="tab_item-1">
										<?= Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Выйти (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']). Html::endForm() ?>
										</li>
									<?php endif; ?>
									</ul>		
									
											        					            	      
								</div>	
							</div>
							<script src="/frontend/web/js/easyResponsiveTabs.js" type="text/javascript"></script>
							<?php $this->registerJs('
								$(document).ready(function () {
									$("#horizontalTab").easyResponsiveTabs({
										type: "default", //Types: default, vertical, accordion           
										width: "auto", //auto or any width like 600px
										fit: true   // 100% fit in a container
									});
								});
							'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
        jQuery.noConflict( true );
		$('#myModal88').modal('show');
	</script>  
	<!-- //header modal -->
	<!-- header -->
	<div class="header" id="home1">
		<div class="container">
			<div class="w3l_login">
				<a href="#" data-toggle="modal" data-target="#myModal88"><span class="fa fa-user" aria-hidden="true"></span></a>
			</div>
			<div class="search">
				<input class="search_box" type="checkbox" id="search_box">
				<label class="icon-search" for="search_box"><span class="fa fa-search" aria-hidden="true"></span></label>
				<div class="search_form">
					<?= Html::beginForm(['catalog/list'], 'get'); ?>
						<input type="text" name="gsearch" placeholder="Поиск..."><input type="submit" name="_search_prod" value="Find">
					<?= Html::endForm(); ?>
				</div>
			</div>
			<div class="cart cart box_1">
				<?=Html::a('<button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i><b style="margin: 5px;">'.$goods_add.'</b></button>', ['cart/list']) ?>
			</div>  
		</div>
	</div>
	<!-- //header -->
    <?php
    NavBar::begin([
        'options' => [
		    'id' => 'bs-megadropdown-tabs',
            'class' => 'nav navbar-inverse',
        ],
    ]);
    $menuItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
		['label' => 'Товары', 'url' => ['/catalog/list']],
        ['label' => 'О нас', 'url' => ['/site/about']],
        ['label' => 'Поддержка', 'url' => ['/site/contact']],
    ];
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
	
</div>



<footer class="footer">
		<div class="footer-copy">
			<div class="container">
				<p>&copy; <?=date('Y') ?> Sitename</p>
			</div>
		</div>

</footer>

<?php $this->endBody();

$js = <<<JS
    $('form').on('keyup', function(){
       var data = $(this).serialize();
        $.ajax({
            url: '/catalog/search',
            type: 'POST',
            data: data,
            success: function(res){
                console.log(res);
            },
            error: function(){
                alert('Error!');
            }
        });
        return false;
    });
JS;
?>
<script>
    function search_goods() {
       var query = $('#g_search').val(),
       url = 'catalog/search',
       csrfToken = $('meta[name="csrf-token"]').attr("content"),
           category = $('#category').val();

       $.post(
           url,
           {
               query: query,
               category : category,
               _csrf: csrfToken

           },
           function success(data) {
               $('#goods').html(data);
               console.log(data);
           }
       );
    }
</script>


</body>
</html>
<?php $this->endPage() ?>
