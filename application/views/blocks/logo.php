<div class="row">
    <div class="col-md-12">
        <div class="logo"><?php
        foreach($info as $k => $v)
        { ?>
            <img src="/public/logo/<?= $v->name; ?>"><?php
        } ?>
        </div>
    </div>
</div>