<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Панель управления</title>
        <?= $styles; ?>
        <?= $scripts; ?>
    </head>
    <body>
        <header id="header">
            <hgroup>
                <h1 class="site_title"><a href="<?= URL::base('http', TRUE); ?>admin/">Панель управления</a></h1>
                <h2 class="section_title"><a href="<?= URL::base('http', TRUE); ?>" target="_blank">Главная</a></h2>
                <div class="btn_view_site"><a onclick="exitus();">Выход</a></div>
            </hgroup>
        </header>
        <aside id="sidebar" class="column"><?php
            if(!empty($menu))
                echo $menu; ?>
        </aside>
        <section id="main" class="column">
            <article class="module width_full">
                <header><?php
                    if(!empty($name))
                    { ?>
                        <div class="fleft">
                            <h3><?= $name; ?></h3>
                        </div><?php
                    } 
                    if(!empty($action))
                    { ?>
                        <div class="fright">
                            <?= $action; ?>
                        </div><?php
                    } ?>
                    <div class="clear"></div>
                </header>
                <div class="module_content">
                    <?php if(!empty($content)) echo $content; ?>
                    <div class="clear"></div>
                </div>
            </article>
            <div class="spacer"></div>
        </section>
    </body>
</html>