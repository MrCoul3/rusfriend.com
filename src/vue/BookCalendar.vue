<template>
    <div>
        <div v-show="preloader" id="preloader"></div>
        <section id="booking-calendar" class="your-calendar inner">
            <h3 :language="language"
                switchable-text="Забронируй <span>бесплатный</span> получасовой урок с преподавателем прямо сейчас"
                v-if="freeLesson"
                class="description your-calendar__element your-calendar__element--main-title main-title">
                Book a<span> free </span> half-hour lesson with a teacher right now
            </h3>
            <h3 :language="language" switchable-text="Все онлайн - занятия с
            преподавателем проходят в Skype"
                class="your-calendar__element your-calendar__element--main-title main-title">All online classes with
                the teacher takes place in Skype</h3>
            <div v-if="instruction" class="your-calendar__element your-calendar__element--instruction instruction">
                <p :language="language" switchable-text="1. Выберите удобное для вас время"
                   class="instruction__element">1. Choose a convenient time for you</p>
                <p class="instruction__element instruction__element--separator">></p>
                <p :language="language" switchable-text="2. Оплатите урок" class="instruction__element">2. Pay for the
                    lesson</p>
                <p class="instruction__element instruction__element--separator">></p>
                <p :language="language" switchable-text="3. Готовьтесь к уроку" class="instruction__element">3. Prepare
                    for the lesson</p>
            </div>
            <div class="your-calendar__element your-calendar__element--calendar-app calendar-app">
                <div class="calendar-app-header">
                    <div class="calendar-app-header__element calendar-app-header__element--month-module">
                        <div @click="decrease()" class="month-btn month-btn--left-btn"></div>
                        <div @click="increase()" class="month-btn month-btn--right-btn"></div>
                        <p class="month">{{monthes[numberMonthOfFirstDayOfWeek]}} {{dateInterval}}, {{year}}</p>
                    </div>
                    <div class="trigger" @click="switchMonthAndDay()" style="display: none"></div>
                    <h2 :language="language" switchable-text="Календарь занятий"
                        class="calendar-app-header__element calendar-app-header__element--title">Lesson calendar</h2>
                    <select  @click="switchTimeZone($event)"
                            class="calendar-app-header__element calendar-app-header__element--time-zone">
