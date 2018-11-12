<?php
namespace frontend\controllers;

use Yii;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use common\models\Category;
use common\models\Product;
use common\models\ProductImage;
use common\models\Brand;
use common\models\Order;
use common\models\OrderItem;
use yii\web\Controller;
use yii\data\Pagination;

class CatalogController extends Controller
{
	public function actionList()
	{
	    $prodQuery = Product::find()->where(['not',['quantity'=>0]]);

		$selected_category = null;

		//global search
		if($gsearch = Yii::$app->request->get('gsearch')){
		    $prodQuery->andFilterWhere(['like', 'title', $gsearch])->orFilterWhere(['like', 'description', $gsearch]);
		}
		
		//menu
		$categories = Category::find()->all();
		
		if($categ = Yii::$app->request->get('choosed_category')){
		    $category = Category::findOne(['title' => $categ]);
			$prodQuery->andFilterWhere(['category_id' => $category->id]);
		    $selected_category = $category;
		};
		
		
		//filters
		if(Yii::$app->request->get('less100')){
			$prodQuery->andFilterWhere(['<', 'price', 100]);
		}else if(Yii::$app->request->get('from100to500')){
			$prodQuery->andFilterWhere(['between', 'price', 100, 500]);
		}else if(Yii::$app->request->get('pr1k_10k')){
			$prodQuery->andFilterWhere(['between', 'price', 1000, 10000]);
		}else if(Yii::$app->request->get('pr10k_20k')){
			$prodQuery->andFilterWhere(['between', 'price', 10000, 20000]);
		}else if(Yii::$app->request->get('more20k')){
			$prodQuery->andFilterWhere(['>', 'price', 20000]);
		}else{}
		
		
		
		
		
		
		$pagination = new Pagination(['defaultPageSize' => 4, 'totalCount' => $prodQuery->count()]);
		
		//sorting
		$selected_sort = null;
		
		if($sort = Yii::$app->request->get('select_item')){
			switch($sort){
			case 'default': $model = $prodQuery->indexBy('id')->orderBy('id')->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
			$selected_sort = 'default';
			break;
			case 'newsort': $model = $prodQuery->indexBy('id')->orderBy('id DESC')->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
			$selected_sort = 'newsort';
			break;
			case 'price_low': $model = $prodQuery->indexBy('id')->orderBy('price')->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
			$selected_sort = 'price_low';
			break;
			case 'price_high': $model = $prodQuery->indexBy('id')->orderBy('price DESC')->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
			$selected_sort = 'price_high';
			break;
			}
		}else{
		    $model = $prodQuery->indexBy('id')->orderBy('id')->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
			$selected_sort = 'default';
		}
		
		return $this->render('list', [
		'categories' => $categories,
		'model' => $model,
		'selected_category' => $selected_category,
		'selected_sort' => $selected_sort,
		'pagination' => $pagination,
        'category' => $selected_category
		]);
	}

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function actionSearch() {

        $q = Yii::$app->request->post('query');

        if(Yii::$app->request->post('category') !== 0){
            $category = Yii::$app->request->post('category');

            $category = Category::findOne(['title' => $category]);

            $query = Product::find()->FilterWhere(['like', 'title', $q])->orFilterWhere(['like', 'description', $q])->andFilterWhere(['category_id' => $category->id])->all();
        }
        else $query = Product::find()->FilterWhere(['like', 'title', $q])->orFilterWhere(['like', 'description', $q])->all();

       $html = '';


       if (count($query) > 0) {
           foreach ($query as $row) {
               $html.= '<div class="col-md-4 agileinfo_new_products_grid agileinfo_new_products_grid_mobiles">
							<div class="agile_ecommerce_tab_left mobiles_grid">
								<div class="hs-wrapper hs-wrapper2">' ;

               foreach(\common\models\Product::getProductImagesById($row['id']) as $primage):
                   $html.= Html::img(\common\models\ProductImage::getProductImgUrl($primage['id'], $primage['product_id']), ['class' => 'img-responsive']);
               endforeach;


               $html.='</div>';

               $html.= '<h5><a href="#">'.$row['title'].'</a></h5>
               <p>'.$row['description'].'</p> 
           <div class="simpleCart_shelfItem">';
               $html.= Html::beginForm(['cart/add', 'productId' => $row['id']], 'post');

               $html.= ' <div class="color-quality">
                                    <ul>
                                        <li><a href="#"><span></span></a></li>
                                        <li><a href="#" class="brown"><span></span></a></li>
                                        <li><a href="#" class="purple"><span></span></a></li>
                                        <li><a href="#" class="gray"><span></span></a></li>
                                    </ul>
                                    <ul>
                                        <li><input type="radio" name="selected_color" value="red"  /></li>
                                        <li><input type="radio" name="selected_color" value="blue" /></li>
                                        <li><input type="radio" name="selected_color" value="brown" /></li>
                                        <li><input type="radio" name="selected_color" value="purple" /></li>
                                    </ul>
                                </div>';

               $html.= '<div class="simpleCart_shelfItem">
                                    <p>';
               if(\Yii::$app->user->isGuest):

                   $html.= '<i class="item_price">$'.$row['price'].'</i>';
               else:

                   $html.= '<span>$'.$row['price'].'</span> <i class="item_price">$'.$row['price']*0.8.'</i>';

               endif;

               $html.= '</p>
                    <button type="submit" name="add_btn" class="w3ls-cart">Добавить</button>
                                </div>';

               $html.= Html::endForm();
               $html.= '
           </div> 
           </div> 
		   </div>
		   </div>';
           }
           $html.= '<div class="clearfix"> </div>';
           return $html;
       }
       else return 'Товары не найдены';


    }
	
	
	
	
}
