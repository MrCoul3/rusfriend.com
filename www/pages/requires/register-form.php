<section class="register-form authorization-forms">
    <div class="form-frame">
        <div class="container">
            <h3 switch-lang="<?=switchLang()?>" switchable-text="Регистрация" class="form-title">Registration</h3>
            <div class="logo-mobile-ver"></div>
            <div class="form-close-btn form-close-btn--register-form"></div>
            <!--img(src="../images/icons/close-btn.svg", alt="close").form-close-btn.form-close-btn--register-form-->
        </div>
        <div class="decor-line decor-line--login-form"></div>
        <form class="form" method="post">
            <input switch-lang="<?=switchLang()?>" switchable-text="имя пользователя" class="form__elem form-input form-input--username required-input" type="text" placeholder="user name" id="username" name="username">
            <div class="reg-check reg-check-name reg-check--disable">поле обязательно для заполнения</div>
            <label for="username"></label>
            <input switch-lang="<?=switchLang()?>" switchable-text="пароль" class="form__elem form-input form-input--password required-input" type="password"
                   placeholder="password" id="reg-password" name="password">
            <div class="reg-check reg-check-pass reg-check--disable">поле обязательно для заполнения</div>
            <label class="label-password" for="password"></label>
            <input switch-lang="<?=switchLang()?>" switchable-text="повторите пароль" class="form__elem form-input form-input--re-password required-input" type="password"
                   placeholder="repeat the password" id="re-password">
            <label class="label-re-password" for="re-reg-password"></label>
            <div switch-lang="<?=switchLang()?>" switchable-text="пароли не совпадают" class="reg-check check-re-password reg-check--disable">passwords don't match</div>
            <input switch-lang="<?=switchLang()?>" switchable-text="почта" class="form__elem form-input form-input--email required-input" type="email" placeholder="email"
                   id="reg-email" name="email">
            <div switch-lang="<?=switchLang()?>" switchable-text="поле обязательно для заполнения" class="reg-check reg-check-email reg-check--disable">this field is required</div>
            <label class="label-email" for="email"></label>
            <input switch-lang="<?=switchLang()?>" switchable-text="скайп" class="form__elem form-input form-input--skype" type="text" placeholder="skype" id="skype"
                   name="skype">
            <label for="skype"></label>
            <p switch-lang="<?=switchLang()?>" switchable-text="Уже зарегестрированы? Войти" class="reg-log-changer form__elem">Already registered? Login</p>
            <div class="decor-line decor-line--login-form"></div>
            <input switch-lang="<?=switchLang()?>" switchable-text="зарегестрироваться" class="form__elem form-submit form-submit-register button" submit="true" type="submit" value="register now">
        </form>
    </div>
</section>