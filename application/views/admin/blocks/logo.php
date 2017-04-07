<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title">
            Логотип <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form name="item" method="POST" enctype="multipart/form-data">
        <div class="card card-block"><?php
            if($info->count() > 0)
            {
                foreach($info as $k => $v)
                { ?>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <img style="max-width:500px;" src="/public/logo/<?= $v->name; ?>">
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else { ?>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Логотипов нет</label>
                        </div>
                    </div>
                </div><?php
            } ?>
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-control-label text-xs-right">Загрузить новый логотип:</label>
                        <input type="file" name="image" class="form-control boxed" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="new">
                <button class="btn-primary btn" type="submit">Сохранить</button>
            </div>
        </div>
    </form>
</article>