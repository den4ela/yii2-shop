#### Покупатель:

* //yii2-shop/frontend/web/index.php/login
* //yii2-shop/frontend/web/index.php/register
* //yii2-shop/frontend/web/index.php/site/request-password-reset

- login : txtden
- password : 123456


#### Админ:
* //yii2-shop/backend/web/index.php/site/login

- login : den4ela
- password : 123456


#### Установка:
 - клонируйте рипозиторий;
 - выполните composer install;
 - в файле common\config\main-params.php установите параметры БД;
 - импортируйте БД (yii2-shop.sql);
 - в common\config\bootstrap.php - frontendWebroot и backendWebroot изменить под свой домен;
 - для прав админа назначить атрибут (role = 20)
 
 
#### Создать, если этих каталогов нет:
  - backend\web\banners загрузка баннеров
  - frontend\web\images\brands загрузка брендов
  - frontend\web\images\categories загрузка img категорий
  - frontend\web\images\products загрузка img товаров

 
 #### Требования:
 - php >= 5.6.0
 - mysql >= 5.5
