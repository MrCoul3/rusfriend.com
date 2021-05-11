<template>
  <div>
    <div v-show="preloader" id="preloader"></div>
    <section id="booking-calendar" class="your-calendar inner">
      <h3 :language="language"
          switchable-text="Забронируй <span>бесплатный</span> получасовой урок с преподавателем прямо сейчас"
          v-if="freeLesson"
          class="description your-calendar__element your-calendar__element--main-title main-title">
        Book a<span> free </span> 30-min lesson with a teacher right now
      </h3>
      <h3 :language="language" switchable-text="Все онлайн - занятия с
            преподавателем проходят в Skype"
          class="your-calendar__element your-calendar__element--main-title main-title">All online classes with
        the teacher takes place in Skype</h3>
      <div v-if="instruction" class="your-calendar__element your-calendar__element--instruction instruction">
        <p :language="language" switchable-text="1. Выберите удобное для вас время"
           class="instruction__element" style="color: #455A64">1. Choose a convenient time for you</p>
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
            <p class="month">{{ monthes[numberMonthOfFirstDayOfWeek] }} {{ dateInterval }}, {{ year }}</p>
          </div>
          <div class="trigger" @click="switchMonthAndDay()" style="display: none"></div>
          <h2 :language="language" switchable-text="Календарь занятий"
              class="calendar-app-header__element calendar-app-header__element--title">Lesson calendar</h2>


          <!--          <select  v-model="timeZone" @change="switchTimeZone()"-->
          <!--                  class="calendar-app-header__element calendar-app-header__element&#45;&#45;time-zone">-->
          <!--                                    <option selected :value="timeZone">{{timeZone}}</option>-->
          <!--            <option class="time-zone-option" v-for="gmt in timeZones" :value="gmt">{{ gmt }}</option>-->

          <!--          </select>-->
          <div class="flex-column">
            <div v-model="timeZone"
                 class="calendar-app-header__element calendar-app-header__element--time-zone">
              {{ timeZone }}
            </div>
            <p :language="language" switchable-text="твой часовой пояс" class="descr">your time zone</p>
          </div>

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
            <div v-for="d in day" class="calendar-app-content-day">{{ d }}</div>
          </div>

          <div v-for="week in weekCalendar()" class="calendar-app-content-col">
            <div v-for="day in week" :today="day.today"
                 :style="{'background-color': day.current, 'color': day.color, 'font-weight': day.font}"
                 class="calendar-app-content-number" :date="day.index + '.' + currentMonth + '.' + year">
              {{ day.index }}
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
            <span :language="language" switchable-text="Забронированное занятие">Booked</span>
          </div>
          <div class="tegs__element">
            <div class="circle circle--available"></div>
            <span :language="language" switchable-text="Доступное время">Available time</span>
          </div>
          <div class="tegs__element">
            <div class="circle circle--unconfirmed"></div>
            <span :language="language"
                  switchable-text="Неподтвержденное занятие">Unconfirmed by tutor</span>
          </div>
          <div class="tegs__element">
            <div class="circle circle--unpayed"></div>
            <span :language="language" switchable-text="Неоплаченное занятие">Unpaid</span>
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

    <section v-show="unconfirmMenuShow" class="unconfirmed-menu-wrap">
      <div class="unconfirmed-menu-frame">
        <div @click="closeUnconfirmedMenuFrame()" class="close-btn"></div>
        <p :language="language" switchable-text="Вы выбрали неоплаченный урок" class="title">You chose an unpaid
          lesson</p>
        <div class="decor-line"></div>
        <p :language="language" switchable-text="Что бы завершить бронирование, Вам <br>
                    необходимо оплатить урок в течение 15 минут" class="description">To complete the booking, you will
          <br>
          need to pay for the lesson within 15 minutes</p>
        <div class="decor-line"></div>
        <div class="flex">
          <div @click="payForALessonBtnClick()" :language="language" switchable-text="оплатить урок"
               class="button button--pay-btn">pay for a
            lesson
          </div>
          <div @click="deleteUnconfirmedLesson()" :language="language" switchable-text="отменить урок"
               class="button button--cancel-btn">cancel a
            lesson
          </div>
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

