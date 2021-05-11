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
            <!--            <select v-model="timeZone" @change="switchTimeZone()" class="time-zone header-content__element">-->
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
              <!--              <div class="user-icon"></div>-->
              <img :class="avatarOpened" @click="openAvatar" src="/images/icons/user-ico.svg" class="user-icon">
              <div :class="avatarCloseBtn" @click="openAvatar" class="close-btn"></div>
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
      avatarOpened: null,
      avatarCloseBtn: null,
    }
  },
  mounted: function () {

    this.getBooksTimeFromDB();
    this.setTimeZone();
  },

  updated() {
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
      this.preloader = true;


      // очищает ячейки при обновлении компонента
      $('.calendar-table-days .book').remove();

      let zone = new Date().toString().split(' ')[5];
      this.timeZone = 'GMT ' + zone.substring(3, 6) + ':00';
      let bookedGmtArray = [];

      axios.post('/handle.php', JSON.stringify({'method': 'getLessons'}))
          .then((response) => {
            let data = response.data;
            // console.log(data)

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
                    bookingTime: ' ',
                    'method': 'setToBooksTimeGMT'
                  };

                  bookedGmtArray.push(obj);
                });
                // console.log(bookedGmtArray)

              });
            }

          });

      setTimeout(() => {
        axios.post('/handle.php', JSON.stringify(bookedGmtArray))
            .then((response) => {
              // console.log(response.data);
              if (response.data.trim() !== '') {
                if (response.data === 'success') {
                } else {
                  window.location.reload();
                }
              }

            });
      }, 100);


      axios.post('/handle.php', JSON.stringify({'method': 'getLessonsFromBookstimeGMT'}))
          .then((response) => {
            // console.log(response.data);
            let data = response.data;
            // console.log(data)
            if (data !== null) {

              data.forEach((val, k) => {

                let typeFromDb = val[4];
                let nameFromDb = val[1];
                let dayFromDb = val[2];
                let timeFromDb = val[3];
                let gmtFromDb = val[8];
                let priceFromDb = val[7];
                let paymentFromDb = val[5];
                let confirmationFromDb = val[6];

                if (typeFromDb === 'free') {
                  this.freeLesson = true;
                }


                $('.calendar-table-days').each((k, val) => {
                  let day = $(val);
                  let dateOfcell = val.getAttribute('date');
                  // timeFromDb = newArray.join

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
                })
              });
            }

            setTimeout(() => {
              this.preloader = false;
            }, 200);
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

        let getAllUsersInfo = JSON.parse(localStorage.getItem('getAllUsersInfo'));
        for (let user of getAllUsersInfo) {
          // console.log(user)

          if ($(target).attr('name') === user.name) {
            // console.log(user.avatar)
            if (user.avatar !== '') {
              $('.user-icon').attr('src', '../images/icons/user-ico.svg')
              $('.user-icon').attr('src', user.avatar)
            } else {
              $('.user-icon').attr('src', '../images/icons/user-ico.svg')
            }
          }

        }

      }
    },
    // Открыть аватарку
    openAvatar() {
      if (this.avatarOpened === null) {
        this.avatarOpened = 'user-avatar-opened';
        this.avatarCloseBtn = 'close-btn-active';
      } else {
        this.avatarOpened = null;
        this.avatarCloseBtn = null;
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

      // console.log(this.target);
      axios.post('/handle.php', JSON.stringify({obj}))
          .then((response) => {
            let data = response.data;
            console.log(data)
            if (data.payment === 'success') {
              this.payment = true;
              $(this.target).attr('payment', 'payed').removeClass('unpayed');

              let userInfo = JSON.parse(localStorage.getItem('getAllUsersInfo'));
              let email;

              userInfo.forEach((val, k) => {
                if (this.detailUserName === val.name) {
                  email = val.email;
                }
              });


              let mailForUser = {
                name: this.detailUserName,
                time: this.detailTime,
                data: this.detailDate,
                email: email,
                    'method':'confirmedByTutor'
            }
              axios.post('/mailer.php', JSON.stringify(mailForUser))

            } else {
              this.errors.push(data.payment);
              // console.log(this.errors);
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