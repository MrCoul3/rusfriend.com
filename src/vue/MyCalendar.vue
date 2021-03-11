<template>
    <section id="my-calendar" class="my-calendar admin-inner admin-panel-section calendar-active">
        <h2  class="main-title">Календарь занятий</h2>
        <h3 class="main-title main-title__description">Здесь ты можешь посмотреть информацию о забронированных занятиях, нажав на интересующую ячейку</h3>
        <div class="wrapper">
            <div class="calendar-header">
                <div class="header-content">
                    <div class="month-module header-content__element">
                        <p class="month">{{monthes[month]}} {{year}}</p>
                        <div v-on:click="decrease"  class="month-btn month-btn--left-btn"></div>
                        <div v-on:click="increase"  class="month-btn month-btn--right-btn"></div>
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

                    <td  class="calendar-table-day"  v-for="day in week" :style="{'background-color': day.current}" :date="day.index + '.' + currentMonth + '.' + year"><span class="day-number">{{ day.index }}</span><span class="day-time">13:00 - 14:00 David</span></td>

                </tr>
            </table>
        </div>
    </section>
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
                monthes: ["January", "Февраль", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                date: new Date(),
                timeChangeSatus: 'calendar-disable',
                currentMonth: null,
                showPreloader: true,
                dayOfWeek: null,
            }
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
            },
            increase: function () {
                this.month++;
                if (this.month > 11) {
                    this.month = -1;
                    this.month++;
                    this.year++;
                }

            },
            setCurrentMonth() {
                if ((String(this.month + 1).length) == '1') {
                    this.currentMonth = 0 + String(this.month + 1);
                } else {
                    this.currentMonth = this.month + 1;
                }
            },
        },
    }
</script>

<style lang="scss">

</style>