<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>管理员</p>
                <a href="#"><i class="circle text-success"></i> 在线</a>
            </div>
        </div>

        <!-- search form -->
        <form action="<?php echo \yii\helpers\Url::to(['/site/index'])?>" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="搜索..."/>
                <input type="hidden" name="controller" value="<?php echo Yii::$app->controller->id;?>">
              <span class="input-group-btn">
                <button type='submit' id='search-btn' class="btn btn-flat"><i class="search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree','data-widget'=>'tree'],
                'items' => [
                    ['label' => '内容', 'options' => ['class' => 'header']],
                    [
                        'label' => '内容管理',
                        'icon' => 'th-large',
                        'url' => '#',
                        'items' => [
                            ['label' => '菜单管理', 'icon' => 'list text-light-blue', 'url' => ['/content/menu/index']],
                            ['label' => '文章管理', 'icon' => 'file-text text-light-blue', 'url' => ['/content/article/index']],
                            ['label' => '文章分类', 'icon' => 'navicon text-light-blue', 'url' => ['/content/article-category/index']],
                            ['label' => '评论管理', 'icon' => 'comments text-light-blue', 'url' => ['/content/comment/index']],
                            ['label' => '单页管理', 'icon' => 'file text-light-blue', 'url' => ['/content/page/index']],
                            ['label' => '推荐管理', 'icon' => 'rocket text-light-blue', 'url' => ['/content/recommendation-category/index']],
                        ],
                    ],
                    ['label' => '商品', 'options' => ['class' => 'header']],
                    [
                        'label' => '商品管理',
                        'icon' => 'tags',
                        'url' => '#',
                        'items' => [
                            ['label' => '商品管理', 'icon' => 'cubes text-maroon', 'url' => ['/product/goods/index']],
                            ['label' => '商品分类', 'icon' => 'navicon text-maroon', 'url' => ['/product/goods-category/index']],
                            ['label' => '属性管理', 'icon' => 'gears text-maroon', 'url' => ['/product/attribute-name/index']],
                            ['label' => 'SKU管理', 'icon' => 'globe text-maroon', 'url' => ['/product/goods-attribute']],
                        ],
                    ],
                    ['label' => '交易', 'options' => ['class' => 'header']],
                    [
                        'label' => '交易管理',
                        'icon' => 'shopping-cart',
                        'url' => '#',
                        'items' => [
                            ['label' => '交易管理', 'icon' => 'paypal text-purple', 'url' => ['/business/trade/index']],
                            ['label' => '订单管理', 'icon' => 'google-wallet text-purple', 'url' => ['/business/trade-order/index']],
                            ['label' => '支付纪录', 'icon' => 'calendar text-purple', 'url' => ['/business/trade-payment/index']],
                            ['label' => '物流管理', 'icon' => 'paper-plane text-purple', 'url' => ['/business/trade-logistical/index']],
                            ['label' => '退款纪录', 'icon' => 'refresh text-purple', 'url' => ['/business/trade-refund/index']],
                        ],
                    ],
                    ['label' => '用户&权限', 'options' => ['class' => 'header']],
                    [
                        'label' => '用户管理',
                        'icon' => 'graduation-cap',
                        'url' => '#',
                        'items' => [
                            ['label' => '客户管理', 'icon' => 'user text-orange', 'url' => ['/user/user/index']],
                            ['label' => '员工管理', 'icon' => 'user-secret text-orange', 'url' => ['/user/admin/index']],
                        ],
                    ],
                    [
                        'label' => '角色管理',
                        'icon' => 'anchor',
                        'url' => ['/user/role/index'],
                    ],
                    ['label' => '其他', 'options' => ['class' => 'header']],
                    [
                        'label' => '常用工具',
                        'icon' => 'gears',
                        'url' => '#',
                        'items' => [
                            ['label' => '代码生成', 'icon' => 'rocket text-olive', 'url' => ['/gii'],],
                            ['label' => '性能日志', 'icon' => 'pie-chart text-olive', 'url' => ['/debug'],]
                        ],
                    ],

                    ['label' => '退出登录', 'url' => ['/site/logout'], 'icon'=>'power-off text-red', 'visible' => Yii::$app->user->id>0, 'options' => ['class' => 'logout']],
                ],
            ]
        ) ?>

    </section>

</aside>
