<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            */
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $controller = Yii::$app->request->get('controller');
        $keyword = Yii::$app->request->get('keyword');
        if($controller) {
            switch ($controller) {
                case 'article':
                    return $this->redirect(['/content/article/index','ArticleSearch[title]'=>$keyword]);
                break;
                case 'admin':
                    return $this->redirect(['/user/admin/index','AdminSearch[username]'=>$keyword]);
                    break;
                case 'user':
                    return $this->redirect(['/user/user/index','UserSearch[username]'=>$keyword]);
                    break;
                default :
                    return $this->redirect(Yii::$app->request->getReferrer());
                    break;
            }
        }

        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
