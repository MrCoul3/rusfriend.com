<template>
    <div>
        <div v-show="preloader" id="preloader"></div>
        <section id="my-calendar" class="my-calendar admin-inner admin-panel-section calendar-active">
            <h2 class="main-title">Календарь занятий</h2>
            <h3 class="main-title main-title__description">Здесь ты можешь посмотреть информацию о забронированных
                занятиях,
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
                            <div v-show="freeLesson" class="tegs__element">
                                <div class="circle circle--free"></div>
                                <span>Пробный урок</span>
                            </div>
                        </div>
                        <div class="month-module header-content__element">
                            <p class="month">{{monthes[month]}} {{year}}</p>
                            <div v-on:click="decrease" class="month-btn month-btn--left-btn"></div>
                            <div v-on:click="increase" class="month-btn month-btn--right-btn"></div>
                        </div>
                        <select class="time-zone header-content__element">
                            <option class="time-zone-option" v-for="gmt in timeZones" :value="gmt">{{gmt}}</option>
                        </select>
                    </div>
                </div>


                <table class="calendar-table admin-inner">
                    <tr>
                        <th v-for="d in day">{{d}}</th>
                    </tr>

                    <tr v-for="week in calendar()">

                        <td class="calendar-table-days" v-on:click='bookingEvent($event)' v-for="day in week"
                            :style="{'background-color': day.current}"
                            :date="day.index + '.' + currentMonth + '.' + year">
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
                        <div @click="openBook()" class="button change-btn">изменить урок</div>
                        <div @click="cancelLessonFrame()" class="button cancel-btn">отменить урок</div>
                    </div>
                </div>

                <div v-show="cancelLessShow" class="cancel-lesson-frame">
                    <div @click="closeCancelLessonFrame" class="close-btn"></div>
                    <div class="title">Вы уверены, что хотите отменить урок?</div>
                    <div class="decor-line"></div>
                    <div class="wrap">
                        <div @click="deleteBook()" class="button submit-btn">да</div>
                        <div @click="closeCancelLessonFrame()" class="button cancel-btn">отмена</div>
                    </div>
                </div>


                <AdminBookCalendar
                        v-show="showBookCalendar"
                        :user-name="detailUserName"
                        @delete-book="deleteBook"
                        :type-of-lesson="typeOfLesson"
                        @close="closeAdminCalendar"
                        @update="updateBook"
                />

            </div>

        </section>
    </div>
</template>

