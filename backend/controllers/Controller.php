<?php
namespace backend\controllers;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;


class Controller extends \yii\web\Controller
{
    public $menuItems;
    private $auth;

    public function init()
    {
        parent::init();
        $this->auth = [
            'Index' => '列表',
            'Create' => '创建',
            'Update' => '更新',
            'Edit' => '更新',
            'Save' => '更新',
            'MoveUp' => '上移',
            'MoveDown' => '下移',
            'Audit' => '审核',
            'Recommend' => '推荐',
            'Hot' => '置热',
            'Visible' => '可见',
            'Status' => '状态',
            'View' => '查看',
            'Detail' => '查看',
            'Delete' => '删除',
            'Assignment' => '授权',
            'Reset' => '重置',
            'AuthInitialize' => '权限索引',
            'DeletePicture' => '删除图片',
            'user/controllers/Admin' => [
                'role' => '员工管理',            //控制器中没有定义role属性时，从这里读取
                'permission' => [
                    'Reset' => '重置权限'       //重新定义控制器下的权限的名称
                ],
            ]
        ];
        //$this->authInitialize();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $controller = str_replace(' ','',ucwords(str_replace('-',' ',$action->controller->id)));
                            if(Yii::$app->authManager->getPermission($action->controller->module->id.'/controllers/'.$controller.'/'.ucfirst($action->id))){
                                if(Yii::$app->user->can($action->controller->module->id.'/controllers/'.$controller.'/'.ucfirst($action->id),[],false)){
                                    return true;
                                }else{
                                    return false;
                                }
                            }else{
                                return true;
                            }
                        }
                    ],
                ],
            ],
        ];
    }

    public function authInitialize()
    {

        $auth = yii::$app->authManager;
        $dir = Yii::$app->basePath.'/modules/';
        $roles = $auth->getRoles();
        foreach($roles as $item){
            if($item->name!='超级管理员' && $item->name!='管理员' && $item->data == 'system'){
                if(!file_exists($dir.$item->name.'Controller.php')){
                    $auth->removeChildren($item);
                    $auth->remove($item);
                }else{
                    $permissions = $auth->getChildren($item->name);
                    foreach($permissions as $value){
                        $controllerAction = explode('/', $value->name);
                        $controller = new \ReflectionClass('backend\modules\\'.$controllerAction[0].'\\'.$controllerAction[1].'\\'.$controllerAction[2].'Controller');
                        if(!$controller->hasMethod('action'.$controllerAction[3])){
                            $auth->remove($value);
                        }
                    }
                }
            }
        }
        $this->getControllers($dir);
    }

    public function getControllers($dir)
    {
        if(is_dir($dir)){
            if ($handler = opendir($dir)){
                while (($file = readdir($handler)) !== false){
                    if((is_dir($dir.$file)) && $file!="." && $file!=".."){
                        $this->getControllers($dir.$file."/");
                    }else{
                        if($file!="." && $file!=".." && strstr($file,'Controller')){
                            $this->setControllerAuth($file,$dir);
                        }
                    }
                }
                closedir($handler);
            }
        }
    }

    public function setControllerAuth($file,$dir)
    {
        $auth = yii::$app->authManager;
        $superAdmin = $auth->getRole('超级管理员');
        $admin = $auth->getRole('管理员');

        $module = strstr($dir,'modules');
        $name = str_replace('modules/','',$module).str_replace('Controller.php','',$file);
        $role = $auth->getRole($name);

        $controller = new \ReflectionClass('backend\\'.str_replace('/','\\',$module).str_replace('.php','',$file));
        $properties = $controller->getDefaultProperties();

        if($role === null){
            //创建角色
            $role = $auth->createRole($name);
            $role->description = ArrayHelper::getValue($properties,'auth',ArrayHelper::getValue($this->auth,$name.'.role',$name));
            $role->data = 'system';
            $auth->add($role);
        }

        //更新角色描述
        $role->description = ArrayHelper::getValue($properties,'auth',ArrayHelper::getValue($this->auth,$name.'.role',$name));
        $auth->update($name,$role);

        if(!$auth->hasChild($admin, $role)){
            $auth->addChild($admin, $role);
        }

        foreach($controller->getMethods() as $method){
            if($method->class==$controller->name&&strstr($method->name,'action')
                &&!strstr($method->name,'Ajax')&&$method->name!='actions'){
                $permission = $auth->getPermission($name.'/'.str_replace('action','',$method->name));
                $describe = ArrayHelper::getValue($this->auth,$name.'.permission.'.str_replace('action','',$method->name),ArrayHelper::getValue($this->auth,str_replace('action','',$method->name)));
                $description = $describe != ''?str_replace('管理','',$role->description).'-'.$describe:$name.'/'.str_replace('action','',$method->name);

                if($permission === null) {
                    //创建权限
                    $permission = $auth->createPermission($name . '/' . str_replace('action', '', $method->name));
                    $permission->description = $description;
                    $permission->data = 'system';
                    $auth->add($permission);
                }

                //更新权限描述
                $permission->description = $description;
                $auth->update($name.'/'.str_replace('action','',$method->name),$permission);

                if(!$auth->hasChild($superAdmin, $permission)){
                    $auth->addChild($superAdmin, $permission);
                }
                if(!$auth->hasChild($role, $permission)){
                    $auth->addChild($role, $permission);
                }
            }
        }

    }
}