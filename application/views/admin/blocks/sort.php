<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title">
            Сортировка <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div><?php
    foreach($info as $k => $v)
    { ?>
        <form name="item" enctype="multipart/form-data" method="POST">
            <div class="card card-block">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label text-xs-right"><?= $v->name; ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type=text name="sort" class="form-control boxed" value="<?= $v->sort; ?>" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= $v->id; ?>">
                            <button class="btn-primary btn" type="submit">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </form><?php
    } ?>
</article>