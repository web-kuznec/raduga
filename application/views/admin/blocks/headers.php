<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title">
            Заголовок <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form name="item" method="POST">
        <div class="card card-block">
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-control-label text-xs-right">Заголовок:</label>
                        <input type=text name="name" class="form-control boxed" value="<?= htmlspecialchars($headers); ?>" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <button class="btn-primary btn" type="submit">Сохранить</button>
            </div>
        </div>
    </form>
</article>