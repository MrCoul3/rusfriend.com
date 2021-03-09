<?php
require("vendor/autoload.php");
?>
<?php session_start();?>
<p class="user-login__elem user-login__elem--user-name">
    <?=$_SESSION['username']?>
    <?=$_SESSION['email']?>
</p>
<span class="info"></span>
<div class="pay-btn">оплатить</div>
<style>
    .pay-btn {
        width: 200px;
        height: 45px;
        background: red;
        color: white;
        border-radius: 10px;
        font-family: "Exo 2", sans-serif;
        text-align: center;
        line-height: 43px;
        transition: ease 0.3s;
    }
    .pay-btn:active {
         transition: transform ease-in-out .05s;
         transform: scale3d(0.95, 0.95, 0.95);
     }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    let successPayment = false;
    let userNameFromDB;
    // получить данные из базы данных, сформировать цену,
    // оплатить, изменить payment с unpayed на payed
    axios.post('/handle.php', JSON.stringify({'method': 'getLessons'}))
        .then((response) => {
            // console.log(response.data);
            // получаем всю информацию о забронированных уроках по данному пользователю
            let dataFromDB = response.data;
            dataFromDB.forEach(function (val, k) {
                userNameFromDB = val[1];
                let unPayedLessons = val[5];
                // console.log(val);
                if (userNameFromDB === getCookie('name')) {
                    if (unPayedLessons === 'unpayed') {
                        let info = document.createElement('span');
                        info.innerHTML = val[2] + ' ' + val[3] + "<br>";
                        document.body.prepend(info);
                    }
                }
            })
            // при клике на кнопку оплатить происходит оплата, если она успешна
            // То меняется successPayment На true

        });

    $('.pay-btn').click(function () {
        successPayment = true;
        // если все успешно, то статус 'payment' менятся на 'payed'
        // и редирект в
        if (successPayment === true) {
            axios.post('/handle.php', JSON.stringify({'method': 'successPay'}));
            // Редирект в 'ваши занятия'
        } else {
            console.log("оплата не произведена");
        }
    });


    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
</script>


<!--<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>