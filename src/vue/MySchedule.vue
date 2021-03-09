<template>
    <section id="my-schedule" class="my-schedule admin-inner admin-panel-section">
        <h2  class="main-title">Мое расписание</h2>
        <div class="wrapper">
            <div class="calendar-header">
                <div class="header-content">
                    <div class="month-module header-content__element">
                        <p class="month">{{monthes[month]}} {{year}}</p>
                        <div v-on:click="decrease" @click="setCurrentMonth" class="month-btn month-btn--left-btn"></div>
                        <div v-on:click="increase" @click="setCurrentMonth" class="month-btn month-btn--right-btn"></div>
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

                    <td  class="calendar-table-day" @click="openTimeChanger($event)" v-for="day in week" :style="{'background-color': day.current}" :date="day.index + '.' + currentMonth + '.' + year"><span class="day-number">{{ day.index }}</span><span class="day-time"></span></td>

                </tr>
            </table>
        </div>
        <div class="time-changer" :class="timeChangeSatus">
            <h2 class="time-changer-title">Изменить доступное время</h2>
            <h3 class="time-changer-current-date" >{{currentDate}}</h3>
            <div @click="closeTimeChanger" class="form-close-btn"></div>
            <div class="decor-line"></div>
            <div class="time-changer-content">

                <div class="time-changer-content__element time-changer-content__element--time-setter-modul">
                    <div class="time-selectors-block">
                        <select class="time-selectors-block__item" name="left-time" id="left-time">
                            <option v-for="(item, index) in timeLeftSelectorVariables" :data-index="index" :value="item">{{item}}</option>
                        </select>
                        <span class="line time-selectors-block__item"></span>
                        <select class="time-selectors-block__item" name="right-time" id="right-time">
                            <option v-for="(item, index) in timeRightSelectorVariables" :data-index="index" :value="item">{{item}}</option>
                        </select>
                        <div @click="addTime()"
                             class="time-selectors-block__item time-changer-button time-changer-button--add-time-button">
                            &#10003;
                        </div>
                    </div>
                    <div class="time-changer-content__element time-changer-content__element--time-list-modul">
                        <div class="time-elem" v-for="(item,index) in timeIntervals" :index="index" :value="item">
                            <div class="time">{{item}}</div>
                            <div @click="delTime($event)" class="del-btn"></div>
                        </div>
                    </div>
                    <div @click="applyBtn" class="time-changer-button time-changer-button--apply-to-current-day">применить к текущему дню
                    </div>
                    <div class="time-changer-button time-changer-button--apply-to-all-day">применить ко всем четвергам</div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "MySchedule",
        data() {
            return {
                month: new Date().getMonth(),
                year: new Date().getFullYear(),
                dFirstMonth: '1',
                timeZones: [],
                day: ["Mn", "Tu", "We", "Th", "Fr", "Sa", "Su"],
                monthes: ["January", "Февраль", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                date: new Date(),
                timeIntervals: [],
                timeLeftSelectorVariables: ['06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00'],
                timeRightSelectorVariables: ['06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00'],
                timeChangeSatus: 'disable',
                currentDate: null,
                currentMonth: null,
            }
        },
        created: function () {
            if ((String(this.month + 1).length) == '1') {
                this.currentMonth = 0 + String(this.month + 1);
            } else {
                this.currentMonth = this.month + 1;
            }
        },
        computed: {},
        methods: {
            calendar: function () {
                var days = [];
                var week = 0;
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
            resetValues() {
                let arrLeft = this.timeLeftSelectorVariables;
                let arrRight = this.timeRightSelectorVariables;
                this.timeIntervals.forEach(function (val, ind) {
                    let value = val.split('-');
                    if (!arrLeft.includes(value[0].trim())) {
                        arrLeft.push(value[0].trim());
                        arrLeft.sort(this.compareNumeric);
                    }
                    if (!arrRight.includes(value[1].trim())) {
                        arrRight.push(value[1].trim());
                        arrRight.sort(this.compareNumeric);
                    }
                });
                this.timeIntervals = [];
            },
            closeTimeChanger() {
                this.timeChangeSatus = 'disable';
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
                this.timeChangeSatus = 'active';
                this.setCurrentMonth();
                this.currentDate = event.target.getAttribute('date');
            },
            compareNumeric(a, b) {
                if (a > b) return 1;
                if (a == b) return 0;
                if (a < b) return -1;
            },
            addTime() {
                let timeVal = $('#left-time').val() + ' - ' + $('#right-time').val();
                this.timeIntervals.push(timeVal);
                this.timeIntervals.sort(this.compareNumeric);
                let leftValIndex = $('#left-time option:selected').attr('data-index');
                let rightValIndex = $('#right-time option:selected').attr('data-index');
                this.timeLeftSelectorVariables.splice(leftValIndex, 1);
                this.timeRightSelectorVariables.splice(rightValIndex, 1);
                console.log(this.timeIntervals);
            },
            delTime(event) {
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
                console.log(this.timeIntervals);
            },
            applyBtn() {
                let inputData = {
                    day: this.currentDate,
                    time: this.timeIntervals,
                    'method': 'addTimeIntervals'
                }
                let response = fetch('handle.php', {
                    method: 'Post',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(inputData)
                });

                this.closeTimeChanger();
            },
        }
    }
</script>

<style scoped>

</style>