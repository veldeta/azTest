<form id='reg-form' action="<?= $_SERVER['REQUEST_URI']?>" method="post">
    <div class="form">
        <input type="hidden" value="<?= $_SESSION['__cfds']?>">
        <div class="flex flex-column">
            <label>Логин</label>
            <input type="text" name="login" required>
        </div>
        <div class="flex flex-column">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="flex flex-column">
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>
        <div class="flex flex-column">
            <label>Подтверждения пароля</label>
            <input type="password" name="pass_repeat" required>
        </div>
        <input class="btn-success" type="submit" value="Зарегистрироваться">
    </div>
</form>