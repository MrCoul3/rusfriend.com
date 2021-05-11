<template>
  <div>
    <div v-show="showPreLoader" id="preloader"></div>
    <section id="admin-booking-calendar" class="your-calendar inner" :key="reload">
      <div class="your-calendar__element your-calendar__element--calendar-app calendar-app">
        <div class="calendar-app-header">
          <div class="calendar-app-header__element calendar-app-header__element--month-module">
            <div @click="decrease" class="month-btn month-btn--left-btn"></div>
            <div @click="increase" class="month-btn month-btn--right-btn"></div>
            <p class="month">{{ monthes[numberMonthOfFirstDayOfWeek] }} {{ dateInterval }}, {{ year }}</p>
          </div>
          <h2 class="calendar-app-header__element calendar-app-header__element--title">Изменить время
            урока</h2>
          <!--                    <select class="calendar-app-header__element calendar-app-header__element&#45;&#45;time-zone">-->
          <!--                        <option>Europe/Moscow GMT +3:00</option>-->
          <!--                    </select>-->
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
        <div class="wrap">
          <div class="prompt">нужно выбрать время урока</div>
          <div @click.prevent="bookEvent($event)" class="button book-btn">изменить время урока</div>
          <div @click="closeAdminBookCalendar()" class="button cancel-btn">отмена</div>
        </div>
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

