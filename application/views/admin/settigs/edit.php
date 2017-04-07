<script src='/public/js/jscolor.min.js'></script>
<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title">
            Настройки <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form name="item" method="POST"><?php
        foreach($settings as $k => $v)
        { ?>
        <div class="card card-block">
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-control-label text-xs-right">Цвет фона:</label>
                        <input name="color" type="text" class="form-control jscolor" value="<?= $v->color; ?>">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-control-label text-xs-right">Количество загружаемых баннеров:</label>
                        <input name="count" type="text" class="form-control" value="<?= $v->count; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="hidden" name="id" value="<?= $v->id; ?>">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button class="btn btn-secondary cancel" type="button">Отмена</button>
                    </div>
                </div>
            </div>
        </div><?php
        } ?>
    </form>
</article>