<script src="<?= URL::base('http', TRUE); ?>public/js/bootstrap.min.js" type="text/javascript"></script>
<article class="content dashboard-page">
<div class="col-md-12">
    <div class="card">
        <div class="card-block">
            <div class="card-title-block">
                <h3 class="title">Противопоказания</h3>
            </div>
            <section class="example">
                <table class="table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Иконка</th>
                            <th>Текст</th>
                            <th><a title="Добавить" href="/admin/slides/addstop/"><em class="fa fa-plus-circle"></em></a> </th>
                        </tr>
                    </thead>
                    <tbody><?php
                    foreach($docs as $k => $v)
                    { ?>
                        <tr>
                            <td><?= $v->id; ?></td>
                            <td><i class="fa <?= $v->awesome; ?>"></i></td>
                            <td><?= $v->text; ?></td>
                            <td>
                                <a title="Редактировать" href="/admin/slides/editstop/<?= $v->id; ?>"><em class="fa fa-cogs"></em></a> 
                                &nbsp;&nbsp;<a title="Удалить" href="/admin/slides/dellstop/<?= $v->id; ?>"><em class="fa fa-times-circle"></em></a>
                            </td>
                        </tr><?php
                    } ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</article>