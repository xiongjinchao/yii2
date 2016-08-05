<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use api\components\RangerException;

/**
 * Site controller
 */
class RangerController extends Controller
{
    public $enableCsrfValidation = false;

    public function checkoutLogin($params)
    {
        if(!$params['query']['token']){
            RangerException::throwException(RangerException::ERROR_TOKEN);
        }else{
            //checkout token
        }

        return true;
    }
}