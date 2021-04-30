import './index';
import './student-lessons';
import './settings';
import './common';
import './about';
import './offers';
import './book-calendar';
import './private-lesson';
import './speaking-club';
import './courses';
import './guide';
import './my-lessons';
import './admin-panel';
import './login-and-registration';
import 'owl.carousel';
import './easing-plugin';
import './free-lesson';
import './payment';
import Vue from 'vue';
import MySchedule from "../vue/MySchedule.vue";
import MyCalendar from "../vue/MyCalendar.vue";
import BookCalendar from "../vue/BookCalendar.vue";
import MyStudents from "../vue/MyStudents.vue";
import AdminBookCalendar from "../vue/AdminBookCalendar.vue";
// -----------------------------------------------------------
Vue.config.productionTip = false;
$(document).ready(function () {
    console.log('app.js init')
// -----------------------------------------

// ----------------- ПОДКЛЮЧЕНИЯ VUE КОМПОНЕНТОВ ---------------- \\

    // ----------- мой календарь (админ-панель)
    if (document.getElementById('vue-my-calendar')) {
        console.log('init vue-my-calendar')
        const myCalendar = new Vue({
            el: '#vue-my-calendar',
            template: "<MyCalendar/>",
            components: {MyCalendar}
        })
    }

    // ----------- мое расписание (админ-панель)
    if (document.getElementById('vue-my-schedule')) {
        console.log('init vue-my-schedule');
        const mySchedule = new Vue({
            el: '#vue-my-schedule',
            template: "<MySchedule/>",
            components: {MySchedule}
        });
    }

    // ----------- мои ученики (админ-панель)
    if (document.getElementById('vue-my-students')) {
        console.log('init vue-my-students')
        const bookCalendar = new Vue({
            el: "#vue-my-students",
            template: "<MyStudents/>",
            components: {MyStudents}
        })
    }

    // ----------- компонент для редактирования времени урока (админ-панель)
    if (document.getElementById('vue-admin-book-calendar')) {
        console.log('init vue-admin-book-calendar');
        const mySchedule = new Vue({
            el: '#vue-admin-book-calendar',
            template: "<AdminBookCalendar/>",
            components: {AdminBookCalendar}
        });
    }

    // ----------- календарь бронирования (в private-lesson и s-club)
    if (document.getElementById('vue-book-calendar')) {
        console.log('init vue-book-calendar')
        const bookCalendar = new Vue({
            el: "#vue-book-calendar",
            template: "<BookCalendar/>",
            components: {BookCalendar}
        })
    }

// -----------------------------------------
});

