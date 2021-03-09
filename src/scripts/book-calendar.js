$(document).ready(function () {
    if ($('main').hasClass("private-lesson") || $('main').hasClass("speaking-club")) {
        console.log('booking-calendar init');
//----------------------------------------------------------------
        let selectedTimeArray = []; // пришлось ввести, так как из 'data' вылезает [_ob_serever]
        let bookingCalendar = new Vue({
            el: '#booking-calendar',
            data: {
                month: new Date().getMonth(),
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
                // selectedTimeArray: [],
                enterSkype: false,
                validationSkype: false,
            },
            beforeMount: function () {
                Date.prototype.getWeek = function () {
                    var onejan = new Date(this.getFullYear(), 0, 1);
                    return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()) / 7);
                } // возвращает номер недели
                this.weekNumber = ((new Date()).getWeek() - 1);
                // console.log(this.weekNumber);
            },
            created: function () {
                if ((String(this.month + 1).length) == '1') {
                    this.currentMonth = 0 + String(this.month + 1);
                } else {
                    this.currentMonth = this.month + 1;
                }
            },
            mounted: function () {
                this.getIntervalsFromDB();
                this.lightingOfToday();
                this.changeStateOfItem();

            },
            updated: function () {
                this.getIntervalsFromDB();
                this.lightingOfToday();
                this.changeStateOfItem();
            },
            computed: {
            },
            methods: {
                DateOfMondayInWeek(year, weekNumber) {
                    for (var a = 1; ; a++) if ((new Date(year, 0, a)).getDay() == 1) break;
                    a += (weekNumber - 1) * 7;
                    return (new Date(year, 0, a))
                },
                weekCalendar: function () {
                    let numOfDayInMonth = new Date(this.year, this.month + 1, 0).getDate(); // число дней в текущем мес
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
                        if (i === new Date().getDate() && this.year === new Date().getFullYear() && this.month === new Date().getMonth()) {
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
                    console.log('w');
                    this.weekNumber--;
                    this.month = this.DateOfMondayInWeek(this.year, this.weekNumber).getMonth();
                    console.log(this.month);
                    console.log(this.weekNumber);
                    if (this.weekNumber === 0) {
                        this.weekNumber = 52
                        this.year--;

                    }
                },
                increase: function () {
                    this.weekNumber++;
                    this.month = this.DateOfMondayInWeek(this.year, this.weekNumber).getMonth();
                    console.log(this.weekNumber);
                    if (this.weekNumber === 52) {
                        this.weekNumber = 1;
                        this.year++;
                    }
                },
                // getCookie: function(name) {
                //     let matches = document.cookie.match(new RegExp(
                //         "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                //     ));
                //     return matches ? decodeURIComponent(matches[1]) : undefined;
                // },
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

                getIntervalsFromDB: function () {
                    $('.time-intrevals-elem ').each((k, val) => {
                        val.innerHTML = '';
                    });

                    axios.post('/handle.php', JSON.stringify({'method': 'getTimeIntervals'}))
                        .then((response) => {
                            // console.log(response.data);
                            let dataFromDB = response.data;
                            // console.log(dataFromDB[0]);
                            dataFromDB.forEach(function (dataFromDB, k) {
                                // console.log(dataFromDB.day); // ...7.03.2021...
                                $('.time-intrevals-elem ').each((k, val) => {
                                    // console.log(val.getAttribute('date'));
                                    let dateNumber = val;
                                    if (dataFromDB.day === dateNumber.getAttribute('date')) {
                                        // console.log(dataFromDB.time);
                                        let arr = dataFromDB.time.split(',');
                                        // console.log(arr);
                                        let str = arr.join('</div><div>');
                                        // console.log(str);
                                        // console.log(dateNumber.innerHTML);
                                        dateNumber.innerHTML = '<div>' + str + '</div>';
                                    }
                                });

                            })
                        });
                },
                chooseTime: function (event) {
                    // console.log(event.target);
                    let selectedTime = event.target;
                    if (selectedTime.className.includes('selected-time')) {
                        selectedTime.classList.remove('selected-time');
                    } else {
                        selectedTime.classList.add('selected-time');
                    }
                    // let selectedTimeArray = this.selectedTimeArray;
                    selectedTimeArray = [];
                    let userName = $('.user-login__elem--user-name').html();
                    let typeOfLesson = null;
                    if ($('.header-menu--private').hasClass('menu-item-active')) {
                        typeOfLesson = 'private';
                    } else {
                        typeOfLesson = 's-club';
                    }
                    $('.selected-time').each(function (k, val) {
                        let day = val.parentNode.getAttribute('date');
                        let time = val.innerHTML;
                        // console.log(val.parentNode.getAttribute('date') + val.innerHTML);
                        let obj = {
                            name: userName,
                            type: typeOfLesson,
                            day: day,
                            time: time,
                            payment: 'unpayed',
                            'method': 'bookEvent'

                        };
                        // console.log(obj)
                        if (day !== null && time !== '') {
                            selectedTimeArray.push(obj);
                        }
                    });
                    // console.log(array);
                    // this.selectedTimeArray = array.slice(0);
                },
                bookEvent: function () {
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
                                        } else {
                                            axios.post('/handle.php', JSON.stringify(selectedTimeArray))
                                            window.location.href = "payment.php";
                                        }
                                    });
                            }
                        })

                },

                sendSkype: function () {
                    // console.log($('.input-skype').val());
                    let skype = $('.input-skype');
                    if (skype.val().trim() === '') {
                        // console.log('empty');
                        this.validationSkype = true;
                    } else {
                        axios.post('/handle.php', JSON.stringify({'method': 'sendSkype', 'skype': skype.val()}))
                        this.enterSkype = false;
                    }
                },
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
                                // console.log(val[1]);
                                let userNameFromDB = val[1];
                                let dayFromDB = val[2];
                                let timeFromDB = val[3];
                                if (userNameFromDB === getCookie('name')) {
                                    timeInterval.each(function (k, val) {
                                        if ($(this).attr('date') === dayFromDB) {
                                            // console.log(timeFromDB);
                                            // console.log($(this).children())
                                            $(this).children().each(function (k,val) {
                                                // console.log(val.innerHTML);
                                                if (val.innerHTML === timeFromDB) {
                                                    val.classList.add('booked-for-this-user');
                                                    // console.log(val);
                                                }
                                            })
                                        }
                                    })
                                }
                                if (userNameFromDB !== getCookie('name')) {
                                    // console.log(userNameFromDB);
                                    timeInterval.each(function (k, val) {
                                        if ($(this).attr('date') === dayFromDB) {
                                            // console.log(timeFromDB);
                                            // console.log($(this).children())
                                            $(this).children().each(function (k,val) {
                                                // console.log(val.innerHTML);
                                                if (val.innerHTML === timeFromDB) {
                                                    val.classList.add('booked-for-other-users');
                                                    // console.log(val);
                                                }
                                            })
                                        }
                                    })
                                }

                            })
                        });
                },
            },
        });
//----------------------------------------------------------------
        function getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
    }
});

