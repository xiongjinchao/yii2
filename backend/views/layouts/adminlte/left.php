<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>管理员</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>

        <!-- search form -->
        <form action="<?php echo \yii\helpers\Url::to(['/site/index'])?>" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="搜索..."/>
                <input type="hidden" name="controller" value="<?php echo Yii::$app->controller->id;?>">
              <span class="input-group-btn">
                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => '内容管理', 'options' => ['class' => 'header']],
                    [
                        'label' => '内容管理',
                        'icon' => 'fa fa-paw',
                        'url' => '#',
                        'items' => [
                            ['label' => '菜单管理', 'icon' => 'fa fa-list text-light-blue', 'url' => ['/content/menu/index']],
                            ['label' => '文章管理', 'icon' => 'fa fa-file-text text-light-blue', 'url' => ['/content/article/index']],
                            ['label' => '文章分类', 'icon' => 'fa fa-navicon text-light-blue', 'url' => ['/content/article-category/index']],
                            ['label' => '评论管理', 'icon' => 'fa fa-comments text-light-blue', 'url' => ['/content/comment/index']],
                            ['label' => '单页管理', 'icon' => 'fa fa-file text-light-blue', 'url' => ['/content/page/index']],
                            ['label' => '推荐管理', 'icon' => 'fa fa-coffee text-light-blue', 'url' => ['/content/recommendation-category/index']],
                        ],
                    ],
                    [
                        'label' => '商品管理',
                        'icon' => 'fa fa-tags',
                        'url' => '#',
                        'items' => [
                            ['label' => '商品管理', 'icon' => 'fa fa-cubes text-maroon', 'url' => ['/product/goods/index']],
                            ['label' => '商品分类', 'icon' => 'fa fa-navicon text-maroon', 'url' => ['/product/goods-category/index']],
                            ['label' => '属性管理', 'icon' => 'fa fa-gears text-maroon', 'url' => ['/product/attribute-name/index']],
                            ['label' => 'SKU管理', 'icon' => 'fa fa-globe text-maroon', 'url' => ['/product/product/index']],
                        ],
                    ],
                    ['label' => '交易管理', 'options' => ['class' => 'header']],
                    [
                        'label' => '交易管理',
                        'icon' => 'fa fa-shopping-cart',
                        'url' => '#',
                        'items' => [
                            ['label' => '订单管理', 'icon' => 'fa fa-credit-card text-purple', 'url' => '#'],
                            ['label' => '发货纪录', 'icon' => 'fa fa-paper-plane text-purple', 'url' => '#'],
                            ['label' => '退款纪录', 'icon' => 'fa fa-refresh text-purple', 'url' => '#'],
                        ],
                    ],
                    ['label' => '用户权限', 'options' => ['class' => 'header']],
                    [
                        'label' => '用户管理',
                        'icon' => 'fa fa-graduation-cap',
                        'url' => '#',
                        'items' => [
                            ['label' => '客户管理', 'icon' => 'fa fa-user text-orange', 'url' => ['/user/user/index']],
                            ['label' => '员工管理', 'icon' => 'fa fa-user-secret text-orange', 'url' => ['/user/admin/index']],
                        ],
                    ],
                    [
                        'label' => '角色管理',
                        'icon' => 'fa fa-anchor',
                        'url' => ['/user/role/index'],
                    ],
                    ['label' => '其他', 'options' => ['class' => 'header']],
                    [
                        'label' => '常用工具',
                        'icon' => 'fa fa-gears',
                        'url' => '#',
                        'items' => [
                            ['label' => '代码生成', 'icon' => 'fa fa-rocket text-olive', 'url' => ['/gii'],],
                            ['label' => '性能调试', 'icon' => 'fa fa-pie-chart text-olive', 'url' => ['/debug'],]
                        ],
                    ],

                    ['label' => '退出登录', 'url' => ['site/logout'], 'icon'=>'fa fa-power-off text-red', 'visible' => Yii::$app->user->id>0, 'linkOptions' => ['data-method' => 'post']],
                ],
            ]
        ) ?>

    </section>

</aside>
