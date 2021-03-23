<template>
    <section id="vue-my-students" class="my-students admin-inner admin-panel-section calendar-active">
        <h2 class="main-title">Мои студенты</h2>

        <div class="my-students-header">
            <div class="wrap">
                <p>Имя</p>
                <div class="wrap">
                    <p>Статус</p>
                    <div class="question"></div>
                </div>
                <p>Контактные данные </p>
                <!--                                        <p>Всего уроков</p>-->
                <p>Действия</p>
            </div>
        </div>

        <div class="decor-line"></div>
        <div class="my-students-content">
            <div v-for="arr in array" class="student">
                <div class="wrap">
                    <div class="student__elem student__elem--name">
                        <div class="student-name-icon"></div>
                        <div class="student-name-name">{{arr.name}}</div>
                    </div>
                    <div class="student__elem student__elem--time">{{arr.date}} {{arr.time}}</div>
                    <div class="student__elem student__elem--contacts">
                        <div class="student-contacts-email"><span>email: </span>{{arr.email}}</div>
                        <div class="student-contacts-skype"><span>skype: </span>{{arr.skype}}</div>
                    </div>
                    <div class="student__elem student__elem--actions">
                        <div class="student-actions-invite">отправить приглашение на урок</div>
                        <div class="student-actions-message">написать сообщение</div>
                        <div class="student-actions-ban">заблокировать</div>
                    </div>
                </div>
                <div class="decor-line"></div>
            </div>
        </div>
    </section>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                array: [],
            }
        },
        mounted: function () {
            this.getAllUsersInfo();
        },
        methods: {
            getAllUsersInfo: function () {
                axios.post('/handle.php', JSON.stringify({'method': 'getAllUsersInfo'}))
                    .then((response) => {
                        console.log(response.data)
                        let data = response.data;
                        let array = this.array;
                        data.forEach(function (val, k) {
                            array.push(val);
                        })
                    });

            }
        },
    }
</script>

<style scoped>

</style>