<!--                        <option selected :value="timeZone">{{timeZone}}</option>-->
                        <option  class="time-zone-option" v-for="gmt in timeZones" :value="gmt">{{gmt}}</option>
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
                <div style="position: relative;">
                    <div :language="language" switchable-text="нужно выбрать время урока" class="prompt">you need to
                        choose the time of the lesson
                    </div>
                    <a :language="language" switchable-text="забронировать" @click.prevent="bookEvent($event)" href=""
                       class="button book-btn">book</a>
                </div>

                <div class="tegs">
                    <div class="tegs__element">
                        <div class="circle circle--booked"></div>
                        <span :language="language" switchable-text="Забронированное занятие">Booked lesson</span>
                    </div>
                    <div class="tegs__element">
                        <div class="circle circle--available"></div>
                        <span :language="language" switchable-text="Доступное время">Available time</span>
                    </div>
                    <div class="tegs__element">
                        <div class="circle circle--unavailable"></div>
                        <span :language="language" switchable-text="Недоступное время">Unavailable time</span>
                    </div>
                </div>
                <div v-show="enterSkype" class="enter-your-skype">
                    <h2 :language="language" switchable-text="Все занятия проходят в skype"
                        class="enter-your-skype__element">All lessons are held on skype</h2>
                    <h3 :language="language"
                        switchable-text="Для продолжения введите <br> свой скайп и нажмите отправить"
                        class="enter-your-skype__element">
                        To continue, enter <br> your skype and click send
                    </h3>
                    <div class="flex">
                        <div class="skype-icon-for-input"></div>
                        <div id="enter-your-skype" class="flex">
                            <input class="enter-your-skype__element input-skype" type="text" placeholder="skype">
                            <div :language="language" switchable-text="отправить" @click="sendSkype()"
                                 class="button send-skype">send
                            </div>
                        </div>
                        <div :language="language" switchable-text="поле не должно быть пустым" v-show="validationSkype"
                             class="validation-skype">the field must not be empty
                        </div>
                    </div>
                    <h3 :language="language" switchable-text="Скайп преподавателя: <span>svetlana tutorOnline</span>"
                        class="enter-your-skype__element">Tutor Skype: <span>svetlana TutorOnline</span></h3>
                </div>
                <div v-show="freeLessBookSuccess" class="free-lesson-success">
                    <h2 :language="language" switchable-text="Вы успешно забронировали урок"
                        class="free-lesson-success__elem">You have successfully booked a lesson</h2>
                    <h3 :language="language" switchable-text="Не забудте придти вовремя"
                        class="free-lesson-success__elem">Do not forget to come on time</h3>
                    <h3 :language="language" switchable-text="Если остались вопросы напишите <span>сообщение</span>
                        преподавателю" class="free-lesson-success__elem">If you still have questions, write a <span>message</span>
                        to the teacher</h3>
                    <div @click="closeFreeLessSuccess()" class="button ok-btn">ok</div>
                    <h3 :language="language" switchable-text="Скайп преподавателя: <span>svetlana tutorOnline</span>"
                        class="free-lesson-success__elem">Tutor Skype: <span>svetlana TutorOnline</span></h3>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    let language = null;
    // let selectedTimeArray = []; // пришлось ввести, так как из 'data' вылезает [_ob_serever]
    export default {
        data() {
            return {
                month: new Date().getMonth(),
                numberMonthOfFirstDayOfWeek: null,
                year: new Date().getFullYear(),
                dFirstMonth: '1',
                timeZones: ['GMT -12:00', 'GMT -11:00', 'GMT -10:00', 'GMT -09:00', 'GMT -08:00', 'GMT -07:00', 'GMT -06:00', 'GMT -05:00', 'GMT -04:00', 'GMT -03:00', 'GMT -02:00', 'GMT -01:00', 'GMT +00:00', 'GMT +01:00', 'GMT +02:00', 'GMT +03:00', 'GMT +04:00', 'GMT +05:00', 'GMT +06:00', 'GMT +07:00', 'GMT +08:00', 'GMT +09:00', 'GMT +10:00', 'GMT +11:00', 'GMT +12:00'],
                timeZone: 'GMT +03:00',
                dayEng: ["MOТ", "TUE", "WED", "THU", "FRI", "SAT", "SUN"],
                dayRus: ["ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС"],
                day: ["MOТ", "TUE", "WED", "THU", "FRI", "SAT", "SUN"],
                monthesEng: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthesRus: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
                monthes: [],
                date: new Date(),
                weekNumber: null,
                currentWeek: null,
                selectedTimeArray: [],
                dateInterval: null,
                responseData: [],
                currentMonth: null,
                enterSkype: false,
                validationSkype: false,
                freeLesson: false,
                instruction: true,
                payment: 'unpayed',
                freeLessBookSuccess: false,
                preloader: true,
                language: 'eng-lang',
            }
        },

        beforeMount: function () {
            // возвращает номер недели
            Date.prototype.getWeek = function () {
                let oneJan = new Date(this.getFullYear(), 0, 1)
                let weekNum = (((this - oneJan) / 86400000) + oneJan.getDay() - 1) / 7
                // console.log(weekNum);
                return Math.ceil((((this - oneJan) / 86400000) + oneJan.getDay() - 1) / 7);
            }
            this.weekNumber = ((new Date()).getWeek() - 1);
            this.currentWeek = ((new Date()).getWeek() - 1);
            // console.log(this.weekNumber);
        },
        created: function () {
            this.setCurrentMonth();
        },
        mounted: function () {
            this.adjustmentDateOfDay();
            this.adjustmentDateOfWeek();
            this.isFreeLesson()
            this.getIntervalsFromDB();
            this.lightingOfToday();
            this.changeStateOfItem();
            this.switchLangOnReload();
            this.switchLang();
            this.setTimeZone();

        },
        updated() {
            this.adjustmentDateOfDay();
            this.adjustmentDateOfWeek();
            this.lightingOfToday();
            this.changeStateOfItem();
            this.setCurrentMonth();
        },
        computed: {},
        methods: {
            //------ смена часовых поясов
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
            // изменение интервалов при переключении часового пояса
            switchTimeZone(event) {
                // console.log(event.target);
                let select = event.target;
                this.timeZone =  event.target.value;
                select.addEventListener('change', ()=>{
                    this.getIntervalsFromDB();
                    this.changeStateOfItem();
                })
            },

            // ---- для смены языка
            switchMonthAndDay() {
                this.monthes = [];
                if (language === 'eng-lang') {
                    this.monthes = this.monthesEng;
                    this.day = this.dayEng;
                }
                if (language === 'rus-lang') {
                    this.monthes = this.monthesRus;
                    this.day = this.dayRus;
                }
            }
            ,
            switchLang() {
                $('.lang-changer').click(function (e) {
                    if ($(this).hasClass('eng-lang')) {
                        language = 'rus-lang';
                    } else {
                        language = 'eng-lang';
                    }
                    $('.trigger').trigger('click');

                    $('*').each(function (k, val) {
                        if ($(this).attr('language')) {
                            $(this).css('opacity', '0');
                            $(this).attr('language', getCookie('btnLang'));

                            if ($(this).attr('language') === 'rus-lang') {
                                $(this).attr('eng-text', $(this).html());
                                $(this).html($(this).attr('switchable-text')).animate({'opacity': 1}, 400);
                                $(this).attr('switchable-text', $(this).attr('eng-text'));
                                $(this).removeAttr('eng-text');
                            }

                            if ($(this).attr('language') === 'eng-lang') {
                                $(this).attr('rus-text', $(this).html());
                                $(this).html($(this).attr('switchable-text')).animate({'opacity': 1}, 400);
                                $(this).attr('switchable-text', $(this).attr('rus-text'));
                                $(this).removeAttr('rus-text');
                            }
                        }
                    });
                });

            }
            ,
            switchLangOnReload() {
                window.addEventListener("load", function (e) {
                    $('*').each(function (k, val) {
                        if ($(this).attr('language') === 'rus-lang') {
                            $(this).attr('eng-text', $(this).html());
                            $(this).html($(this).attr('switchable-text')).animate({'opacity': 1}, 400);
                            $(this).attr('switchable-text', $(this).attr('eng-text'));
                            $(this).removeAttr('eng-text');
                        }
                        if ($(this).attr('language') === 'eng-lang') {
                            $(this).animate({'opacity': 1}, 400);
                        }
                    });

                })
                if (getCookie('btnLang') === 'rus-lang') {
                    this.monthes = this.monthesRus;
                    this.day = this.dayRus;
                } else {
                    this.monthes = this.monthesEng;
                    this.day = this.dayEng;
                }
            }
            ,

            // ----- Для страницы "free-lesson.php"
            isFreeLesson() {
                if ($("main").hasClass('free-lesson')) {
                    this.instruction = false;
                    this.freeLesson = true;
                    this.payment = 'free';
                }

            }
            ,
            closeFreeLessSuccess() {
                this.freeLessBookSuccess = false;
                window.location.href = '/student-lessons.php';
            }
            ,
            // -----------------------------------
            setCurrentMonth() {
                if ((String(this.numberMonthOfFirstDayOfWeek + 1).length) === 1) {
                    this.currentMonth = 0 + String(this.numberMonthOfFirstDayOfWeek + 1);
                } else {
                    this.currentMonth = this.numberMonthOfFirstDayOfWeek + 1;
                }
            }
            ,
            //методы корректировки дат недели
            adjustmentDateOfDay() {
                let firstElem = $('.calendar-app-content-number:first-child');
                // console.log(firstElem);
                let numberFirstElem = firstElem.attr('date').split('.')[0];
                let monthFirstElem = firstElem.attr('date').split('.')[1];
                // console.log(numberFirstElem);
                // console.log(monthFirstElem);
                // в феврале 2025 года будет ошибка потому что февраль начнется с 24 числа
                if (numberFirstElem > 24 && numberFirstElem < 32) {
                    // console.log(numberFirstElem);
                    $('.calendar-app-content-number').each(function (k, val) {
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
            }
            ,
            adjustmentDateOfWeek() {
                // console.log('adjustmentDateOfWeek');
                let firstElem = $('.time-intrevals-elem:first-child');
                let numberFirstElem = firstElem.attr('date').split('.')[0];
                let monthFirstElem = firstElem.attr('date').split('.')[1];
                // console.log(numberFirstElem);
                // console.log(monthFirstElem);
                // в феврале 2025 года будет ошибка потому что февраль начнется с 24 числа
                if (numberFirstElem > 24 && numberFirstElem < 32) {
                    // console.log(numberFirstElem);
                    $('.time-intrevals-elem').each(function (k, val) {
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
            }
            ,

            DateOfMondayInWeek(year, weekNumber) {
                for (var a = 1; ; a++) if ((new Date(year, 0, a)).getDay() == 1) break;
                a += (weekNumber - 1) * 7;
                // console.log(new Date(year, 0, a).getMonth())
                this.numberMonthOfFirstDayOfWeek = new Date(year, 0, a).getMonth()
                return (new Date(year, 0, a))
            },
            weekCalendar: function () {
                let numOfDayInMonth = new Date(this.year, this.numberMonthOfFirstDayOfWeek + 1, 0).getDate(); // число дней в текущем мес
                let week = [];
                let w = 0;
                week[w] = [];
                // console.log(this.weekNumber)
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
                    if (a.index === new Date().getDate() && this.year === new Date().getFullYear() && this.weekNumber === this.currentWeek) {
                        // console.log(i);
                        a.today = 'today';
                        a.color = '#fff';
                        a.font = 'bold';
                        a.current = '#006660';
                    }
                    // console.log(i === new Date().getDate() )
                    // console.log(new Date().getDate());
                    // console.log(this.month);
                    // console.log(new Date().getMonth());
                }
                // console.log(week);
                // console.log(week[w][0].index + ' - ' + week[w][6].index);
                this.dateInterval = week[w][0].index + ' - ' + week[w][6].index;
                return week;
            }
            ,
            decrease: function () {
                // console.log('w');
                this.weekNumber--;
                this.numberMonthOfFirstDayOfWeek = this.DateOfMondayInWeek(this.year, this.weekNumber).getMonth();
                // console.log(this.month);
                // console.log(this.weekNumber);
                if (this.weekNumber === 0) {
                    this.weekNumber = 52
                    this.year--;
                }

                this.getIntervalsFromDB();
            }
            ,
            increase: function () {
                this.weekNumber++;
                this.numberMonthOfFirstDayOfWeek = this.DateOfMondayInWeek(this.year, this.weekNumber).getMonth();
                // console.log(this.month);
                // console.log(this.weekNumber);
                if (this.weekNumber === 52) {
                    this.weekNumber = 1;
                    this.year++;
                }
                this.getIntervalsFromDB();

            }
            ,

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
            }
            ,

            getIntervalsFromDB: function () {
                let freeLesson = this.freeLesson;
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
                        dataFromDB.forEach((dataFromDB, k) =>{
                            let gmtFromDb = dataFromDB.gmt;
                            let timeZoneNum = this.timeZone.split(' ')[1].substring(0, 3);
                            let gmtFromDbNum = gmtFromDb.split(' ')[1].substring(0, 3);
                            let delta = timeZoneNum - gmtFromDbNum;
                            // console.log(dataFromDB.day); // ...7.03.2021...
                            $('.time-intrevals-elem ').each((k, val) => {
                                // console.log(val.getAttribute('date'));
                                let dateNumber = val;
                                if (dataFromDB.day === dateNumber.getAttribute('date')) {
                                    // console.log(dateNumber.previousElementSibling)

                                    let arr = dataFromDB.time.split(',');
                                    let newArr = [];
                                    if (freeLesson) {
                                        // console.log(arr); // ["06:00 - 06:30",...
                                            arr.forEach((val, k) => {
                                                if (this.timeZone === gmtFromDb) {
                                                    newArr.push(val.split('-')[0]);
                                                } else {
                                                    let firstH = val.split('-')[0].split(':')[0];// 06
                                                    let firstM = val.split('-')[0].split(':')[1];// 00
                                                    let a = +firstH + delta; // 02
                                                    if (String(a).length < 2) {
                                                        a = '0' + a;
                                                    }
                                                    let newTimeInterval = a + ':' + firstM;
                                                    newArr.push(newTimeInterval);
                                                }
                                                // console.log(val.split('-')[0]);
                                            })
                                        // console.log(newArr);
                                        let str = newArr.join('</div><div>');
                                        // console.log(str);
                                        // console.log(dateNumber.innerHTML);
                                        dateNumber.innerHTML = '<div>' + str + '</div>';

                                    } else {
                                        // console.log(dataFromDB.time);
                                        // console.log(arr);
                                        let str;
                                        if (this.timeZone === gmtFromDb) {
                                            str = arr.join('</div><div>');
                                            dateNumber.innerHTML = '<div>' + str + '</div>';

                                        } else {
                                            arr.forEach((val, k)=> {
                                                let firstH = val.split('-')[0].split(':')[0];// 06
                                                let firstM = val.split('-')[0].split(':')[1];// 00
                                                let secondH = val.split('-')[1].split(':')[0]; // 07
                                                let secondM = val.split('-')[1].split(':')[1]; // 30
                                                let a = +firstH + delta; // 02
                                                let b = +secondH + delta; //05

                                                if (String(a).length < 2) {
                                                    a = '0' + a;
                                                }
                                                if (String(b).length < 2) {
                                                    b = '0' + b;
                                                }
                                                let newTimeInterval = a + ':' + firstM + ' - ' + b + ':' + secondM;
                                                // console.log(newTimeInterval);
                                                newArr.push(newTimeInterval);
                                                str = newArr.join('</div><div>');
                                                dateNumber.innerHTML = '<div>' + str + '</div>';

                                            });
                                        }
                                        // console.log(str);
                                        // console.log(dateNumber.innerHTML);
                                    }
                                }
                            });

                        })
                        this.preloader = false;
                    });
            }
            ,
            chooseTime: function (event) {
                // ---- Для free-lesson возможность выбрать только одно занятие
                if (this.freeLesson) {
                    $('.selected-time').removeClass('selected-time');
                }

                let selectedTime = event.target;
                if (!selectedTime.className.includes('time-intrevals-from-db__item')) {
                    // console.log(event.target);
                    if (selectedTime.className.includes('selected-time')) {
                        selectedTime.classList.remove('selected-time');
                    } else {
                        selectedTime.classList.add('selected-time');
                    }
                }

                this.selectedTimeArray = [];
                // console.log(selectedTimeArray)
                // let userName = $('.user-login__elem--user-name').html();
                let userName = getCookie('name');
                let typeOfLesson;

                if ($('.header-menu--private').hasClass('menu-item-active')) {
                    typeOfLesson = 'private';
                } else if (this.freeLesson) {
                    typeOfLesson = 'free';
                } else {
                    typeOfLesson = 's-club';
                }
                document.cookie = "type=" + typeOfLesson;
                let payment = this.payment;
                $('.selected-time').each((k, val) => {
                    let day = val.parentNode.getAttribute('date');
                    let time = val.innerHTML;
                    // console.log(val.parentNode.getAttribute('date') + val.innerHTML);
                    let obj = {
                        name: userName,
                        type: typeOfLesson,
                        day: day,
                        time: time,
                        payment: payment,
                        gmt: this.timeZone,
                        'method': 'bookEvent'
                    };
                    // console.log(obj)
                    if (day !== null && time !== '') {
                        this.selectedTimeArray.push(obj);
                    }
                });
                console.log(this.selectedTimeArray);
                // this.selectedTimeArray = array.slice(0);
            }
            ,
            bookEvent: function (event) {
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
                                        // $("#mysite").addClass("body-fixed");
                                    } else {
                                        if (this.selectedTimeArray.length !== 0) {
                                            axios.post('/handle.php', JSON.stringify(this.selectedTimeArray))
                                            // ---- для бесплатного занятия
                                            if (this.freeLesson) {
                                                axios.post('/handle.php', JSON.stringify({'method': 'changeSatusOnActive'}));
                                                this.freeLessBookSuccess = true;
                                                // $("#mysite").addClass("body-fixed");
                                            } else {
                                                // --- для платного - страница оплаты
                                                window.location.href = "/payment.php";
                                            }
                                        // если не выбраны интервалы вслпывающая подсказка
                                        } else {
                                            // $(event.target).prev(".prompt").fadeTo("slow", 1);
                                            $(event.target).prev(".prompt").css('visibility', 'visible');
                                            // setTimeout(function () {
                                            //     $(event.target).prev(".prompt").fadeOut();
                                            // },1000)
                                            setTimeout(function () {
                                                $(event.target).prev(".prompt").css('visibility', 'hidden');
                                            }, 1000)
                                        }

                                    }
                                });
                        }
                    })

            }
            ,

            sendSkype: function () {
                // console.log($('.input-skype').val());
                let skype = $('.input-skype');
                if (skype.val().trim() === '') {
                    // console.log('empty');
                    this.validationSkype = true;
                } else {
                    axios.post('/handle.php', JSON.stringify({'method': 'sendSkype', 'skype': skype.val()}))
                    this.enterSkype = false;
                    // $("#mysite").removeClass("body-fixed");
                }
            }
            ,
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
                            if (userNameFromDB === getCookie('name') && (paymentFromDB === 'payed' || paymentFromDB === 'free')) {
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
                                            // для бесплатного занятия интервалы не отображаются
                                            if (val.innerHTML.split('-')[0] === timeFromDB) {
                                                val.classList.add('booked-free');
                                            }
                                            // если время интервала меньше текущего - недоступно
                                            if (+val.innerHTML.split('-')[0].split(':')[0] <= new Date().getHours()) {
                                                val.classList.add('booked-for-other-users');
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
                                            // для бесплатного занятия интервалы не отображаются
                                            if (val.innerHTML.split('-')[0] === timeFromDB) {
                                                val.classList.add('booked-free');
                                            }
                                            // если время интервала меньше текущего - недоступно
                                            if (+val.innerHTML.split('-')[0].split(':')[0] <= new Date().getHours()) {
                                                val.classList.add('booked-for-other-users');
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
                                    if (day < data.getDate() && month <= data.getMonth() + 1 || month < data.getMonth() + 1) {
                                        // console.log($(this).children());
                                        $(this).children().each(function (k, val) {
                                            val.classList.add('booked-for-other-users');
                                        })
                                    }
                                });
                            }
                        })
                    });
            }
            ,
        }
        ,
    }
</script>

<style scoped>
    .prompt {
        position: absolute;
        /*opacity: 0;*/
        visibility: hidden;
        font-size: 14px;
        width: 211px;
        color: #FF3E28;
        font-style: italic;
        text-align: center;
        bottom: 50px;
        left: 0;
        right: 0;
        margin: auto;
    }

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

    *[language] {
        opacity: 0;
    }

    .free-lesson-success__elem > span {
        text-decoration: underline;
        cursor: pointer;
        color: #F8D6B0
    }
</style>