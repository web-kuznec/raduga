<div class="row"><?php
    foreach($info as $k => $v)
    { ?>
        <div class="col-md-6">
            <div class="banners">
                <a target="_blank" href="<?= $v->href; ?>">
                    <img src="/public/banners/<?= $v->id; ?>/<?= $v->img; ?>">
                </a>
            </div>
        </div><?php
    } ?>
</div>