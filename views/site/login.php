<form action="<?= $_SERVER['REQUEST_URI']?>" method="post">
    <div class="form">
        <input type="hidden" name="__cfds" value="<?= $_SESSION['__cfds']?>">
        <div class="flex flex-column">
            <label>Введите логин или e-mail почту</label>
            <input type="text" name='E-login' required>
        </div>
        <div class="flex flex-column">
            <label>Укажите пароль</label>
            <input type="password" name='password' required>
        </div>
        <input class='btn-sky' type="submit" value="Войти">
        <p>Если у вас еще нет аккаунта, то вы можете <a href="/site/reg">зарегистрироваться</a></p>
    </div>
</form>