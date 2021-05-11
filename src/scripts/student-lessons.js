import axios from "axios";

$(document).ready(function () {
    if ($('main').hasClass('student-lessons')) {
        console.log('student-lessons.js init')
        // let bookedGmtArray = JSON.parse(localStorage.bookedGmtArray);

        $('.content-elem').each((k, val) => {
            if ($(val).attr('confirmation') == 0 && $(val).attr('payment') === 'unpayed') {
                // console.log($(val).siblings('a'))
                $(val).addClass('unconfirmed');
                $(val).siblings('a').addClass('pay-btn-active');
            }
            if ($(val).attr('confirmation') == 1 && $(val).attr('payment') === 'unpayed') {
                $(val).addClass('unpaid');
                $(val).siblings('p').addClass('unpaid-lesson-active');
            }
            if ($(val).attr('confirmation') == 1 && $(val).attr('payment') === 'payed') {
                $(val).addClass('payed');
                $(val).siblings('span').addClass('payed-lesson-active');
            }
        })


        let zone = new Date().toString().split(' ')[5];
        let timeZone = 'GMT ' + zone.substring(3, 6) + ':00';
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

                        if (userNameFromDB === getCookie('name')) {
                            let timeZoneNum = timeZone.split(' ')[1].substring(0, 3);
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
                                    gmt: timeZone,
                                    bookingTime: ' ',
                                    'method': 'setToBooksTimeGMT'
                                };

                                bookedGmtArray.push(obj);
                            });
                        }
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
                            if (!localStorage.getItem('re')) {
                                localStorage.setItem('re', '1');
                                window.location.reload();
                            } else {
                                delete localStorage.re;
                                $('#preloader').css('display','none');
                            }
                        } else {
                            window.location.reload();
                        }
                    }  else {
                        $('#preloader').css('display','none');
                    }
                });
        },50);

        function getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
    }
});