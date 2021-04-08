<section class="login-form authorization-forms">
    <div class="form-frame">
        <div class="container">
            <h3 switch-lang="<?=switchLang()?>" switchable-text="Вход" class="form-title">Login</h3>
            <div class="logo-mobile-ver"></div>
            <div class="form-close-btn form-close-btn--login-form"></div>
            <!--img(src="../images/icons/close-btn.svg", alt="close").form-close-btn.form-close-btn--login-form-->
        </div>
        <!--img(src="../images/icons/form-decor-line.svg", alt="line").decor-line.decor-line--login-form-->
        <div class="decor-line decor-line--login-form"></div>
        <form class="form login-form">
            <input switch-lang="<?=switchLang()?>" switchable-text="почта" class="form__elem form-input form-input--email" type="email" placeholder="email" id="email">
            <div switch-lang="<?=switchLang()?>" switchable-text="формат: name@email.com" class="login-check login-check-email login-check--disable">format: name@email.com</div>
            <label class="label-email" for="email"></label>
            <input switch-lang="<?=switchLang()?>" switchable-text="пароль" class="form__elem form-input form-input--password" type="password" placeholder="password" id="password">
            <div switch-lang="<?=switchLang()?>" switchable-text="поле обязательно для заполнения" class="login-check login-check-password login-check--disable">this field is required</div>
            <label class="label-password" for="password"></label>
            <div class="login-invalid login-invalid--disable">
                <p switch-lang="<?=switchLang()?>" switchable-text="неверные почта или пароль">invalid email or password</p>
            </div>
            <p switch-lang="<?=switchLang()?>" switchable-text="У вас нет аккаунта? Регистрация" class="reg-log-changer form__elem">You don't have an account? Registration</p>
            <div class="decor-line decor-line--login-form"></div>
            <input switch-lang="<?=switchLang()?>" switchable-text="войти" class="form__elem form-submit form-submit-login button" submit="true" type="submit" value="login">
        </form>
    </div>
</section>