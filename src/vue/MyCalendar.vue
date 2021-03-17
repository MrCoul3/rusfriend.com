<template>
    <div>
        <div v-show="preloader" id="preloader"></div>
        <section id="my-calendar" class="my-calendar admin-inner admin-panel-section calendar-active">
            <h2 class="main-title">Календарь занятий</h2>
            <h3 class="main-title main-title__description">Здесь ты можешь посмотреть информацию о забронированных занятиях,
                нажав на интересующую ячейку</h3>
            <div class="wrapper">
                <div class="calendar-header">
                    <div class="header-content">
                        <div class="tegs">
                            <div class="tegs__element">
                                <div class="circle circle--s-club"></div>
                                <span>Speaking - club</span>
                            </div>
                            <div class="tegs__element">
                                <div class="circle circle--private"></div>
                                <span>Занятие с преподавателем</span>
                            </div>
                        </div>
                        <div class="month-module header-content__element">
                            <p class="month">{{monthes[month]}} {{year}}</p>
                            <div v-on:click="decrease" class="month-btn month-btn--left-btn"></div>
                            <div v-on:click="increase" class="month-btn month-btn--right-btn"></div>
                        </div>
                        <select class="time-zone header-content__element">
                            <option>Europe/Moscow GMT +3:00</option>
                        </select>
                    </div>
                </div>


                <table class="calendar-table admin-inner">
                    <tr>
                        <th v-for="d in day">{{d}}</th>
                    </tr>

                    <tr v-for="week in calendar()">

                        <td class="calendar-table-days" v-on:click='bookingEvent($event)' v-for="day in week"
                            :style="{'background-color': day.current}" :date="day.index + '.' + currentMonth + '.' + year">
                            <span class="day-number">{{ day.index }}</span></td>

                    </tr>
                </table>

                <div v-show="detailShow" class="calendar-detail">
                    <div @click="detailShow = false" class="close-btn"></div>
                    <div class="date">{{detailDate}}</div>
                    <div class="time">{{detailTime}}</div>
                    <div class="type">{{detailType}}</div>
                    <div class="decor-line"></div>

                    <div class="wrap user-wrap">
                        <div class="wrap user">
                            <div class="user-icon"></div>
                            <div class="user-name">{{detailUserName}}</div>
                        </div>
                        <div class="wrap message">
                            <div class="message-title">сообщение</div>
                            <div class="message-icon"></div>
                        </div>
                    </div>
                    <div class="wrap skype">
                        <div class="skype-icon"></div>
                        <div class="skype-name">{{detailSkype}}</div>
                    </div>
                    <div class="decor-line"></div>
                    <div class="wrap">
                        <div class="button change-btn">изменить</div>
                        <div class="button cancel-btn">отменить</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                month: new Date().getMonth(),
                year: new Date().getFullYear(),
                dFirstMonth: '1',
                timeZones: [],
                day: ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"],
                daySun: ["воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота"],
                monthes: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "October", "November", "December"],
                date: new Date(),
                timeChangeSatus: 'calendar-disable',
                currentMonth: null,
                showPreloader: true,
                dayOfWeek: null,
                detailShow: false,
                detailDate: null,
                detailTime: null,
                detailType: null,
                detailUserName: null,
                detailSkype: null,
                preloader: true,
            }
        },
        mounted: function () {
            this.getBooksTimeFromDB();
        },
        updated() {
            this.setCurrentMonth();
        },
        created: function () {
            // console.log(this.currentDayOfWeek);
            this.showPreloader = false;
            this.setCurrentMonth();

        },
        methods: {
            calendar: function () {
                var days = [];
                var week = 0;
                let a;
                days[week] = [];
                var dlast = new Date(this.year, this.month + 1, 0).getDate(); // 28 число дней  в месяце
                for (let i = 1; i <= dlast; i++) {
                    if (new Date(this.year, this.month, i).getDay() != this.dFirstMonth) {
                        a = {index: i};
                        days[week].push(a);
                        if (i == new Date().getDate() && this.year == new Date().getFullYear() && this.month == new Date().getMonth()) {
                            a.current = '#F6FFFF';
                        }
                    } else {
                        week++;
                        days[week] = [];
                        a = {index: i};
                        days[week].push(a);
                        if ((i == new Date().getDate()) && (this.year == new Date().getFullYear()) && (this.month == new Date().getMonth())) {
                            a.current = '#F6FFFF'
                        }
                    }
                }
                if (days[0].length > 0) {
                    for (let i = days[0].length; i < 7; i++) {
                        days[0].unshift('');
                    }
                }
                return days;
            },
            decrease: function () {
                this.month--;
                if (this.month < 0) {
                    this.month = 12;
                    this.month--;
                    this.year--;
                }
                this.getBooksTimeFromDB();
            },
            increase: function () {
                this.month++;
                if (this.month > 11) {
                    this.month = -1;
                    this.month++;
                    this.year++;
                }
                this.getBooksTimeFromDB();

            },
            setCurrentMonth() {
                if ((String(this.month + 1).length) == '1') {
                    this.currentMonth = 0 + String(this.month + 1);
                } else {
                    this.currentMonth = this.month + 1;
                }
            },
            getBooksTimeFromDB() {
                // this.preloader = true;
                this.preloader = false;
                // console.log('getintervals')
                // очищает ячейки при обновлении компонента
                $('.calendar-table-days .book').remove();
                axios.post('/handle.php', JSON.stringify({'method': 'getBooksTime'}))
                    .then((response) => {
                        this.preloader = false;
                        // console.log(response.data);
                        let data = response.data;
                        data.forEach(function (val, k) {
                            let typeFromDb = val.type;
                            let nameFromDb = val.name;
                            let dateFromDb = val.day;
                            let timeFromDb = val.time;
                            let paymentFromDb = val.payment;
                            $('.calendar-table-days').each(function (k, val) {
                                let day = $(this);
                                let dateOfcell = $(this).attr('date');
                                if (dateOfcell === dateFromDb) {
                                    if (paymentFromDb === 'payed') {
                                        day.append("<span type='" + typeFromDb + "' name='" + nameFromDb + "' time='" + timeFromDb + "' data=" + dateOfcell + " class='book " + typeFromDb + "'>" + timeFromDb + ' ' + nameFromDb + "</span>")
                                    }
                                }
                            })

                        });
                    });
            },
            bookingEvent(event) {
                console.log(event.target);

                if (event.target.className.includes('book')) {
                    console.log('work')
                    //open detail
                    this.detailShow = true;
                    let target = event.target;
                    this.detailDate = target.getAttribute('data');
                    this.detailTime = target.getAttribute('time');
                    this.detailType = target.getAttribute('type');
                    if (target.getAttribute('type') === 'private') {
                        this.detailType = 'Занятие с преподавателем';
                    }
                    if (target.getAttribute('type') === 's-club') {
                        this.detailType = 'Speaking - Club';
                    }
                    this.detailUserName = target.getAttribute('name');
                    axios.post('/handle.php', JSON.stringify({name: this.detailUserName, 'method': 'getUserSkype'}))
                        .then((response) => {
                            console.log(response.data)
                            let data = response.data;
                            this.detailSkype = data['skype'];
                            console.log(data['skype']);
                        });
                }
            },

        },
    }
</script>

<style scoped>
    #preloader {
        /*visibility: hidden;*/
        /*opacity: 0;*/
        position: fixed;
        left: 0;
        top: 0;
        z-index: 999;
        width: 100%;
        height: 100%;
        overflow: visible;
        background: #fbfbfb url('../images/common/preloader_1.gif') no-repeat center center;
    }

    /*.visible {*/
    /*    visibility: visible!important;*/
    /*    opacity: 1!important;*/
    /*}*/
</style>