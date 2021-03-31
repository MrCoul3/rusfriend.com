<template>
    <section id="booking-calendar" class="your-calendar inner">
        <div v-show="preLoader">Загрузка</div>
        <h3 class="your-calendar__element your-calendar__element--main-title main-title">Все online-Занятия с
            преподавателем проходят в Skype</h3>
        <div class="your-calendar__element your-calendar__element--instruction instruction">
            <p class="instruction__element">1. Выберите удобное для вас время</p>
            <p class="instruction__element instruction__element--separator">></p>
            <p class="instruction__element">2. Оплатите урок</p>
            <p class="instruction__element instruction__element--separator">></p>
            <p class="instruction__element">3. Готовьтесь к уроку</p>
        </div>
        <div class="your-calendar__element your-calendar__element--calendar-app calendar-app">
            <div class="calendar-app-header">
                <div class="calendar-app-header__element calendar-app-header__element--month-module">
                    <div @click="decrease()" class="month-btn month-btn--left-btn"></div>
                    <div @click="increase()" class="month-btn month-btn--right-btn"></div>
                    <p class="month">{{monthes[month]}} {{dateInterval}}, {{year}}</p>
                </div>
                <h2 class="calendar-app-header__element calendar-app-header__element--title">Календарь занятий</h2>
                <select class="calendar-app-header__element calendar-app-header__element--time-zone">
                    <option>Europe/Moscow GMT +3:00</option>
                </select>
            </div>
            <div class="decor-line"></div>
            <div class="calendar-app-content">

                <div class="decor-dates">
                    <div class="decor-dates__elem"></div>
                    <div class="decor-dates__elem"></div>
                    <div class="decor-dates__elem"></div>
                    <div class="decor-dates__elem"></div>
                    <div class="decor-dates__elem"></div>
                    <div class="decor-dates__elem"></div>
                    <div class="decor-dates__elem"></div>
                </div>
                <div class="calendar-app-content-col">
                    <div v-for="d in day" class="calendar-app-content-day">{{d}}</div>
                </div>

                <div v-for="week in weekCalendar()" class="calendar-app-content-col">
                    <div v-for="day in week" :today="day.today"
                         :style="{'background-color': day.current, 'color': day.color, 'font-weight': day.font}"
                         class="calendar-app-content-number" :date="day.index + '.' + currentMonth + '.' + year">
                        {{day.index}}
                    </div>
                </div>

                <div v-for="week in weekCalendar()" class="time-intrevals-from-db">
                    <div @click="chooseTime($event)" v-for="day in week"
                         :date="day.index + '.' + currentMonth + '.' + year"
                         class="time-intrevals-elem time-intrevals-from-db__item"></div>
                </div>

            </div>
            <a @click.prevent="bookEvent()" href="" class="button book-btn">забронировать</a>

            <div class="tegs">
                <div class="tegs__element">
                    <div class="circle circle--booked"></div>
                    <span>Забронированное занятие</span>
                </div>
                <div class="tegs__element">
                    <div class="circle circle--available"></div>
                    <span>Доступное время</span>
                </div>
                <div class="tegs__element">
                    <div class="circle circle--unavailable"></div>
                    <span>Недоступное время</span>
                </div>
            </div>
            <div v-show="enterSkype" class="enter-your-skype">
                <h2 class="enter-your-skype__element">Все занятия проходят в skype</h2>
                <h3 class="enter-your-skype__element">Для продолжения введите номер <br> своего skype и нажмите ‘далее’
                </h3>
                <div class="flex">
                    <div class="skype-icon-for-input"></div>
                    <div id="enter-your-skype" class="flex">
                        <input class="enter-your-skype__element input-skype" type="text" placeholder="skype">
                        <div @click="sendSkype()" class="button send-skype">send</div>
                    </div>
                    <div v-show="validationSkype" class="validation-skype">поле не должно быть пустым</div>
                </div>
                <h3 class="enter-your-skype__element">Skype преподавателя: <span>svetlana tutorOnline</span></h3>
            </div>
        </div>
    </section>
</template>

