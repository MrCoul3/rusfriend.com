<template>
  <div>
    <div v-show="preloader" id="preloader"></div>
    <section id="my-calendar" class="my-calendar admin-inner admin-panel-section ">
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
              <div class="tegs__element">
                <div class="circle circle--unpayed"></div>
                <span>Неоплаченное занятие</span>
              </div>
              <div v-show="freeLesson" class="tegs__element">
                <div class="circle circle--free"></div>
                <span>Пробный урок</span>
              </div>
            </div>
            <div class="month-module header-content__element">
              <p class="month">{{ monthes[month] }} {{ year }}</p>
              <div v-on:click="decrease" class="month-btn month-btn--left-btn"></div>
              <div v-on:click="increase" class="month-btn month-btn--right-btn"></div>
            </div>
            <select v-model="timeZone" @change="switchTimeZone()" class="time-zone header-content__element">
              <option class="time-zone-option" v-for="gmt in timeZones" :value="gmt">{{ gmt }}</option>
            </select>
          </div>
        </div>


        <table class="calendar-table admin-inner">
          <tr>
            <th v-for="d in day">{{ d }}</th>
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
          <div class="date">{{ detailDate }}</div>
          <div class="time">{{ detailTime }}</div>
          <div class="type">{{ detailType }}</div>
          <div class="decor-line"></div>

          <div class="wrap user-wrap">
            <div class="wrap user">
              <div class="user-icon"></div>
              <div class="user-name">{{ detailUserName }}</div>
            </div>
            <!--                        <div class="wrap message">-->
            <!--                            <div class="message-title">сообщение</div>-->
            <!--                            <div class="message-icon"></div>-->
            <!--                        </div>-->
            <div v-if="confirmation" class="confirmation">
              не оплачено студентом
            </div>
          </div>
          <div class="flex" style="display: flex; justify-content: space-between">
            <div class="wrap skype">
              <div class="skype-icon"></div>
              <div class="skype-name">{{ detailSkype }}</div>
            </div>
            <div v-if="payment" class="payment-status payment-status--payed">оплачено</div>
            <div @click="confirmPayment()" v-else class="payment-status payment-status--unpayed">подтвердить
              оплату
            </div>
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
            :time-zone="timeZone"
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
      detailShow: false, // окно детализации бронирования
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
      gmtArray: [],
      payment: true,
      target: null,
      errors: [],
      confirmation: 0,

    }
  },
  mounted: function () {
    this.getBooksTimeFromDB();
    this.setTimeZone();
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
    // ---- ФУНКЦИОНАЛ СМЕНЫ ЧАСОВЫХ ПОЯСОВ ---- \\
    // установка текущего часового пояса //
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
    switchTimeZone() {
      this.getBooksTimeFromDB();
    },
    // -------------------------------------------

    // ---- ФУНКЦИОНАЛ ЛОГИКИ КАЛЕНДАРЯ ---- \\
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
    // -------------------------------------------


    // ---- ФУНКЦИИ ДЛЯ РАБОТЫ С ИНТЕРВАЛАМИ ---- \\
    getBooksTimeFromDB() {
      // this.preloader = true;
      let array = [];
      let newArray;
      // console.log('getintervals')

      // очищает ячейки при обновлении компонента
      $('.calendar-table-days .book').remove();

      axios.post('/handle.php', JSON.stringify({'method': 'getBooksTime'}))
          .then((response) => {
            // console.log(response.data);
            let data = response.data;
            console.log(data)
            let freeLesson = null;
            if (data !== null) {
              data.forEach((val, k) => {

                let typeFromDb = val.type;
                let nameFromDb = val.name;
                let dayFromDb = val.day;
                let timeFromDb = val.time;
                let gmtFromDb = val.gmt;
                let paymentFromDb = val.payment;
                let confirmationFromDb = val.confirmation;
                if (typeFromDb === 'free') {
                  freeLesson = true;
                }

                // --------------------------------------------------


                $('.calendar-table-days').each((k, val) => {
                  let day = $(val);
                  let dateOfcell = val.getAttribute('date');
                  // timeFromDb = newArray.join

                  if (this.timeZone !== gmtFromDb) {

                    let obj = {};
                    let obj2 = {};
                    let obj3 = {};

                    let timeZoneNum = this.timeZone.split(' ')[1].substring(0, 3);
                    let gmtFromDbNum = gmtFromDb.split(' ')[1].substring(0, 3);
                    let delta = timeZoneNum - gmtFromDbNum;

                    let arr = timeFromDb.split(',');

                    let newArr = [];
                    let newArr2 = [];
                    let newArr3 = [];


                    arr.forEach((val, k) => {
                      let prevNum = +dayFromDb.split('.')[0] - 1;
                      let prevMonth = +dayFromDb.split('.')[1];
                      if (String(prevMonth).length < 2) {
                        prevMonth = '0' + prevMonth;
                      }
                      let prevYear = +dayFromDb.split('.')[2];

                      let prevDateNumber = prevNum + '.' + prevMonth + '.' + prevYear;

                      let nextNum = +dayFromDb.split('.')[0] + 1;
                      let nextMonth = +dayFromDb.split('.')[1];
                      if (String(nextMonth).length < 2) {
                        nextMonth = '0' + nextMonth;
                      }
                      let nextYear = +dayFromDb.split('.')[2];

                      let nextDateNumber = nextNum + '.' + nextMonth + '.' + nextYear;
                      let firstH;
                      let firstM;
                      let secondH;
                      let secondM;
                      let time;
                      let a;
                      let b;
                      if (paymentFromDb !== 'free') {
                        firstH = val.split('-')[0].split(':')[0];// 06
                        firstM = val.split('-')[0].split(':')[1];// 00
                        secondH = val.split('-')[1].split(':')[0]; // 07
                        secondM = val.split('-')[1].split(':')[1]; // 30
                        a = +firstH + delta; // 02
                        b = +secondH + delta; //05
                        time = a + ':' + firstM + ' - ' + b + ':' + secondM;

                      } else {
                        firstH = val.split(':')[0];// 06
                        firstM = val.split(':')[1];// 00
                        a = +firstH + delta; // 02
                        time = a + ':' + firstM;
                      }


                      if (a < 0) {
                        // console.log(dayFromDb)
                        // console.log(time)
                        newArr.push(time);
                        obj = {
                          day: prevDateNumber,
                          time: newArr.join(', '),
                          gmt: this.timeZone,
                        }
                      }

                      if (a >= 0 && a < 24) {
                        // console.log(dayFromDb)
                        // console.log(time)
                        newArr2.push(time);
                        obj2 = {
                          day: dayFromDb,
                          time: newArr2.join(', '),
                          gmt: this.timeZone,
                        }
                      }

                      if (a > 23) {
                        // console.log(dayFromDb)
                        // console.log(time)

                        newArr3.push(time);
                        obj3 = {
                          day: nextDateNumber,
                          time: newArr3.join(', '),
                          gmt: this.timeZone,
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
                    // console.log(array)
                    // console.log(obj)
                    // console.log(obj2)
                    // console.log(obj3)
                    let object = {
                      intervals: array,
                      'method': 'setToTempGMT'
                    }
                    // axios.post('/handle.php', JSON.stringify(object));


                    // axios.post('/handle.php', JSON.stringify({'method': 'getFromTempGMT'}))
                    // получить данные и вставить в календарь

                  } else {
                    if (dateOfcell === dayFromDb) {
                      if (paymentFromDb === 'payed' || paymentFromDb === 'free') {
                        day.append("<span confirmation='" + confirmationFromDb + "' type='" + typeFromDb + "' name='" + nameFromDb + "' time='" + timeFromDb + "' data=" + dateOfcell + " class='book " + typeFromDb + "'>" + timeFromDb + ' ' + nameFromDb + "</span>")
                        // day.children().each((k, val) => {
                        //     // console.log(val);
                        //     let valName = val.getAttribute('name');
                        //     let valType = val.getAttribute('type');
                        //     let valTime = val.getAttribute('time');
                        //     let valDate = val.getAttribute('data');
                        //     if (typeFromDb !== valType && nameFromDb !== valName && dayFromDb !== valDate && timeFromDb !== valTime) {
                        //     }
                        // });
                      }
                      if (paymentFromDb === 'unpayed') {
                        day.append("<span confirmation='" + confirmationFromDb + "' payment='" + paymentFromDb + "' type='" + typeFromDb + "' name='" + nameFromDb + "' time='" + timeFromDb + "' data=" + dateOfcell + " class='book " + typeFromDb + ' ' + paymentFromDb + "'>" + timeFromDb + ' ' + nameFromDb + "</span>")
                      }
                    }
                  }
                })
              });
            }

            this.freeLesson = freeLesson;
            setTimeout(() => {
              this.preloader = false;
            }, 50);
          });
    },
    // действие при нажатии на занятие
    bookingEvent(event) {
      let target = event.target;
      this.target = event.target;
      // console.log($(target));
      if (event.target.className.includes('book')) {

        // смена статуса оплачено на подтвердить оплату
        if ($(target).attr('payment') === 'unpayed') {
          this.payment = false;
        } else {
          this.payment = true;
        }
        if ($(target).attr('confirmation') == 0) {
          this.confirmation = true;
        } else {
          this.confirmation = false;

        }

        this.detailShow = true; // открытие окна детализации бронирования
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
    // подтвердить оплату
    confirmPayment() {

      let obj = {
        name: this.detailUserName,
        time: this.detailTime,
        date: this.detailDate,
        'method': 'successPay',
      }

      console.log(this.target);

      axios.post('/handle.php', JSON.stringify({obj}))
          .then((response) => {
            let data = response.data;
            console.log(data)
            if (data.payment === 'success') {
              this.payment = true;
              $(this.target).attr('payment', 'payed').removeClass('unpayed');
            } else {
              this.errors.push(data.payment);
              console.log(this.errors);
            }
          });
    },
    // отмена занятия
    cancelLessonFrame() {
      this.detailShow = false;
      this.cancelLessShow = true;
    },
    // закрыть всплыв. окно "Вы уверены, что хотите отменить урок?"
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
    // "отмена" Закрыть календарь изменения урока (закрыть AdminBookCalendar.vue)
    closeAdminCalendar(data) {
      this.showBookCalendar = false;
      this.detailShow = true;
    },
    // 'при клике по "изменить время урока" удалить изменяемый интервал
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