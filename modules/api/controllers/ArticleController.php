<?php


namespace app\modules\api\controllers;


use app\modules\api\models\Article;
use app\modules\api\models\ArticleHasTranslations;
use yii\rest\ActiveController;
use yii\rest\Controller;

class ArticleController extends Controller
{
    public $modelClass = 'app\modules\api\models\Article';

    public function actionAll(){
        return ArticleHasTranslations::find()->all();
    }
}