// let language = null;
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
      unconfirmTimeArray: [], // вспомогательный массив для удаления неподтвержденных интервалов
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
      language: getCookie('btnLang'),
      pricePrivate: null,
      priceSclub: null,
      price: null,
      typeOfLesson: 'private',
      isUnconfirmed: false, // есть ли неподтвержденные бронирования
      unconfirmMenuShow: false,
      lengthOfData: undefined,
      bookedGmtArray: [],
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
    this.switchLangOnReload();
    this.switchLang();
    this.setTimeZone();
    this.getPrice();
  },
  updated() {

    this.adjustmentDateOfDay();
    this.adjustmentDateOfWeek();
    this.lightingOfToday();
    // this.changeStateOfItem();
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

      // $('.time-zone-option').each(function (val, k) {
      //   if ($(this).val() === gmt) {
      //     $(this).attr('selected', true)
      //   }
      // });

    },

    // изменение интервалов при переключении часового пояса
    // switchTimeZone() {
    //   this.getIntervalsFromDB();
    //   // this.getFromTempGMT();
    // },

    // ---- для смены языка
    switchMonthAndDay() {
      this.monthes = [];
      if (this.language === 'eng-lang') {
        this.monthes = this.monthesEng;
        this.day = this.dayEng;
      }
      if (this.language === 'rus-lang') {
        this.monthes = this.monthesRus;
        this.day = this.dayRus;
      }
    }
    ,
    switchLang() {
      $('.lang-changer').click((e) => {
        if ($(e.target).hasClass('eng-lang')) {
          this.language = 'rus-lang';
        } else {
          this.language = 'eng-lang';
        }
        console.log(this.language)
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
    }
    ,
    // ---- получение цены на занятия из БД
    getPrice() {
      axios.post('/handle.php', JSON.stringify({'method': 'getPrice'}))
          .then((response) => {
            // console.log(response.data);
            if (response.data !== null) {
              this.pricePrivate = response.data.private;
              this.priceSclub = response.data.sclub;
              if ($('.header-menu--private').hasClass('menu-item-active')) {
                this.price = response.data.private;
              } else {
                this.price = response.data.sclub;
              }
            }

          });
    },
    // получение интервалов, обработка  в зависимости от часового пояса и занесение во временную базу данных tempGMT
    getIntervalsFromDB: function () {
      $('#booking-calendar').css('opacity', '0');
      this.preloader = true;
      let freeLesson = this.freeLesson;
      let obj = {};
      let obj2 = {};
      let obj3 = {};
      let array = [];
      let array2 = [];

      $('.time-intrevals-elem ').each((k, val) => {
        val.innerHTML = '';
      });

      axios.post('/handle.php', JSON.stringify({'method': 'getTimeIntervals'}))
          .then((response) => {
            // console.log(response.data);
            let data = response.data;
            // количество полученных интервалов
            let count = 0;
            if (data !== null) {
              data.forEach((val, k) => {
                let arr = val.time.split(',')
                count += arr.length;
              });
            }
            this.lengthOfData = count;
            // console.log(this.lengthOfData)

            let timeZone = this.timeZone;
            let timeZoneNum = this.timeZone.split(' ')[1].substring(0, 3);

            addToTempDB();

            this.getOfTempDB();

            setTimeout(() => {
              this.preloader = false;
              $('#booking-calendar').animate({
                'opacity': '1'
              }, 500)
            }, 500);

            // добавляет интервалы во временную БД
            function addToTempDB() {
              if (data !== null) {
                data.forEach((val, k) => {
                  // console.log(val);
                  let dayFromDb = val.day;
                  let timeFromDb = val.time;
                  let gmtFromDb = val.gmt;


                  // if (this.timeZone !== gmtFromDb) {

                  // ----- func changeIntevals
                  let gmtFromDbNum = gmtFromDb.split(' ')[1].substring(0, 3);
                  let delta = timeZoneNum - gmtFromDbNum;
                  // console.log(timeFromDb)

                  let arr = timeFromDb.split(',');

                  let newArr = [];
                  let newArr2 = [];
                  let newArr3 = [];

                  arr.forEach((val, k) => {

                    let prevNum = +dayFromDb.split('.')[0] - 1;
                    let prevMonth = +dayFromDb.split('.')[1];

                    let prevYear = +dayFromDb.split('.')[2];
                    if (prevNum == 0) {
                      prevMonth = prevMonth - 1;
                      prevNum = new Date(prevYear, prevMonth, 0).getDate();
                    }
                    if (String(prevMonth).length < 2) {
                      prevMonth = '0' + prevMonth;
                    }
                    let prevDateNumber = prevNum + '.' + prevMonth + '.' + prevYear;

                    let nextNum = +dayFromDb.split('.')[0] + 1;
                    let nextMonth = +dayFromDb.split('.')[1];
                    let nextYear = +dayFromDb.split('.')[2];
                    let lastNum = new Date(nextYear, nextMonth, 0).getDate();
                    // console.log(lastNum)
                    if (nextNum == lastNum + 1) {
                      nextNum = '1';
                      nextMonth = nextMonth + 1;
                    }
                    if (String(nextMonth).length < 2) {
                      nextMonth = '0' + nextMonth;
                    }
                    let nextDateNumber = nextNum + '.' + nextMonth + '.' + nextYear;

                    let firstH = val.split('-')[0].split(':')[0];// 06
                    let firstM = val.split('-')[0].split(':')[1];// 00
                    let secondH = val.split('-')[1].split(':')[0]; // 07
                    let secondM = val.split('-')[1].split(':')[1]; // 30
                    let a = +firstH + delta; // 02
                    let b = +secondH + delta; //05

                    let time = a + ':' + firstM + ' - ' + b + ':' + secondM;

                    if (a < 0) {
                      // console.log(prevDateNumber)
                      // console.log(time)
                      newArr.push(time);
                      // console.log(newArr.join(', '))
                      obj = {
                        day: prevDateNumber,
                        time: newArr.join(', '),
                        gmt: timeZone,
                      }
                    }

                    if (a >= 0 && a < 24) {
                      newArr2.push(time);
                      obj2 = {
                        day: dayFromDb,
                        time: newArr2.join(', '),
                        gmt: timeZone,
                      }
                    }

                    if (a > 23) {
                      newArr3.push(time);
                      obj3 = {
                        day: nextDateNumber,
                        time: newArr3.join(', '),
                        gmt: timeZone,
                      }
                    }


                  });

                  if (Object.keys(obj).length !== 0) {
                    array.push(obj);
                  }
                  if (Object.keys(obj2).length !== 0) {
                    array.push(obj2);
                  }
                  if (Object.keys(obj3).length !== 0) {
                    array.push(obj3);
                  }
                  array2 = [...new Set(array)];
                  // console.log(array2)
                  // console.log(obj)
                  // console.log(obj2)
                });
              }

              let object = {
                intervals: array2,
                'method': 'setToTempGMT'
              }
              // console.log(array2);
              axios.post('/handle.php', JSON.stringify(object))
            }
          });
    },
    // при переключении таймзоны получаем из temp-gmt БД интервалы, меняем отрицательные значения на
    // правильные ( -1:00 на 23:00)  и вставляем в календарь
    getOfTempDB() {
      setTimeout(() => {
        axios.post('/handle.php', JSON.stringify({'method': 'getFromTempGMT'}))
            .then((response) => {
              let data = response.data;
              // console.log(data)
              let unconfirmedBooks = [];

              let dataLength = 0;
              if (data !== null) {
                data.forEach((val, k) => {
                  let arr = val[1].split(',')
                  dataLength += arr.length;
                });
              }

              if (this.lengthOfData !== undefined) {
                if (this.lengthOfData === dataLength) {
                  if (data !== null) {
                    data.forEach((val, k) => {
                      // console.log(val);
                      let dayFromDb = val[0];
                      let timeFromDb = val[1];
                      let gmtFromDb = val[2];
                      let newArr = [];

                      let arr = timeFromDb.split(',');
                      // console.log(timeFromDb);
                      arr.forEach((val, k) => {
                        let firstH = val.split(' - ')[0].split(':')[0];// 06
                        let firstM = val.split(' - ')[0].split(':')[1];// 00
                        let secondH = val.split(' - ')[1].split(':')[0]; // 07
                        let secondM = val.split(' - ')[1].split(':')[1]; // 30
                        if (+firstH < 0) {
                          firstH = 24 + +firstH;
                        }
                        if (+secondH < 0) {
                          secondH = 24 + +secondH;
                        }
                        if (+firstH > 23) {
                          firstH = +firstH - 24;
                        }
                        if (+secondH > 23) {
                          secondH = +secondH - 24;
                        }
                        let time = firstH + ':' + firstM + ' - ' + secondH + ':' + secondM;
                        newArr.push(time);

                      });

                      $('.time-intrevals-elem').each((k, val) => {
                        let dateNumber = val;
                        let data = new Date();
                        let date = $(val).attr('date');
                        let day = date.split('.')[0];
                        let month = date.split('.')[1];
                        let str = '';
                        let valHour = '';

                        if (dayFromDb === dateNumber.getAttribute('date')) {

                          if (this.freeLesson) {
                            let arr = [];
                            newArr.forEach((val, k) => {
                              arr.push(val.split('-')[0]);
                            })
                            str = arr.join('</div><div>');
                          } else {
                            str = newArr.join('</div><div>');
                          }

                          $(dateNumber).append('<div>' + str + '</div>');

                          //--------- функция деактивации интервалов ранее текущего времени
                          $(val).children().each((k, val) => {
                            if (this.freeLesson) {
                              valHour = val.innerHTML.split(':')[0];
                            } else {
                              valHour = val.innerHTML.split('-')[0].split(':')[0];
                            }

                            if (day < data.getDate() && month <= data.getMonth() + 1 || month < data.getMonth() + 1) {
                              val.classList.add('booked-for-other-users');
                            }
                            if (+valHour - 1 < data.getHours() && day == data.getDate() && month <= data.getMonth() + 1 || month < data.getMonth() + 1) {
                              val.classList.add('booked-for-other-users');
                            }
                          })
                        }

                      });
                    });
                  }
                } else {
                  // если не совпадает выполняется getIntervalsFromDB заново
                  console.log('false')
                  this.getIntervalsFromDB();
                }
              }

              axios.post('/handle.php', JSON.stringify({'method': 'getLessons'}))
                  .then((response) => {
                    // получаем всю информацию о забронированных уроках по данному пользователю
                    let data = response.data;
                    // console.log(data)
                    let days = $('.time-intrevals-from-db__item');

                    this.bookedGmtArray = [];

                    if (data !== null) {
                      data.forEach((val, k) => {
                        let userNameFromDB = val[1];
                        let dayFromDB = val[2];
                        let timeFromDB = val[3];
                        let type = val[4];
                        let paymentFromDB = val[5];
                        let confirmationFromDB = val[6];
                        let priceFromDB = val[7];
                        let gmtFromDB = val[8];
                        let bookingTime = val[9];

                        let timeZoneNum = this.timeZone.split(' ')[1].substring(0, 3);
                        let gmtFromDbNum = gmtFromDB.split(' ')[1].substring(0, 3);
                        let delta = timeZoneNum - gmtFromDbNum;
                        let arr = timeFromDB.split(',');

                        arr.forEach((val, k) => {

                          // удаление неоплаченых интервалов из БД через 15 минут
                          if (confirmationFromDB == 0) {
                            let currentTime = new Date().getMinutes();
                            let delta = currentTime - bookingTime;
                            if (Math.sign(delta) == -1) {
                              delta += 60;
                            }
                            if (delta > 15) {
                              let obj = {
                                name: userNameFromDB,
                                time: val,
                                day: dayFromDB,
                                'type': 'delAfterTimeInterval',
                                'method': 'delUnconfirmedBooks'
                              }
                              unconfirmedBooks.push(obj);
                            }
                          }


                          let prevNum = +dayFromDB.split('.')[0] - 1;
                          let prevMonth = +dayFromDB.split('.')[1];

                          let prevYear = +dayFromDB.split('.')[2];
                          if (prevNum == 0) {
                            prevMonth = prevMonth - 1;
                            prevNum = new Date(prevYear, prevMonth, 0).getDate();
                          }
                          if (String(prevMonth).length < 2) {
                            prevMonth = '0' + prevMonth;
                          }
                          let prevDateNumber = prevNum + '.' + prevMonth + '.' + prevYear;


                          let nextNum = +dayFromDB.split('.')[0] + 1;
                          let nextMonth = +dayFromDB.split('.')[1];

                          let nextYear = +dayFromDB.split('.')[2];
                          let lastNum = new Date(nextYear, nextMonth, 0).getDate();
                          // console.log(lastNum)
                          if (nextNum == lastNum + 1) {
                            nextNum = '1';
                            nextMonth = nextMonth + 1;
                          }
                          if (String(nextMonth).length < 2) {
                            nextMonth = '0' + nextMonth;
                          }
                          let nextDateNumber = nextNum + '.' + nextMonth + '.' + nextYear;

                          let firstH;
                          let firstM;
                          let secondH;
                          let secondM;
                          let time;
                          let a;
                          let b;
                          let day = dayFromDB;
                          if (paymentFromDB !== 'free') {
                            firstH = val.split('-')[0].split(':')[0];// 06
                            firstM = val.split('-')[0].split(':')[1];// 00
                            secondH = val.split('-')[1].split(':')[0]; // 07
                            secondM = val.split('-')[1].split(':')[1]; // 30
                            a = +firstH + delta; // 02
                            b = +secondH + delta; //05
                            if (a < 0) {
                              a = 24 + a;
                              if (b < 0) {
                                b = 24 + b;
                              }
                              day = prevDateNumber;
                            }

                            if (a > 23) {
                              a = a - 24;
                              if (b > 23) {
                                b = b - 24;
                              }
                              day = nextDateNumber;
                            }
                            time = a + ':' + firstM + ' - ' + b + ':' + secondM;
                          } else {
                            firstH = val.split(':')[0];// 06
                            firstM = val.split(':')[1];// 00
                            a = +firstH + delta; // 02
                            time = a + ':' + firstM;
                          }

                          // console.log(time)

                          let obj = {
                            name: userNameFromDB,
                            type: type,
                            day: day,
                            time: time,
                            payment: paymentFromDB,
                            confirmation: confirmationFromDB,
                            price: priceFromDB,
                            gmt: this.timeZone,
                            'method': 'setToBooksTimeGMT'
                          };

                          // console.log(obj)
                          this.bookedGmtArray.push(obj);

                        });



                        let bookedGmtArray = this.bookedGmtArray;
                        $(bookedGmtArray).each((i, obj) => {
                          let dayFromBookedGmtArray = obj.day;
                          let confirmation = obj.confirmation;
                          let gmt = obj.gmt;
                          let name = obj.name;
                          let payment = obj.payment;
                          let price = obj.price;
                          let timeFromBookedGmtArray = obj.time;
                          let type = obj.type;

                          // стили
                          days.each((i, day) => {
                            if ($(day).attr('date') === dayFromBookedGmtArray) {
                              for (let time of day.children) {

                                if (time.innerHTML.split('-')[0].trim() === timeFromBookedGmtArray.split('-')[0].trim()) {

                                  if (name === getCookie('name')) {

                                    if (payment === "unpayed") {
                                      time.classList.add('unpayed-book');
                                    }
                                    if (confirmation === "0") {
                                      time.classList.add('unconfirmed-book');
                                    }
                                    if (confirmation === "1" && payment === 'payed') {
                                      time.classList.add('booked-for-this-user');
                                    }

                                  } else {

                                    if (confirmation === "1" || payment === 'payed' || payment === "unpayed" || confirmation === "0") {
                                      time.classList.add('booked-for-other-users');
                                    }

                                  }
                                }

                                if (time.innerHTML.split('-')[0] === timeFromBookedGmtArray) {
                                  time.classList.add('booked-free');
                                }

                              }
                            }
                          })
                        })
                      });
                    }

                    // console.log(unconfirmedBooks)

                    // удаление неоплаченных бронирований через 15 минут
                    axios.post('/handle.php', JSON.stringify(unconfirmedBooks))
                        .then((response) => {
                          let data = response.data;
                          if (data === true) {
                            // console.log(data)
                            this.getIntervalsFromDB();
                            }
                        });

                  });

            });
      }, 500)

    },
    // --- выбор интервалов с записью параметров в массив selectedTimeArray[]
    chooseTime: function (event) {
      // console.log('choose')
      // ---- Для free-lesson возможность выбрать только одно занятие
      if (this.freeLesson) {
        $('.selected-time').removeClass('selected-time');
      }

      let selectedTime = event.target;
      // console.log($(selectedTime));
      if (!selectedTime.className.includes('time-intrevals-from-db__item') && !$(selectedTime).hasClass('unpayed-book')) {
        // console.log(event.target);
        if (selectedTime.className.includes('selected-time')) {
          selectedTime.classList.remove('selected-time');
        } else {
          selectedTime.classList.add('selected-time');
        }
      }
      this.unconfirmTimeArray = [];
      this.selectedTimeArray = [];
      console.log(this.selectedTimeArray)
      // let userName = $('.user-login__elem--user-name').html();
      let userName = getCookie('name');
      let confirmation = 0;
      if ($('.header-menu--private').hasClass('menu-item-active')) {
        this.typeOfLesson = 'private';
      } else if (this.freeLesson) {
        this.typeOfLesson = 'free';
        confirmation = 1;
      } else {
        this.typeOfLesson = 's-club';
      }
      document.cookie = "type=" + this.typeOfLesson;

      $('.selected-time').each((k, val) => {
        let day = val.parentNode.getAttribute('date');
        let time = val.innerHTML;
        // console.log(val.parentNode.getAttribute('date') + val.innerHTML);
        let obj = {
          name: userName,
          type: this.typeOfLesson,
          day: day,
          time: time,
          payment: this.payment,
          confirmation: confirmation,
          price: this.price,
          gmt: this.timeZone,
          bookingTime: new Date().getMinutes(),
          'method': 'bookEvent'
        };

        this.selectedTimeArray.push(obj);
      });
      // console.log( this.selectedTimeArray)

      let day = event.target.parentNode.getAttribute('date');
      let time = event.target.innerHTML;
      let obj = {
        name: userName,
        type: this.typeOfLesson,
        day: day,
        time: time,
        payment: this.payment,
        confirmation: 0,
        price: this.price,
        gmt: this.timeZone,
        'method': 'delUnconfirmedBooks'
      };
      this.unconfirmTimeArray.push(obj);

      // console.log(this.unconfirmTimeArray);

      // ----- функция открытия unconfirmed-menu-frame при нажатии на красное бронирование
      // unconfirmed-book (неподтвержденное пользователем на странице payment.php)
      if ($(selectedTime).hasClass('unconfirmed-book')) {
        this.unconfirmMenuShow = true;
        $('.unconfirmed-menu-frame').animate({
          'opacity': '1',
          'left': '0'
        }, 100)
        $("#mysite").addClass("body-fixed");
      }

    },

    // ---- МЕНЮ НЕОПЛАЧЕННОГО ЗАНЯТИЯ
    // ----  закрыть меню неоплаченного занятия
    closeUnconfirmedMenuFrame() {
      $("#mysite").removeClass("body-fixed");
      $('.unconfirmed-menu-frame').animate({
        'opacity': '0',
        'left': '-2000px'
      }, 100)
      setTimeout(() => {
        this.unconfirmMenuShow = false;
      }, 100);
    },
    payForALessonBtnClick() {
      window.location.href = '/payment.php'
    },

    // ----- удаление неоплаченого бронирования
    deleteUnconfirmedLesson() {
      axios.post('/handle.php', JSON.stringify(this.unconfirmTimeArray))
          .then((response) => {
            console.log(response.data)
            if (response.data) {
              console.log('success delete unconfirm lesson')
              this.getIntervalsFromDB();
              this.closeUnconfirmedMenuFrame();
            }
          });
    },
    // ------------- click on button class="button book-btn" (забронировать -> страница оплаты)
    bookEvent: function (event) {
      // ------ проверка на логин, если не залогинен то открыть форму Регистрации
      axios.post('/handle.php', JSON.stringify({'method': 'checkLoginOnBookedLesson'}))
          .then((response) => {
            // console.log(response.data['success']);
            if (response.data['success'] === false) {
              // открытие формы логина
              if (!$(".login-form").hasClass('login-form-active')) {

                $(".login-form").addClass('login-form-active').animate({
                  'opacity': '1'
                }, 100);

                $(".form-frame").animate({
                  'left': '0px',
                }, 200);

                $(".register-form").animate({
                  'opacity': '1'
                }, 100);

                $("#mysite").addClass("body-fixed");
              }
            } else {
              // ------ если залогинен, то проверка наличия скайпа
              axios.post('/handle.php', JSON.stringify({'method': 'checkSkype'}))
                  .then((response) => {
                    // console.log(response.data);
                    let dataFromDB = response.data;
                    if (dataFromDB.status === 'empty') {
                      this.enterSkype = true; // включение формы отправки скайпа в БД
                      // $("#mysite").addClass("body-fixed");
                    } else {

                      console.log(this.selectedTimeArray)
                      if (this.selectedTimeArray.length !== 0) {
                        axios.post('/handle.php', JSON.stringify(this.selectedTimeArray))
                        // ---- для бесплатного занятия
                        if (this.freeLesson) {
                          axios.post('/handle.php', JSON.stringify({'method': 'changeSatusOnActive'}));
                          this.freeLessBookSuccess = true;


                          let mailForUser = {
                            name: getCookie('name'),
                            email: localStorage.getItem('email'),
                            data: this.selectedTimeArray,
                            'method': 'bookedFree'
                          }
                          let mailForAdmin = {
                            name: getCookie('name'),
                            email: localStorage.getItem('email'),
                            data: this.selectedTimeArray,
                            'method': 'bookedFreeByUser'
                          }

                          axios.post('/mailer.php', JSON.stringify(mailForUser))
                          axios.post('/mailer.php', JSON.stringify(mailForAdmin))


                          // $("#mysite").addClass("body-fixed");
                        } else {
                          // --- для платного - страница оплаты
                          setTimeout(() => {
                            window.location.href = "/payment.php";
                          }, 1000);
                        }
                        // если не выбраны интервалы вслпывающая подсказка
                      } else {
                        // если есть неоплаченные бронирования, выбранные ранее - переход на payment.php
                        if (this.isUnconfirmed) {
                          window.location.href = "/payment.php";
                        } else {
                          $(event.target).prev(".prompt").css('visibility', 'visible');
                          setTimeout(function () {
                            $(event.target).prev(".prompt").css('visibility', 'hidden');
                          }, 1000)
                        }

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


  },

}
</script>

<style scoped>
#booking-calendar {
  opacity: 0;
}

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



*[language] {
  opacity: 0;
}

.free-lesson-success__elem > span {
  text-decoration: underline;
  cursor: pointer;
  color: #F8D6B0
}
</style>