<script>
    import AdminBookCalendar from "./AdminBookCalendar.vue";
    import axios from 'axios';

    export default {
        components: {
           AdminBookCalendar
        },

        data() {
            return {
                month: new Date().getMonth(),
                year: new Date().getFullYear(),
                dFirstMonth: '1',
                timeZones: ['GMT -12:00', 'GMT -11:00', 'GMT -10:00', 'GMT -09:00', 'GMT -08:00', 'GMT -07:00', 'GMT -06:00', 'GMT -05:00', 'GMT -04:00', 'GMT -03:00', 'GMT -02:00', 'GMT -01:00', 'GMT +00:00', 'GMT +01:00', 'GMT +02:00', 'GMT +03:00', 'GMT +04:00', 'GMT +05:00', 'GMT +06:00', 'GMT +07:00', 'GMT +08:00', 'GMT +09:00', 'GMT +10:00', 'GMT +11:00', 'GMT +12:00'],
                timeZone: 'GMT +03:00',
                day: ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"],
                daySun: ["воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота"],
                monthes: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "October", "November", "December"],
                date: new Date(),
                timeChangeSatus: 'calendar-disable',
                currentMonth: null,
                dayOfWeek: null,
                detailShow: false,
                detailDate: null,
                detailTime: null,
                detailType: null,
                typeOfLesson: null,
                detailUserName: null,
                detailSkype: null,
                preloader: true,
                cancelLessShow: false,
                showBookCalendar: false,
                freeLesson: false,
            }
        },
        mounted: function () {
            this.getBooksTimeFromDB();
            this.setTimeZone();

        },
        beforeUpdate() {
        },
        updated() {
            // console.log('updated');
            this.setCurrentMonth();
            // this.getBooksTimeFromDB();
        },
        created: function () {
            // console.log(this.currentDayOfWeek);
            this.setCurrentMonth();
        },
        methods: {
            // установка текущего часового пояса
            setTimeZone() {
                let zone = new Date().toString().split(' ')[5];
                let gmt = 'GMT ' + zone.substring(3, 6) + ':00';
                this.timeZone = gmt; // GMT +03:00

                $('.time-zone-option').each(function (val, k) {
                    if ($(this).val() === gmt) {
                        $(this).attr('selected', true)
                    }
                });
            },

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
                // console.log('getintervals')
                // очищает ячейки при обновлении компонента
                $('.calendar-table-days .book').remove();
                axios.post('/handle.php', JSON.stringify({'method': 'getBooksTime'}))
                    .then((response) => {
                        // console.log(response.data);
                        let data = response.data;
                        // console.log(data)
                        let freeLesson = null;
                        if (data !== null) {
                            data.forEach(function (val, k) {
                                let typeFromDb = val.type;
                                let nameFromDb = val.name;
                                let dateFromDb = val.day;
                                let timeFromDb = val.time;
                                let paymentFromDb = val.payment;
                                if (typeFromDb === 'free') {
                                    freeLesson = true;
                                }
                                $('.calendar-table-days').each(function (k, val) {
                                    let day = $(this);
                                    let dateOfcell = $(this).attr('date');

                                    if (dateOfcell === dateFromDb) {
                                        // не добавлять интервалы если уже существуют
                                        if (paymentFromDb === 'payed' || paymentFromDb === 'free') {
                                            $(this).children().each(function (k, val) {
                                                // console.log(val);
                                                let valName = val.getAttribute('name');
                                                let valType = val.getAttribute('type');
                                                let valTime = val.getAttribute('time');
                                                let valDate = val.getAttribute('data');
                                                if (typeFromDb !== valType && nameFromDb !== valName && dateFromDb !== valDate && timeFromDb !== valTime) {
                                                    day.append("<span type='" + typeFromDb + "' name='" + nameFromDb + "' time='" + timeFromDb + "' data=" + dateOfcell + " class='book " + typeFromDb + "'>" + timeFromDb + ' ' + nameFromDb + "</span>")
                                                }
                                            });
                                        }
                                    }
                                })

                            });
                        }
                        // console.log(freeLesson)
                        this.freeLesson = freeLesson;
                        this.preloader = false;
                    });
            },
            bookingEvent(event) {
                // console.log(event.target);

                if (event.target.className.includes('book')) {
                    // console.log('work')
                    //open detail
                    this.detailShow = true;
                    let target = event.target;
                    this.detailDate = target.getAttribute('data');
                    this.detailTime = target.getAttribute('time');
                    this.typeOfLesson = target.getAttribute('type');
                    if (target.getAttribute('type') === 'private') {
                        this.detailType = 'Занятие с преподавателем';
                    }
                    if (target.getAttribute('type') === 's-club') {
                        this.detailType = 'Speaking - Club';
                    }
                    if (target.getAttribute('type') === 'free') {
                        this.detailType = 'Пробный урок';
                    }
                    this.detailUserName = target.getAttribute('name');
                    axios.post('/handle.php', JSON.stringify({name: this.detailUserName, 'method': 'getUserSkype'}))
                        .then((response) => {
                            // console.log(response.data)
                            let data = response.data;
                            this.detailSkype = data['skype'];
                            // console.log(data['skype']);
                        });
                }
            },
            // отмена занятия
            cancelLessonFrame() {
                this.detailShow = false;
                this.cancelLessShow = true;
            },
            closeCancelLessonFrame() {
                this.detailShow = true;
                this.cancelLessShow = false;
            },

            // удалить занятие из БД
            deleteBook() {
                // console.log(this.detailUserName);
                // console.log(this.detailDate);
                // console.log(this.detailTime);
                let input = {
                    name: this.detailUserName,
                    day: this.detailDate,
                    time: this.detailTime,
                    'method': 'delBooksTime'
                };
                console.log(input);
                axios.post('/handle.php', JSON.stringify(input))
                this.cancelLessShow = false;
                this.preloader = true;
                this.getBooksTimeFromDB();
            },
            // "изменить урок"
            openBook() {
                this.showBookCalendar = true;
                this.detailShow = false;
                // удалить текущий интервал методом deleteBook()
            },

            // "отмена" Закрыть календарь изменения урока
            closeAdminCalendar(data) {
                this.showBookCalendar = false;
                this.detailShow = true;
            },

            // 'при клике по "изменить время урока" удалить изменяемый интервал '
            updateBook(data) {
                this.deleteBook()
                window.location.reload();
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
</style>