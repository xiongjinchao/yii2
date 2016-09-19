<?php

namespace console\controllers;

use yii\console\Controller;

class SpiderController extends Controller
{
    //http://www.oicq88.com/wenyi/40.htm
    //http://wangming.vipyl.com
    public $links = [];
    public $host = '';
    public function actionIndex($start,$end)
    {
        for($i = $start;$i<=$end;$i++) {
            $this->host = 'http://www.oicq88.com';
            $this->links[] = $this->host . "/gexing/$i.htm";
        }
        $this->getArticles();
    }

    public function getLinks($url)
    {
        include_once(__DIR__ . '/../../common/components/dom/simple_html_dom.php');
        $html = file_get_html($url);
        $links = $html->find('.list p');
        foreach($links as $link){
            $this->links[] = $this->host.$link->href;
        }
    }

    public function getArticles()
    {
        include_once(__DIR__ . '/../../common/components/dom/simple_html_dom.php');
        if(empty($this->links)){
            echo 'Empty Links';
            return false;
        }
        $spaces=array(" ","　","\t","\n","\r","'","\"");
        $empty=array("","","","","","","");
        $file = fopen(__DIR__ . "/../../uploads/nickname_19.txt", "w") or die("Unable to open file!");
        foreach($this->links as $link){
            $html = file_get_html($link);
            $contents = $html->find('.list p');
            foreach($contents as $content){
                try {
                    $name = $content->innertext;
                }catch (\Exception $e){
                    echo $e->getMessage()."\n";
                    continue;
                }
                //$name = iconv("UTF-8", "GB2312//IGNORE", $name);
                //$name = iconv("UTF-8", "GB2312//IGNORE", $name);
                $name = str_replace($spaces,$empty,$name);
                print_r($name."\n");
                fwrite($file, $name."\r\n");
                /*

                $model = new \common\models\Nickname();
                $model->nickname = $name;
                if(!$model->validate('nickname')){
                    echo $name."\n";
                    echo $model->getFirstError('nickname')."\n";
                    continue;
                }else{
                    $model->save();
                }
                */
            }
        }
        fclose($file);
    }

    public function actionSaveArticles($number)
    {
        $file = __DIR__ . "/../../uploads/nickname_".$number.".txt";
        $handle  = fopen($file, "r") or die("Unable to open file!");
        $content = fread($handle, filesize($file));
        $content = explode("\r\n",$content);
        foreach($content as $name){
            $spaces=array(" ","　","\t","\n","\r","'","\"");
            $empty=array("","","","","","","");
            $name = str_replace($spaces,$empty,$name);
            $model = new \common\models\Nickname();
            $model->nickname = $name;
            if(!$model->validate('nickname')){
                echo $model->getFirstError('nickname')."\n";
                continue;
            }else{
                $model->save();
            }
        }
        fclose($handle);
    }
}