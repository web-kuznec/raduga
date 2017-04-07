<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title">
            Баннеры <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div><?php
    foreach($banners as $k => $v)
    { ?>
        <form name="item" enctype="multipart/form-data" method="POST">
            <div class="card card-block">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <p>Баннер №<?= $k+1; ?></p>
                            <img style="max-width:500px;" src="/public/banners/<?= $v->id; ?>/<?= $v->img; ?>"><br>
                            <label class="form-control-label text-xs-right">Загрузить другой баннер:</label>
                            <input type="file" name="ban" class="form-control boxed" />
                            <label class="form-control-label text-xs-right">ссылка:</label>
                            <input type=text name="href" class="form-control boxed" value="<?= $v->href; ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?= $v->id; ?>">
                    <button class="btn-primary btn" type="submit">Сохранить</button>
                    <a href="/admin/blocks/bannerdell/<?= $v->id; ?>"><button class="btn-danger btn" type="button">Удалить баннер</button></a>
                </div>
            </div>
        </form><?php
    }
    if($count < $limit) { ?>
        <form name="item" enctype="multipart/form-data" method="POST" action="/admin/blocks/bannersnew">
            <div class="card card-block">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-control-label text-xs-right">Загрузить новый баннер:</label>
                            <input type="file" name="ban" class="form-control boxed" />
                            <label class="form-control-label text-xs-right">ссылка:</label>
                            <input type=text name="href" class="form-control boxed" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn-primary btn" type="submit">Добавить</button>
                </div>
            </div>
        </form><?php
    } ?>
</article>