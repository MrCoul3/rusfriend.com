<section class="settings">
    <div class="settings-main-frame">
        <div class="settings-main-frame__elem settings-main-frame__elem--header">
            <div class="move-icon"></div>
            <h3 switch-lang="<?=switchLang()?>" switchable-text="Настройки" class="settings-title">Settings</h3>
            <div class="close-btn close-btn--settings"></div>
        </div>
        <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
        <div class="settings-main-frame__elem settings-main-frame__elem--content">
            <div class="setting-content-elem setting-content-elem--name">
                <div class="wrap">
                    <div class="flex">
                        <p switch-lang="<?=switchLang()?>" switchable-text="имя пользователя" class="placeholder">user name</p>
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" class="change-btn change-btn--input">change</div>
                    </div>
                    <div class="main-text main-text--user-name"><?= $_SESSION['name'] ?></div>
                </div>
                <div class="input-wrap">
                    <div class="flex">
                        <div class="check"></div>
                        <input switch-lang="<?=switchLang()?>" switchable-text="введите новое имя" class="input input--name" type="text" placeholder="enter a new name">
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" data-type='name' class="button change-button">change</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--password">
                <div class="wrap wrap--pass">
                    <div class="flex">
                        <p switch-lang="<?=switchLang()?>" switchable-text="пароль" class="placeholder">password</p>
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" class="change-btn change-btn--input">change</div>
                    </div>
                    <div class="main-text main-text--password">**********</div>
                </div>
                <div class="input-wrap input-wrap--pass">
                    <div switch-lang="<?=switchLang()?>" switchable-text="неверный пароль" class="check check--old-pass">invalid password</div>
                    <input switch-lang="<?=switchLang()?>" switchable-text="введите старый пароль" class="input input--old-pas input--password" type="password" placeholder="enter your old password">
                    <input switch-lang="<?=switchLang()?>" switchable-text="введите новый пароль" class="input input--new-pas input--password" type="password" placeholder="enter your new password">
                    <div class="flex">
                        <div class="check"></div>
                        <input switch-lang="<?=switchLang()?>" switchable-text="повторите новый пароль" class="input input--repeat-new-pas input--password" type="password" placeholder="repeat the new password">
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" data-type="password" class="button change-button change-button--password">change</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--email">
                <div class="wrap wrap--email">
                    <div class="flex">
                        <p switch-lang="<?=switchLang()?>" switchable-text="почта" class="placeholder">email</p>
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" class="change-btn change-btn--input">change</div>
                    </div>
                    <div class="main-text main-text--email"><?= $_SESSION['email'] ?></div>
                </div>
                <div class="input-wrap input-wrap--email">
                    <div class="flex">
                        <div class="check check--email"></div>
                        <input switch-lang="<?=switchLang()?>" switchable-text="введите новую почту" class="input input--email" type="text" placeholder="enter your new email address">
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" data-type='email' class="button change-button change-button--email">change</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--skype">
                <div class="wrap">
                    <div class="flex">
                        <p switch-lang="<?=switchLang()?>" switchable-text="скайп" class="placeholder">skype</p>
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" class="change-btn change-btn--input">change</div>
                    </div>
                    <div class="main-text main-text--skype"><?= $res['skype'] ?></div>
                </div>
                <div class="input-wrap">
                    <div class="flex">
                        <div class="check"></div>
                        <input switch-lang="<?=switchLang()?>" switchable-text="введите скайп" class="input input--skype" type="text" placeholder="enter skype">
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" data-type='skype' class="button change-button">change</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--avatar">
                <div class="flex">
                    <p switch-lang="<?=switchLang()?>" switchable-text="фото профиля" class="placeholder">profile photo</p>
                    <div class="perscab-photoedit-body">
                        <a switch-lang="<?=switchLang()?>" switchable-text="изменить" href="#" class="add-photo download-avatar-btn">change</a>
                        <input style="display:none;" id="c_input24" name="file" multiple="false" type="file">
                        <input style="display:none;" name="photo_c" multiple="false" type="hidden" value="">
                        <input style="display:none;" name="photo_i" value="" multiple="false" type="hidden">
                    </div>
                </div>
                <div class="perscab-photoedit-img">
                    <img src="#" alt="">
                </div>
                <div style="display:none">
                    <div class="profile-modal-photo box-modal">
                        <div class="box-modal_close arcticmodal-close"></div>
                        <div>
                            <img class="profile_photo_i" src="">
                        </div>
                        <div class="modal-footer center-wrap">
                            <button switch-lang="<?=switchLang()?>" switchable-text="сохранить" class="button reg-btn reg-btn_empty reg-btn_empty-wht reg-btn_blk-hover js-main-image">
                                save
                            </button>
                        </div>
                    </div>
                </div>
                <div class="avatar"></div>
            </div>
        </div>
    </div>
</section>
