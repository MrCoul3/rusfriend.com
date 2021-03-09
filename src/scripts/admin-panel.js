$(document).ready(function () {

    if ($('main').hasClass("admin-main")) {
        console.log('admin-panel init');


        let mySchedule = new Vue({
            el: '#my-schedule',
            data: {
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
                timeChangeSatus: 'calendar-disable',
                currentDate: null,
                currentMonth: null,
                showPreloader: true,
                timeIsSet: false,
                dataFromDB: [],
            },

            mounted: function () {
                this.getIntervalsFromDB();
            },
            created: function () {
                this.showPreloader = false;
                if ((String(this.month + 1).length) == '1') {
                    this.currentMonth = 0 + String(this.month + 1);
                } else {
                    this.currentMonth = this.month + 1;
                }
            },
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
                    let timeInCell = event.target.closest('.calendar-table-day');
                    // console.log(timeInCell.childNodes[1].childElementCount)
                    if(timeInCell.childNodes[1].childElementCount === 0) {
                        this.timeIsSet = false;
                    } else {
                        this.timeIsSet = true;
                    }
                    console.log(this.timeIsSet);
                    let timeModul = document.querySelector('.time-changer-content__element--time-list-modul');
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
                                    // console.log(dateFromDb);
                                    // console.log(currDate);
                                    if (currDate === dateFromDb) {
                                        mass = timeFromDb.split(',');
                                        // console.log(timeFromDb.split(',')[0]);
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
                                            // console.log(massValue.trim().split(' - ')[0]);
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
                        console.log(timeVal);
                        this.timeIntervals.push(timeVal);
                        this.timeIntervals.sort(this.compareNumeric);
                        let leftValIndex = $('#left-time option:selected').attr('data-index');
                        let rightValIndex = $('#right-time option:selected').attr('data-index');
                        this.timeLeftSelectorVariables.splice(leftValIndex, 1);
                        this.timeRightSelectorVariables.splice(rightValIndex, 1);
                        console.log(this.timeIntervals);
                    }
                    console.log(this.timeIsSet);
                },
                delBtn() {
                    this.resetValues()
                    console.log(this.timeIntervals);
                },
                delTime(event) {
                    console.log(this.timeIsSet);
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
                    console.log(this.timeIntervals.length);
                    console.log(this.timeIntervals);
                    console.log(this.timeIsSet);
                    if (this.timeIsSet === true) {
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
                        this.getIntervalsFromDB();
                    }

                    else {
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

                    $('.calendar-table-day').each(function (k, val) {
                        let day = $(this);
                        let dayTime = day.find('.day-time')[0]
                        dayTime.innerHTML = '';
                    });
                    axios.post('/handle.php', JSON.stringify({'method': 'getTimeIntervals'}))
                        .then((response) => {
                            // console.log(response.data);
                            let data = response.data;
                            $('.calendar-table-day').each(function (k, val) {
                                let dateOfcell = $(this).attr('date');
                                let day = $(this);
                                data.forEach(function (val, k) {
                                    let dateFromDb = val.day;
                                    let timeFromDb = val.time;
                                    if (dateOfcell === dateFromDb) {
                                        let arrTime = timeFromDb.split(',');
                                        let str = arrTime.join('</span><span>');
                                        let dayTime = day.find('.day-time')[0];
                                        dayTime.innerHTML = '<span>' + str + '</span>';
                                    }
                                });
                            });
                        });
                },
                exitBtn() {
                    console.log('exit');
                },
            }
        });


    }
});



