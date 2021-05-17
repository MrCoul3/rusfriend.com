<template>
  <div>
    <div v-show="preloader" id="preloader"></div>

    <section id="vue-my-schedule" class="my-schedule admin-inner admin-panel-section">
      <h2 class="main-title">Мое расписание</h2>
      <h3 class="main-title main-title__description">Для составления расписания нажмите на необходимую ячейку
        календаря и выберите интервалы</h3>
      <div class="wrapper">
        <div class="calendar-header">
          <div class="header-content">
            <div class="month-module header-content__element">
              <p class="month">{{ monthes[month] }} {{ year }}</p>
              <div v-on:click="decrease" @click="setCurrentMonth"
                   class="month-btn month-btn--left-btn"></div>
              <div v-on:click="increase" @click="setCurrentMonth"
                   class="month-btn month-btn--right-btn"></div>
            </div>

<!--            <select @click="switchTimeZone($event)" class="time-zone header-content__element">-->
<!--              <option class="time-zone-option" v-for="gmt in timeZones" :value="gmt">{{ gmt }}</option>-->
<!--            </select>-->
            <div v-model="timeZone"
                 class="time-zone header-content__element">
              {{ timeZone }}
            </div>
          </div>
        </div>


        <table class="calendar-table admin-inner">
          <tr>
            <th v-for="d in day">{{ d }}</th>
          </tr>

          <tr v-for="week in calendar()">

            <td class="calendar-table-day" @click="openTimeChanger($event)" v-for="day in week"
                :style="{'background-color': day.current}"
                :date="day.index + '.' + currentMonth + '.' + year"><span
                class="day-number">{{ day.index }}</span><span class="day-time"></span></td>

          </tr>
        </table>
      </div>

      <div class="time-changer-wrapper" :class="timeChangeSatus">
        <div class="time-changer" :class="timeChangeSatus">
          <h2 class="time-changer-title">Изменить доступное время</h2>
          <h3 class="time-changer-current-date">{{ currentDate }} {{ dayOfWeek }}</h3>
          <div @click="closeTimeChanger" class="form-close-btn"></div>
          <div class="decor-line"></div>
          <div class="time-changer-content">

            <div class="time-setter-modul">

              <div class="time-selectors-block">

                <!-- тумблер--------------->
                <div class="time-type-switcher center">
                  <input type="checkbox" id="cbx" style="display:none"/>
                  <label @click="switcherTypeOfIntervals" for="cbx" class="toggle"><span></span></label>
                </div>
                <!-- -------- тумблер end-->
                <select class="time-selectors-block__item" name="left-time" id="left-time">
                  <option v-for="(item, index) in timeLeftSelectorVariables" :data-index="index"
                          :value="item">{{ item }}
                  </option>

                  <!--                  <option v-if="switcherIntervals = false"  v-else v-for="(item, index) in timeLeftSelectorVariables"-->
                  <!--                          :data-index="index"-->
                  <!--                          :value="item">{{ item }}-->
                  <!--                  </option>-->

                </select>
                <span class="line time-selectors-block__item"></span>
                <select class="time-selectors-block__item" name="right-time" id="right-time">
                  <option v-for="(item, index) in timeRightSelectorVariables"
                          :data-index="index"
                          :value="item">{{ item }}
                  </option>

                  <!--                  <option v-if="switcherIntervals = false" v-for="(item, index) in timeRightSelectorVariables" :data-index="index"-->
                  <!--                          :value="item">{{ item }}-->
                  <!--                  </option>-->
                </select>
                <div @click="addTime()"
                     class="time-selectors-block__item time-changer-button time-changer-button--add-time-button">
                  &#10003;
                </div>
              </div>

              <div class="time-changer-content__element time-changer-content__element--time-list-modul">
                <div class="time-elem" v-for="(item,index) in timeIntervals" :index="index"
                     :value="item">
                  <div class="time">{{ item }}</div>
                  <div @click="delTime($event)" class="del-btn"></div>
                </div>
              </div>
              <div @click="applyBtn"
                   class="time-changer-button time-changer-button--apply-to-current-day">
                применить к <span style="font-weight: bold">текущему</span> дню
              </div>
              <div class="time-changer-button time-changer-button--apply-to-all-day">применить ко дням:
                <span
                    style="font-weight: bold">{{ dayOfWeek }}</span></div>
              <div @click="delBtn" class="time-changer-button time-changer-button--clear-schedule">
                очистить
                расписание
              </div>

            </div>


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
export default {
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
      timeIntervals: [],
      timeLeftSelectorVariables: ['06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00'],
      timeRightSelectorVariables: ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'],
      timeLeftSelectorVariablesFull: ['06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00'],
      timeLeftSelectorVariablesOverall: ['06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00'],
      timeRightSelectorVariablesFull: ['06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00'],
      timeRightSelectorVariablesOverall: ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'],
      switcherIntervals: true,
      timeChangeSatus: 'calendar-disable',
      currentDate: null,
      currentMonth: null,
      timeIsSet: false,
      dataFromDB: [],
      dayOfWeek: null,
      lengthOfData: undefined,
      // currentGMT: null,
      preloader: true,
    }
  },
  mounted: function () {
    this.getIntervalsFromDB();
    this.setTimeZone();

  },
  created: function () {
    // // console.log(this.currentDayOfWeek);
    if ((String(this.month + 1).length) == '1') {
      this.currentMonth = 0 + String(this.month + 1);
    } else {
      this.currentMonth = this.month + 1;
    }
  },
  methods: {
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

    // переключениe часового пояса
    // switchTimeZone(event) {
    //   let select = event.target;
    //   this.timeZone = event.target.value;
    //   // // console.log(this.timeZone);
    //   select.addEventListener('change', () => {
    //     this.getIntervalsFromDB();
    //   });
    // },

    calendar: function () {
      let days = [];
      let week = 0;
      let a;
      days[week] = [];
      let dlast = new Date(this.year, this.month + 1, 0).getDate(); // 28 число дней  в месяце
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
      this.getIntervalsFromDB();
    },
    increase: function () {
      this.month++;
      if (this.month > 11) {
        this.month = -1;
        this.month++;
        this.year++;
      }
      this.getIntervalsFromDB();
    },
    resetValues() {
      this.timeIsSet = false;
      let arrLeft = this.timeLeftSelectorVariables;
      let arrRight = this.timeRightSelectorVariables;
      this.timeIntervals.forEach(function (val, ind) {
        let value = val.split('-');
        if (!arrLeft.includes(value[0].trim())) {
          arrLeft.push(value[0].trim());
          arrLeft.sort();
        }
        if (!arrRight.includes(value[1].trim())) {
          arrRight.push(value[1].trim());
          arrRight.sort();
        }
      });
      this.timeIntervals = [];
    },

    closeTimeChanger() {
      this.timeChangeSatus = 'calendar-disable';
      this.resetValues();
    },
    setCurrentMonth() {
      if ((String(this.month + 1).length) == '1') {
        this.currentMonth = 0 + String(this.month + 1);
      } else {
        this.currentMonth = this.month + 1;
      }
    },
    openTimeChanger(event) {
      // день недели выбранной ячейки
      let targetDate = event.target.closest('td').getAttribute('date')
      targetDate = targetDate.split('.');
      targetDate[1] = +targetDate[1] - 1;
      targetDate = targetDate.reverse().join(', ');
      // console.log(targetDate);
      let date = new Date(targetDate).getDay();
      // // console.log(this.daySun[date]);
      this.dayOfWeek = this.daySun[date];
      // время выбранной ячейки
      let timeInCell = event.target.closest('.calendar-table-day');
      // // console.log(timeInCell.childNodes[1].childElementCount)
      if (timeInCell.childNodes[1].childElementCount === 0) {
        this.timeIsSet = false;
      } else {
        this.timeIsSet = true;
      }
      // // console.log(this.timeIsSet);
      this.timeChangeSatus = 'calendar-active';
      this.setCurrentMonth();
      this.currentDate = event.target.closest('.calendar-table-day').getAttribute('date');
      let currDate = this.currentDate;
      let timeIntervals = this.timeIntervals;
      let arrLeft = this.timeLeftSelectorVariables;
      let arrRight = this.timeRightSelectorVariables;

      axios.post('handle.php', JSON.stringify({'method': 'getTimeIntervals'}))
          .then((response) => {
            let resData = response.data;
            let mass;
            if (resData !== null) {
              resData.forEach(function (val, k) {
                let dateFromDb = val.day;
                let timeFromDb = val.time;
                // // console.log(dateFromDb);
                // // console.log(currDate);
                if (currDate === dateFromDb) {
                  mass = timeFromDb.split(',');
                  // // console.log(timeFromDb.split(',')[0]);
                  mass.forEach(function (val, k) {
                    let massValue = val;
                    arrLeft.forEach(function (val, k) {
                      if (val === massValue.trim().split(' - ')[0]) {
                        arrLeft.splice(k, 1);
                      }
                    });
                    arrRight.forEach(function (val, k) {
                      if (val === massValue.trim().split(' - ')[1]) {
                        arrRight.splice(k, 1);
                      }
                    });
                    // // console.log(massValue.trim().split(' - ')[0]);
                    timeIntervals.push(val.trim());
                  })
                }
              })
            }
          });
    },
    compareNumeric(a, b) {
      if (a > b) return 1;
      if (a == b) return 0;
      if (a < b) return -1;
    },
    addTime() {

      if (this.timeIntervals.length < 21) {
        this.timeIsSet = true;
        let timeVal = $('#left-time').val() + ' - ' + $('#right-time').val();
        // console.log(timeVal);
        this.timeIntervals.push(timeVal);
        this.timeIntervals.sort(this.compareNumeric);
        let leftValIndex = $('#left-time option:selected').attr('data-index');
        let rightValIndex = $('#right-time option:selected').attr('data-index');

        this.timeLeftSelectorVariables.splice(leftValIndex, 1);
        this.timeRightSelectorVariables.splice(rightValIndex, 1);

        // // console.log(this.timeIntervals);
      }
      // // console.log(this.timeIsSet);
    },
    delBtn() {
      this.resetValues()
      // console.log(this.timeIntervals);
    },
    delTime(event) {
      // console.log(this.timeIsSet);
      let val = event.target.parentNode.getAttribute('value');
      let arr = val.split('-');
      if (!this.timeLeftSelectorVariables.includes(arr[0].trim())) {
        this.timeLeftSelectorVariables.push(arr[0].trim());
        this.timeLeftSelectorVariables.sort(this.compareNumeric);
      }
      if (!this.timeRightSelectorVariables.includes((arr[1]).trim())) {
        this.timeRightSelectorVariables.push((arr[1]).trim());
        this.timeRightSelectorVariables.sort(this.compareNumeric);
      }
      let index = this.timeIntervals.indexOf(val);
      this.timeIntervals.splice(index, 1);

      if (this.timeIntervals.length === 0) {
        this.timeIsSet = false;
      } else {
        this.timeIsSet = true;
      }
    },
    applyBtn() {
      // console.log(this.timeIntervals.length);
      // console.log(this.timeIntervals);
      // console.log(this.timeIsSet);
      if (this.timeIsSet === true) {
        let inputData = {
          day: this.currentDate,
          time: this.timeIntervals,
          gmt: this.timeZone,
          'method': 'addTimeIntervals'
        }
        let response = fetch('handle.php', {
          method: 'Post',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify(inputData)

        });
        this.getIntervalsFromDB();
      } else {
        let inputData = {
          day: this.currentDate,
          'method': 'deleteTimeIntervals'
        }
        let response = fetch('handle.php', {
          method: 'Post',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify(inputData)
        });
        this.getIntervalsFromDB();
      }

      this.closeTimeChanger();
    },

    getIntervalsFromDB() {
      this.preloader = true;
      $('.calendar-table-day').each(function (k, val) {
        let day = $(this);
        let dayTime = day.find('.day-time')[0]
        dayTime.innerHTML = '';
      });

      let obj = {};
      let obj2 = {};
      let obj3 = {};
      let array = [];
      let array2 = [];

      axios.post('/handle.php', JSON.stringify({'method': 'getTimeIntervals'}))
          .then((response) => {
            // // console.log(response.data);
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
            // // console.log(this.lengthOfData)

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
                  // // console.log(val);
                  let dayFromDb = val.day;
                  let timeFromDb = val.time;
                  let gmtFromDb = val.gmt;

                  let gmtFromDbNum = gmtFromDb.split(' ')[1].substring(0, 3);
                  let delta = timeZoneNum - gmtFromDbNum;
                  // // console.log(timeFromDb)

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
                    // // console.log(lastNum)
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
                      // // console.log(prevDateNumber)
                      // // console.log(time)
                      newArr.push(time);
                      // // console.log(newArr.join(', '))
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
                  // // console.log(array2)
                  // // console.log(obj)
                  // // console.log(obj2)
                });
              }
              let object = {
                intervals: array2,
                'method': 'setToTempGMT'
              }
              // // console.log(array2);
              axios.post('/handle.php', JSON.stringify(object))
            }
          });

    },
    getOfTempDB() {
      this.preloader = true;
      setTimeout(() => {
        axios.post('/handle.php', JSON.stringify({'method': 'getFromTempGMT'}))
            .then((response) => {
              let data = response.data;
              // // console.log(data)
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
                      // // console.log(val);
                      let dayFromDb = val[0];
                      let timeFromDb = val[1];
                      let gmtFromDb = val[2];
                      let newArr = [];

                      let arr = timeFromDb.split(',');
                      // // console.log(timeFromDb);
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

                      $('.calendar-table-day').each((k, val) => {

                        let dateNumber = val;
                        let dayTime = $(dateNumber).find('.day-time')[0];
                        let data = new Date();
                        let date = $(val).attr('date');
                        let day = date.split('.')[0];
                        let month = date.split('.')[1];
                        let str = '';
                        let valHour = '';

                        if (dayFromDb === date) {

                          if (this.freeLesson) {
                            let arr = [];
                            newArr.forEach((val, k) => {
                              arr.push(val.split('-')[0]);
                            })
                            str = arr.join('</div><div>');
                          } else {
                            str = newArr.join('</span><span>');
                          }

                          // $(dateNumber).append('<span>' + str + '</span>');
                          dayTime.innerHTML = '<span>' + str + '</span>';

                        }

                      });
                    });
                  }
                } else {
                  // если не совпадает выполняется getIntervalsFromDB заново
                  // console.log('false')
                  this.getIntervalsFromDB();
                }
              }

              axios.post('/handle.php', JSON.stringify({'method': 'getLessons'}))
                  .then((response) => {
                    // получаем всю информацию о забронированных уроках по данному пользователю
                    let data = response.data;
                    // // console.log(data)
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
                          // // console.log(lastNum)
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

                          // // console.log(time)

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

                          // // console.log(obj)
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

                    // // console.log(unconfirmedBooks)

                    // удаление неоплаченных бронирований через 15 минут
                    axios.post('/handle.php', JSON.stringify(unconfirmedBooks))
                        .then((response) => {
                          let data = response.data;
                          if (data === true) {
                            // // console.log(data)
                            this.getIntervalsFromDB();
                          }
                        });

                  });

            });
      }, 500)

    },

    exitBtn() {
      // console.log('exit');
    },

    // ---- функция меняет  switcherIntervals переключая тип времени в селекторах
    // добавления интервалов  (убирает/добавляет получасовые интервалы)
    switcherTypeOfIntervals() {

      this.timeLeftSelectorVariables = [];
      this.timeRightSelectorVariables = [];

      if (this.switcherIntervals === true) {
        this.switcherIntervals = false;

        this.timeLeftSelectorVariablesFull.forEach((val, k) => {
          this.timeLeftSelectorVariables.push(val);
        });

        this.timeRightSelectorVariablesFull.forEach((val, k) => {
          this.timeRightSelectorVariables.push(val);
        });

      } else {
        this.switcherIntervals = true;

        this.timeLeftSelectorVariablesOverall.forEach((val, k) => {
          this.timeLeftSelectorVariables.push(val);
        });

        this.timeRightSelectorVariablesOverall.forEach((val, k) => {
          this.timeRightSelectorVariables.push(val);
        });
      }

      // console.log(this.switcherIntervals);

    },
  }
}
</script>

