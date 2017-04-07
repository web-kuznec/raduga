<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Панель управления</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $styles; ?>
        <?= $scripts; ?>
    </head>
    <body>
        <div class="main-wrapper">
            <div class="app" id="app">
                <header class="header">
                    <div class="header-block header-block-collapse hidden-lg-up"> <button class="collapse-btn" id="sidebar-collapse-btn">
    			<i class="fa fa-bars"></i>
    		</button> </div>
                    <div class="header-block header-block-search hidden-sm-down">
                        <form role="search">
                            <div class="input-container">
                                <div class="underline"></div>
                            </div>
                        </form>
                    </div>
                    <div class="header-block header-block-buttons"></div>
                    <div class="header-block header-block-nav">
                        <ul class="nav-profile">
                            <li class="notifications new">
                                <a href="" data-toggle="dropdown">
                                    <!--<i class="fa fa-bell-o"></i> <sup><span class="counter">8</span></sup>-->
                                </a>
                            </li>
                            <li class="profile dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <div class="img"> </div>
                                    <span class="name"> <?= $nick; ?> </span>
                                </a>
                                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" target="_blank" href="<?= URL::base(); ?>"> <i class="fa fa-user icon"></i> Главная </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" onclick="exitus();"> <i class="fa fa-power-off icon"></i> Выход </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>
                <aside class="sidebar">
                    <div class="sidebar-container">
                        <div class="sidebar-header">
                            <a href="<?= URL::base('http'); ?>" title="Главная" target="_blank">
                                <div class="brand">
                                    <div class="logo">
                                        <span class="l l1"></span>
                                        <span class="l l2"></span>
                                        <span class="l l3"></span>
                                        <span class="l l4"></span>
                                        <span class="l l5"></span>
                                    </div>
                                    Радуга 
                                </div>
                            </a>
                        </div>
                        <nav class="menu">
                            <ul class="nav metismenu" id="sidebar-menu">
                                <li <?php if($tag == 'admin') { echo 'class="active"'; } ?>>
                                    <a href="<?= URL::base('http'); ?>admin"> <i class="fa fa-home"></i> Главная </a>
                                </li>
                                <li <?php if($tag == 'blocks') { echo 'class="active"'; } ?>>
                                    <a> <i class="fa fa-home"></i> Блоки </a>
                                    <ul class="collapse <?php if($tag == 'blocks') { echo 'in'; } ?>" <?php if($tag != 'blocks') { echo 'style="height: 0px;"'; } ?> >
                                        <li><a href="<?= URL::base('http'); ?>admin/blocks">Сортировка</a></li>
                                        <li><a href="<?= URL::base('http'); ?>admin/blocks/logo">Логотип</a></li>
                                        <li><a href="<?= URL::base('http'); ?>admin/blocks/headers">Заголовок</a></li>
                                        <li><a href="<?= URL::base('http'); ?>admin/blocks/text">Текст</a></li>
                                        <li><a href="<?= URL::base('http'); ?>admin/blocks/banners">Баннеры</a></li>
                                    </ul>
                                </li>
                                <li <?php if($tag == 'settings') { echo 'class="active"'; } ?>>
                                    <a href="<?= URL::base('http'); ?>admin/settings"> <i class="fa fa-cog"></i> Настройки </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside>
                <div class="sidebar-overlay" id="sidebar-overlay"></div>
                <?php if(!empty($content)) echo $content; ?>
                <footer class="footer">
                    <div class="footer-block buttons"></div>
                    <div class="footer-block author"></div>
                </footer>
                <div class="modal fade" id="modal-media">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Информационное окно</h4>
                            </div>
                            <div class="modal-body modal-tab-container">
                                <div class="tab-content modal-tab-content">
                                    <div class="upload-container">
                                        <div id="dropzone"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <div class="modal fade" id="confirm-modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"> 
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title"><i class="fa fa-warning"></i> Alert</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure want to do this?</p>
                            </div>
                            <div class="modal-footer"> <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button> </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <?= $scripts_bottom; ?>
    </body>

</html>
