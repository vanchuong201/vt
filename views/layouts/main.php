<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>">
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0">
                    <!--                    <a style="display: block; width: 80%; height: 80%; margin: auto; margin-top: 5px;">-->
                    <!--                        --><?php // echo Html::img('css/images/logo_gtel.png',['style'=>' height:100%'])?>
                    <!--                    </a>-->
                    <!--
                                        <a href="/" class="site_title">
                                            <i class="fa fa-paw"></i>
                                            <span>VQR Solution</span>
                                        </a>
                    -->


                    <a href="/" class="">
                        <i class="" style="display: inline-block; height: 100%; margin-top: 10px; margin-left: 3px;">
                            <?= Html::img('/css/images/logo_gtel1.png', ['style' => ' height:80%']) ?>
                        </i>

                        <span><?= Html::img('/css/images/logo_gtel2.png', ['style' => ' height:80%']) ?></span>
                    </a>


                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="http://placehold.it/128x128" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Xin chào,</span>
                        <h2><?= !empty(Yii::$app->user->identity->full_name) ? Yii::$app->user->identity->full_name : '&nbsp;&nbsp;' ?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <h3>&nbsp;</h3>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    ["label" => "Giới thiệu", "url" => "/", "icon" => "info-circle"],

                                    [
                                        'label' => 'Quản lý thành viên', 'icon' => 'users', 'url' => "#",
                                        'items' => [
                                            ['label' => 'Danh sách thành viên', 'icon' => 'user', 'url' => ['/user/index'],],
                                            ['label' => 'Nhóm quyền', 'icon' => 'users', 'url' => ['/role'],],
                                            ['label' => 'Danh sách quyền', 'icon' => 'expeditedssl', 'url' => ['/permission'], 'visible'=>Yii::$app->user->isAdminGroup],
                                            ['label' => 'Xem log đăng nhập', 'icon' => 'sticky-note-o', 'url' => ['/user-visit-log/index'], 'visible'=>Yii::$app->user->isAdminGroup],
                                        ]
                                    ],

                                    [
                                        'label' => 'Quản lý lô tem', 'icon' => 'tags', 'url' => "#",
                                        'items' => [
                                            ['label' => 'Danh sách sản phẩm', 'icon' => 'barcode', 'url' => ['/products'],],
                                            ['label' => 'Danh sách lô tem', 'icon' => 'tag', 'url' => ['/parcel-stamp'],],
                                            ['label' => 'Danh sách tem', 'icon' => 'list-ol', 'url' => ['/stamps'],],
                                            ['label' => 'Kích hoạt tem', 'icon' => 'certificate', 'url' => ['/stamps/active'],],
                                            ['label' => 'Lịch sử kích hoạt tem', 'icon' => 'history', 'url' => ['/stamps/logs-active'],],
                                        ]
                                    ],

                                    [
                                        'label' => 'Dịch vụ chống giả', 'icon' => 'asterisk', 'url' => "#",
                                        'items' => [
                                            ['label' => 'Danh sách tem', 'icon' => 'qrcode', 'url' => ['#'],],
                                            ['label' => 'Lịch sử quét tem', 'icon' => 'history', 'url' => ['#'],],
                                            ['label' => 'Thống kê quét tem', 'icon' => 'bar-chart', 'url' => ['#'],],
                                        ]
                                    ],

                                    [
                                        "label" => "Thông tin tài khoản",
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ['label' => 'Login', 'url' => ['/u/auth/login']],
                                            ['label' => 'Logout', 'url' => ['/user-management/auth/logout']],
                                            ['label' => 'Registration', 'url' => ['/user-management/auth/registration']],
                                            ['label' => 'Change own password', 'url' => ['/user-management/auth/change-own-password']],
                                            ['label' => 'Password recovery', 'url' => ['/user-management/auth/password-recovery']],
                                            ['label' => 'E-mail confirmation', 'url' => ['/user-management/auth/confirm-email']],
                                        ],
                                    ],

//                                    ["label" => "Layout", "url" => ["site/layout"], "icon" => "files-o"],
//                                    ["label" => "Error page", "url" => ["site/error-page"], "icon" => "close"],
//                                    [
//                                        "label" => "Widgets",
//                                        "icon" => "th",
//                                        "url" => "#",
//                                        "items" => [
//                                            ["label" => "Menu", "url" => ["site/menu"]],
//                                            ["label" => "Panel", "url" => ["site/panel"]],
//                                        ],
//                                    ],
//                                    [
//                                        "label" => "Badges",
//                                        "url" => "#",
//                                        "icon" => "table",
//                                        "items" => [
//                                            [
//                                                "label" => "Default",
//                                                "url" => "#",
//                                                "badge" => "123",
//                                            ],
//                                            [
//                                                "label" => "Success",
//                                                "url" => "#",
//                                                "badge" => "new",
//                                                "badgeOptions" => ["class" => "label-success"],
//                                            ],
//                                            [
//                                                "label" => "Danger",
//                                                "url" => "#",
//                                                "badge" => "!",
//                                                "badgeOptions" => ["class" => "label-danger"],
//                                            ],
//                                        ],
//                                    ],
//                                    [
//                                        "label" => "Multilevel",
//                                        "url" => "#",
//                                        "icon" => "table",
//                                        "items" => [
//                                            [
//                                                "label" => "Second level 1",
//                                                "url" => "#",
//                                            ],
//                                            [
//                                                "label" => "Second level 2",
//                                                "url" => "#",
//                                                "items" => [
//                                                    [
//                                                        "label" => "Third level 1",
//                                                        "url" => "#",
//                                                    ],
//                                                    [
//                                                        "label" => "Third level 2",
//                                                        "url" => "#",
//                                                    ],
//                                                ],
//                                            ],
//                                        ],
//                                    ],
                                ],
                            ]
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img src="http://placehold.it/128x128"
                                     alt=""><?php echo @Yii::$app->user->identity->full_name ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="javascript:;"> Profile</a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">Help</a>
                                </li>
                                <li><a href="/user-management/auth/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image"/>
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image"/>
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image"/>
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image"/>
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a href="/">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if (isset($this->title)): ?>
                        <div class="page-title">
                            <!--                    <div class="title_left">-->
                            <!--                        <h1>--><?php //echo $this->title ?><!--</h1>-->
                            <!--                    </div>-->
                            <div class="text-right">
                                <!--                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">-->
                                <!--                            <div class="input-group">-->
                                <!--                                <input type="text" class="form-control" placeholder="Search for...">-->
                                <!--                                <span class="input-group-btn">-->
                                <!--                                <button class="btn btn-default" type="button">Go!</button>-->
                                <!--                            </span>-->
                                <!--                            </div>-->
                                <!--                        </div>-->
                                <?=
                                \yii\widgets\Breadcrumbs::widget(
                                    [
                                        'homeLink' => [
                                            'label' => Yii::t('yii', 'Trang chủ'),
                                            'url' => Yii::$app->homeUrl,
                                        ],
                                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                    ]
                                ) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success text-left">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (Yii::$app->session->hasFlash('warning')): ?>
                        <div class="alert alert-warning text-left">
                            <?= Yii::$app->session->getFlash('warning') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (Yii::$app->session->hasFlash('danger')): ?>
                        <div class="alert alert-danger text-left">
                            <?= Yii::$app->session->getFlash('danger') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $this->title ?> <small><?=@$this->params['description']?></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
<!--                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com" rel="nofollow" target="_blank">Colorlib</a><br/>-->
<!--                Extension for Yii framework 2 by <a href="http://yiister.ru" rel="nofollow" target="_blank">Yiister</a>-->
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