// let selectedTimeArray = []; // пришлось ввести, так как из 'data' вылезает [_ob_serever]
export default {
  data() {
    return {
      reload: 0,
      month: new Date().getMonth(),
      numberMonthOfFirstDayOfWeek: null,
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
      showPreLoader: true,
      selectedTimeArray: [],
      bookedGmtArray: [],
    }
  },
  props: {
    userName: {
      required: true,
    },
    typeOfLesson: {
      required: true,
      default: 'private',
    },
    timeZone: {
      required: true,
      default: 'GMT +03:00',
    }

  },
  beforeMount: function () {
    Date.prototype.getWeek = function () {
      var onejan = new Date(this.getFullYear(), 0, 1);
      return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()) / 7);
    } // возвращает номер недели
    this.weekNumber = ((new Date()).getWeek() - 1);
    this.currentWeek = ((new Date()).getWeek() - 1);
    // console.log(this.weekNumber);
  },
  created: function () {
    this.setCurrentMonth();

  },
  mounted: function () {
    this.adjustmentDateOfWeek();
    this.getIntervalsFromDB();
    this.changeStateOfItem();
    this.lightingOfToday();
  },
  updated: function () {
    this.adjustmentDateOfWeek();
    this.lightingOfToday();
    this.getIntervalsFromDB();
    this.changeStateOfItem();
    this.setCurrentMonth();

  },
  methods: {
    // ---- ФУНКЦИОНАЛ ЛОГИКИ КАЛЕНДАРЯ ---- \\
    // установка тек месяца
    setCurrentMonth() {
      if ((String(this.numberMonthOfFirstDayOfWeek + 1).length) === 1) {
        this.currentMonth = 0 + String(this.numberMonthOfFirstDayOfWeek + 1);
      } else {
        this.currentMonth = this.numberMonthOfFirstDayOfWeek + 1;
      }
    },
    //метод корректировки дат недели
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
    },
    adjustmentDateOfWeek() {
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
    },
    // дата понедельника
    DateOfMondayInWeek(year, weekNumber) {
      for (var a = 1; ; a++) if ((new Date(year, 0, a)).getDay() == 1) break;
      a += (weekNumber - 1) * 7;
      this.numberMonthOfFirstDayOfWeek = new Date(year, 0, a).getMonth()
      return (new Date(year, 0, a))
    },
    // логика календаря
    weekCalendar: function () {
      let numOfDayInMonth = new Date(this.year, this.numberMonthOfFirstDayOfWeek + 1, 0).getDate(); // число дней в текущем мес
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
        if (a.index === new Date().getDate() && this.year === new Date().getFullYear() && this.weekNumber === this.currentWeek) {
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
    },
    increase: function () {
      this.weekNumber++;
      this.numberMonthOfFirstDayOfWeek = this.DateOfMondayInWeek(this.year, this.weekNumber).getMonth();
      // console.log(this.weekNumber);
      if (this.weekNumber === 52) {
        this.weekNumber = 1;
        this.year++;
      }
      this.getIntervalsFromDB();

    },
    // подсветка текущего дня
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
    // ----------------------------------------

    // ---- ФУНКЦИИ ДЛЯ РАБОТЫ С ИНТЕРВАЛАМИ ---- \\
    // получить и отобразить все интервалы
    getIntervalsFromDB: function () {
      $('.time-intrevals-elem ').each((k, val) => {
        val.innerHTML = '';
      });

      axios.post('/handle.php', JSON.stringify({'method': 'getTimeIntervals'}))
          .then((response) => {
            // console.log(response.data);
            let dataFromDB = response.data;
            let unconfirmedBooks = [];
            // console.log(dataFromDB[0]);
            if (dataFromDB !== null) {
              dataFromDB.forEach(function (dataFromDB, k) {
                // console.log(dataFromDB.day); // ...7.03.2021...
                $('.time-intrevals-elem ').each((k, val) => {
                  // console.log(val.getAttribute('date'));
                  let dateNumber = val;

                  let data = new Date();
                  let date = $(val).attr('date');
                  let day = date.split('.')[0];
                  let month = date.split('.')[1];
                  let str = '';
                  let valHour = '';

                  if (dataFromDB.day === dateNumber.getAttribute('date')) {
                    // console.log(dataFromDB.time);
                    let arr = dataFromDB.time.split(',');
                    // console.log(arr);
                    let str = arr.join('</div><div>');
                    // console.log(str);
                    // console.log(dateNumber.innerHTML);
                    dateNumber.innerHTML = '<div>' + str + '</div>';

                    //--------- функция деактивации интервалов ранее текущего времени
                    $(val).children().each((k, val) => {
                      // if (this.freeLesson) {
                      //   valHour = val.innerHTML.split(':')[0];
                      // } else {
                      // }
                      valHour = val.innerHTML.split('-')[0].split(':')[0];

                      if (day < data.getDate() && month <= data.getMonth() + 1 || month < data.getMonth() + 1) {
                        val.classList.add('booked-for-other-users');
                      }
                      if (+valHour - 1 < data.getHours() && day == data.getDate() && month <= data.getMonth() + 1 || month < data.getMonth() + 1) {
                        val.classList.add('booked-for-other-users');
                      }
                    })
                  }

                });

              })
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
                        this.bookedGmtArray.push(obj);

                      });

                    });
                  }
                  // console.log(unconfirmedBooks)
                  // console.log(this.bookedGmtArray)
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
                          let timeFromBook = timeFromBookedGmtArray.split('-')[0].trim();
                          if (timeFromBook.split(':')[0].length == 1) {
                            timeFromBook = '0' + timeFromBook;
                          }
                          if (time.innerHTML.split('-')[0].trim() === timeFromBook.trim()) {
                            time.classList.add('booked-for-other-users');
                          }
                          if (time.innerHTML.split('-')[0] === timeFromBookedGmtArray) {
                            time.classList.add('booked-free');
                          }
                        }
                      }
                    })
                  })
                });

          });
    },

    // выбор свободного интервала для замены
    chooseTime: function (event) {
      console.log('chooseTime');
      // console.log(event.target);
      $('.time-intrevals-elem div').removeClass('selected-time');
      let selectedTime = event.target;
      if (selectedTime.className.includes('selected-time')) {
        selectedTime.classList.remove('selected-time');
      } else {
        selectedTime.classList.add('selected-time');
      }

      this.selectedTimeArray = [];
      // selectedTimeArray = [];
      let userName = this.userName;
      let typeOfLesson = this.typeOfLesson;

      $('.selected-time').each((k, val) => {
        let day = val.parentNode.getAttribute('date');
        let time = val.innerHTML;
        // console.log(val.parentNode.getAttribute('date') + val.innerHTML);
        let obj = {
          name: userName,
          type: typeOfLesson,
          day: day,
          time: time,
          payment: 'payed',
          gmt: this.timeZone,
          'method': 'bookEvent'
        };
        console.log(obj)
        if (day !== null && time !== '') {
          this.selectedTimeArray.push(obj);
          // selectedTimeArray.push(obj);
        }
      });
      console.log(this.selectedTimeArray);
      // console.log(selectedTimeArray);
      // this.selectedTimeArray = array.slice(0);
    },
    // "изменить время урока"
    bookEvent: function (event) {
      if (this.selectedTimeArray.length !== 0) {
        this.$emit('update');
        axios.post('/handle.php', JSON.stringify(this.selectedTimeArray))
        this.reload += 1;

        // всплывающая подсказка "нужно выбрать время урока"
      } else {
        // console.log($(event.target));
        $(event.target).prev(".prompt").fadeTo("slow", 1);
        setTimeout(function () {
          $(event.target).prev(".prompt").fadeOut();
        }, 1000)
      }
    },
    // функция изменения состояния интервала в календаре при
    // забронированных интервалах для данного пользователя
    changeStateOfItem: function () {
      let timeInterval = $('.time-intrevals-from-db__item');
      axios.post('/handle.php', JSON.stringify({'method': 'getLessons'}))
          .then((response) => {
            // console.log(response.data);
            // получаем всю информацию о забронированных уроках по данному пользователю
            let dataFromDB = response.data;
            // console.log($(this).attr('date'));
            dataFromDB.forEach(function (val, k) {
              // console.log(val[1]);
              let dayFromDB = val[2];
              let timeFromDB = val[3];
              // console.log(userNameFromDB);
              timeInterval.each(function (k, val) {
                if ($(this).attr('date') === dayFromDB) {
                  // console.log(timeFromDB);
                  // console.log($(this).children())
                  $(this).children().each((k, val) => {
                    // console.log(val.innerHTML);
                    if (val.innerHTML === timeFromDB) {
                      val.classList.add('booked-for-other-users');
                      // console.log(val);
                    }
                  })
                }
              })
            })
          });
      this.showPreLoader = false;
    },

    closeAdminBookCalendar() {
      // Для сброса значений компонента при отмене использую :key reload
      this.reload += 1;
      this.$emit('close');
    },
  },
}
</script>

<style scoped>

.prompt {
  position: absolute;
  opacity: 0;
  font-size: 14px;
  width: 211px;
  color: #FF3E28;
  font-style: italic;
  text-align: center;
  bottom: 70px;
}

.wrap {
  display: flex;
  max-width: 420px;
  width: 100%;
  margin: 0 auto;
}

.cancel-btn {
  background-color: #4C9CD8;
  width: 200px;
  height: 45px;
  line-height: 43px;
  margin: 0 auto;
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

.calendar-app-header {
  justify-content: unset !important;
}

.calendar-app-header__element--month-module {
  margin-left: 82px;
}

</style>