<style>
/* // стили для компонента находятся в файле admin-panel.scss*/

/*@import '../styles/scss/admin-panel';*/


.toggle {
  position: relative;
  display: block;
  width: 40px;
  height: 20px;
  cursor: pointer;
  -webkit-tap-highlight-color: transparent;
  transform: translate3d(0, 0, 0);
}

.toggle:before {
  content: "";
  position: relative;
  top: 3px;
  left: 3px;
  width: 34px;
  height: 14px;
  display: block;
  background: #9A9999;
  border-radius: 8px;
  transition: background 0.2s ease;
}

.toggle span {
  position: absolute;
  top: 0;
  left: 0;
  width: 20px;
  height: 20px;
  display: block;
  background: white;
  border-radius: 10px;
  box-shadow: 0 3px 8px rgba(154, 153, 153, 0.5);
  transition: all 0.2s ease;
}

.toggle span:before {
  content: "";
  position: absolute;
  display: block;
  margin: -18px;
  width: 56px;
  height: 56px;
  background: rgba(79, 46, 220, 0.5);
  border-radius: 50%;
  transform: scale(0);
  opacity: 1;
  pointer-events: none;
}

#cbx:checked + .toggle:before {
  background: #947ADA;
}

#cbx:checked + .toggle span {
  background: #4F2EDC;
  transform: translateX(20px);
  transition: all 0.2s cubic-bezier(0.8, 0.4, 0.3, 1.25);
  box-shadow: 0 3px 8px rgba(79, 46, 220, 0.2);
}

#cbx:checked + .toggle span:before {
  transform: scale(1);
  opacity: 0;
  transition: all 0.4s ease;
}

.time-type-switcher {
  position: absolute;
  top: calc(50% - 10px);
  left: -55px;
}

</style>