<div class="contpad">
    <div id="window_auth">
        <form id="reset">
            <div class="labeled"><label for="username">Новый пароль:</label></div>
            <div class="inpt_auth">
                <input id="pass" class="inptext" type="password" name="pass" autofocus />
            </div>
            <div class="clear"></div>
            <div class="labeled"><label for="password">Повторите пароль:</label></div>
            <div class="inpt_auth">
                <input id="pass_confirm" class="inptext" type="password" name="pass_confirm" />
            </div>
            <div class="clear"></div>
            <input type="hidden" name="user" value="<?= $user; ?>">
            <div class="fright"><button class="button" type="submit">Сменить пароль</button></div>
            <div class="clear"></div>
        </form>
        <div class="otst"></div>
        <div class="fleft">
            <a id="ah_auth">Авторизация</a>
        </div>
        <div class="fright">
            <a id="ah_reg">Регистрация</a>
        </div>
        <div class="clear"></div>
    </div>
</div>