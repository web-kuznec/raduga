<script src="<?= URL::base('http', TRUE); ?>public/js/bootstrap.min.js" type="text/javascript"></script>
<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title">
            Редактирование вещи <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form name="item" id="form_edit" method="POST">
        <div class="card card-block"><?php
            foreach($docs as $k => $v)
            { ?>
                <div class="form-group row">
                    <div id="abs_action">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button class="btn btn-secondary cancel" type="button">Отмена</button>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-control-label text-xs-right">Иконка:</label>
                            <input type="text" name="awesome" class="form-control boxed" value="<?= $v->awesome; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label text-xs-right">Текст:</label>
                            <input type="text" name="p" class="form-control boxed" value="<?= htmlspecialchars($v->text,ENT_QUOTES); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" value="<?= $v->id; ?>">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                            <button class="btn btn-secondary cancel" type="button">Отмена</button>
                        </div>
                    </div>
                </div><?php
            } ?>
        </div>
    </form>
</article>