<script>
    import axios from 'axios';
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    let selectedTimeArray = []; // пришлось ввести, так как из 'data' вылезает [_ob_serever]
    export default {
        data() {
            return {
                month: new Date().getMonth(),
                year: new Date().getFullYear(),
                dFirstMonth: '1',
                timeZones: [],
                day: ["ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС"],
                monthes: ["January", "Февраль", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                date: new Date(),
                weekNumber: null,
                dateInterval: null,
                responseData: [],
                currentMonth: null,
                enterSkype: false,
                validationSkype: false,
                preLoader: false,
            }
        },

        beforeMount: function () {
            Date.prototype.getWeek = function () {
                var onejan = new Date(this.getFullYear(), 0, 1);
                return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()) / 7);
            } // возвращает номер недели
            this.weekNumber = ((new Date()).getWeek() - 1);
            // console.log(this.weekNumber);
        },
        created: function () {
            if ((String(this.month + 1).length) == '1') {
                this.currentMonth = 0 + String(this.month + 1);
            } else {
                this.currentMonth = this.month + 1;
            }
        },
        mounted: function () {
            this.adjustmentDateOfWeek();
            this.getIntervalsFromDB();
            this.lightingOfToday();
            this.changeStateOfItem();
        },
        updated () {
            this.adjustmentDateOfWeek();
            this.lightingOfToday();
            this.changeStateOfItem();
            if ((String(this.month + 1).length) == '1') {
                this.currentMonth = 0 + String(this.month + 1);
            } else {
                this.currentMonth = this.month + 1;
            }
        },
        methods: {
            //метод корректировки дат недели
            adjustmentDateOfWeek() {
                let firstElem = $('.time-intrevals-elem:first-child');
                let numberFirstElem = firstElem.attr('date').split('.')[0];
                let monthFirstElem = firstElem.attr('date').split('.')[1];
                // console.log(numberFirstElem);
                // console.log(monthFirstElem);
                // в феврале 2025 года будет ошибка потому что февраль начнется с 24 числа
                if (numberFirstElem > 24 && numberFirstElem < 32) {
                    // console.log(numberFirstElem);
                    $('.time-intrevals-elem').each(function (k,val) {
                        // console.log($(this).attr('date').split('.'));
                        let dateArr = $(this).attr('date').split('.')
                        if (dateArr[0] > 0 && dateArr[0] < 7) {
                            // console.log(dateArr[1])
                            dateArr[1] = String(+monthFirstElem + 1);
                            if (dateArr[1].length == '1') {
                                dateArr[1] = 0 + String(dateArr[1]);
                            }
                            // console.log(dateArr.join('.'));
                            let newDate = dateArr.join('.');
                            val.setAttribute('date', newDate);
                        }
                    })
                }
            },
            DateOfMondayInWeek(year, weekNumber) {
                for (var a = 1; ; a++) if ((new Date(year, 0, a)).getDay() == 1) break;
                a += (weekNumber - 1) * 7;
                return (new Date(year, 0, a))
            },
            weekCalendar: function () {
                let numOfDayInMonth = new Date(this.year, this.month + 1, 0).getDate(); // число дней в текущем мес
                let week = [];
                let w = 0;
                week[w] = [];
                let dayInCurrentWeek = this.DateOfMondayInWeek(this.year, this.weekNumber).getDate();
                for (let i = dayInCurrentWeek; i <= dayInCurrentWeek + 6; i++) {
                    let a = {index: i};
                    if (i <= numOfDayInMonth) {
                        week[w].push(a);
                    }
                    if (i > numOfDayInMonth) {
                        a = {index: i - numOfDayInMonth};
                        week[w].push(a);
                        // week[w].push(i - numOfDayInMonth);
                    }
                    if (i === new Date().getDate() && this.year === new Date().getFullYear() && this.month === new Date().getMonth()) {
                        a.today = 'today';
                        a.color = '#fff';
                        a.font = 'bold';
                        a.current = '#006660';
                    }
                }
                // console.log(week);
                // console.log(week[w][0].index + ' - ' + week[w][6].index);
                this.dateInterval = week[w][0].index + ' - ' + week[w][6].index;
                return week;
            },
            decrease: function () {
                console.log('w');
                this.weekNumber--;
                this.month = this.DateOfMondayInWeek(this.year, this.weekNumber).getMonth();
                // console.log(this.month);
                // console.log(this.weekNumber);

                if (this.weekNumber === 0) {
                    this.weekNumber = 52
                    this.year--;
                }

                this.getIntervalsFromDB();
            },
            increase: function () {
                this.weekNumber++;
                this.month = this.DateOfMondayInWeek(this.year, this.weekNumber).getMonth();
                // console.log(this.month);
                // console.log(this.weekNumber);
                if (this.weekNumber === 52) {
                    this.weekNumber = 1;
                    this.year++;
                }
                this.getIntervalsFromDB();

            },

            lightingOfToday: function () {
                let dayNum = document.querySelectorAll('.calendar-app-content-number');
                let dayName = $('.calendar-app-content-day');
                let decorElements = $('.decor-dates__elem');
                dayNum.forEach(function (val, k) {
                    if (val.getAttribute('today')) {
                        dayName[k].classList.add('day-of-week-active');
                        decorElements[k].classList.add('decor-element-active');
                    } else {
                        dayName[k].classList.remove('day-of-week-active');
                        decorElements[k].classList.remove('decor-element-active');
                    }
                })
            },

            getIntervalsFromDB: function () {
                // ----- удаление неоплаченых бронирований
                axios.post('/handle.php', JSON.stringify({'method': 'delUnpayedBooks'}))

                $('.time-intrevals-elem ').each((k, val) => {
                    val.innerHTML = '';
                });

                axios.post('/handle.php', JSON.stringify({'method': 'getTimeIntervals'}))
                    .then((response) => {
                        // console.log(response.data);
                        let dataFromDB = response.data;
                        // console.log(dataFromDB[0]);
                        dataFromDB.forEach(function (dataFromDB, k) {
                            // console.log(dataFromDB.day); // ...7.03.2021...
                            $('.time-intrevals-elem ').each((k, val) => {
                                // console.log(val.getAttribute('date'));
                                let dateNumber = val;
                                if (dataFromDB.day === dateNumber.getAttribute('date')) {
                                    // console.log(dataFromDB.time);
                                    let arr = dataFromDB.time.split(',');
                                    // console.log(arr);
                                    let str = arr.join('</div><div>');
                                    // console.log(str);
                                    // console.log(dateNumber.innerHTML);
                                    dateNumber.innerHTML = '<div>' + str + '</div>';
                                }
                            });

                        })
                    });
            },
            chooseTime: function (event) {


                let selectedTime = event.target;
                if (!selectedTime.className.includes('time-intrevals-from-db__item')) {
                    console.log(event.target);
                    if (selectedTime.className.includes('selected-time')) {
                        selectedTime.classList.remove('selected-time');
                    } else {
                        selectedTime.classList.add('selected-time');
                    }
                }


                selectedTimeArray = [];
                console.log(selectedTimeArray)
                // let userName = $('.user-login__elem--user-name').html();
                let userName = getCookie('name');
                let typeOfLesson;
                if ($('.header-menu--private').hasClass('menu-item-active')) {
                    typeOfLesson = 'private';
                } else {
                    typeOfLesson = 's-club';
                }
                document.cookie = "type=" + typeOfLesson;

                $('.selected-time').each(function (k, val) {
                    let day = val.parentNode.getAttribute('date');
                    let time = val.innerHTML;
                    // console.log(val.parentNode.getAttribute('date') + val.innerHTML);
                    let obj = {
                        name: userName,
                        type: typeOfLesson,
                        day: day,
                        time: time,
                        payment: 'unpayed',
                        'method': 'bookEvent'

                    };
                    console.log(obj)
                    if (day !== null && time !== '') {
                        selectedTimeArray.push(obj);
                    }
                });
                // console.log(array);
                // this.selectedTimeArray = array.slice(0);
            },
            bookEvent: function () {
                // console.log(selectedTimeArray);
                // нужно сделать проверку на логин, если не залогинен то открыть форму
                // Регистрации
                axios.post('/handle.php', JSON.stringify({'method': 'checkLoginOnBookedLesson'}))
                    .then((response) => {
                        // console.log(response.data['success']);
                        if (response.data['success'] === false) {
                            // открытие формы логина
                            if (!$(".login-form").hasClass('login-form-active')) {
                                $(".login-form").addClass('login-form-active');
                                $("#mysite").addClass("body-fixed");
                            }

                        } else {
                            //если ЛОГин то проверка наличия скайпа + отпарвка интервалов в бд
                            axios.post('/handle.php', JSON.stringify({'method': 'checkSkype'}))
                                .then((response) => {
                                    // console.log(response.data);
                                    let dataFromDB = response.data;
                                    if (dataFromDB.status === 'empty') {
                                        this.enterSkype = true;
                                    } else {

                                        axios.post('/handle.php', JSON.stringify(selectedTimeArray))
                                        window.location.href = "payment.php";
                                    }
                                });
                        }
                    })

            },

            sendSkype: function () {
                // console.log($('.input-skype').val());
                let skype = $('.input-skype');
                if (skype.val().trim() === '') {
                    // console.log('empty');
                    this.validationSkype = true;
                } else {
                    axios.post('/handle.php', JSON.stringify({'method': 'sendSkype', 'skype': skype.val()}))
                    this.enterSkype = false;
                }
            },
            // функция изменения состояния интервала в календаре при
            // забронированных интервалах для данного пользователя
            changeStateOfItem: function () {

                axios.post('/handle.php', JSON.stringify({'method': 'getLessons'}))
                    .then((response) => {
                        // console.log(response.data);
                        // получаем всю информацию о забронированных уроках по данному пользователю

                        let dataFromDB = response.data;
                        // console.log($(this).attr('date'));
                        let timeInterval = $('.time-intrevals-from-db__item');

                        dataFromDB.forEach(function (val, k) {
                            // console.log(val[5]);
                            let userNameFromDB = val[1];
                            let dayFromDB = val[2];
                            let timeFromDB = val[3];
                            let paymentFromDB = val[5];
                            if (userNameFromDB === getCookie('name') && paymentFromDB === 'payed') {
                                timeInterval.each(function (k, val) {
                                    if ($(this).attr('date') === dayFromDB) {
                                        // console.log(timeFromDB);
                                        // console.log($(this).children())
                                        $(this).children().each(function (k, val) {
                                            // console.log(val);
                                            if (val.innerHTML === timeFromDB) {
                                                val.classList.add('booked-for-this-user');
                                                // console.log(val);
                                            }
                                        })
                                    }
                                })
                            }



                            if (userNameFromDB !== getCookie('name')) {
                                // console.log(userNameFromDB);

                                timeInterval.each(function (k, val) {
                                    // console.log($(this).attr('date'))
                                    if ($(this).attr('date') === dayFromDB) {
                                        // console.log(timeFromDB);
                                        // console.log($(this).children())
                                        $(this).children().each(function (k, val) {
                                            // console.log(val);
                                            if ((val.innerHTML === timeFromDB)) {
                                                val.classList.add('booked-for-other-users');
                                                // console.log(val);
                                            }
                                        })
                                    }
                                })
                                //--------- функция деактивации интервалов раньше текущего дня
                                let data = new Date();
                                timeInterval.each(function (k, val) {
                                    let date = $(this).attr('date');
                                    let day = date.split('.')[0];
                                    let month = date.split('.')[1];
                                    // console.log(month)
                                    // console.log(data.getMonth())
                                    // console.log(month <= data.getMonth() +1 )
                                    if (day < data.getDate() && month <= data.getMonth() + 1 || month < data.getMonth()+1) {
                                        // console.log($(this).children());
                                        $(this).children().each(function (k, val) {
                                            val.classList.add('booked-for-other-users');
                                        })
                                    }
                                });
                            }
                        })
                    });
            },
        },
    }
</script>

<style scoped>

</style>