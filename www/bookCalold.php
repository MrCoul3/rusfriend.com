<?php
// если gmt совпадают
// if (this.timeZone === gmtFromDb) {
//     str = arr.join('</div><div>');
//     dateNumber.innerHTML = '<div>' + str + '</div>';
//
// } else {
//     let prevDate = dateNumber.previousElementSibling;
//     arr.forEach((val, k) => {
//         let firstH = val.split('-')[0].split(':')[0];// 06
//         let firstM = val.split('-')[0].split(':')[1];// 00
//         let secondH = val.split('-')[1].split(':')[0]; // 07
//         let secondM = val.split('-')[1].split(':')[1]; // 30
//         let a = +firstH + delta; // 02
//         let b = +secondH + delta; //05
//
//         if (Math.sign(a) === -1) {
//             a = 24 + a;
//             if (Math.sign(b) === -1) {
//                 b = 24 + b;
//             }
//             gmt();
//
//             // axios.post('/handle.php', JSON.stringify({'method': 'getTimeIntervalsFromTempGMT'}))
//             //     .then((response) => {
//             //         let dataFromDB = response.data;
//             //         if (dataFromDB) {
//             //             if (dataFromDB.day === dateNumber.getAttribute('date')) {
//             //                 let arr = dataFromDB.time.split(',');
//             //                 str = arr.join('</div><div>');
//             //                 dateNumber.innerHTML = '<div>' + str + '</div>';
//             //             }
//             //         }
//             //     });
//
//             // если есть предыдущий день
//             if (prevDate) {
//                 prevDate.innerHTML = '<div>' + str + '</div>';
//                 // если предыдущий день воскресенье
//             } else {
//                 console.log(str);
//
//                 // axios.post('/handle.php', JSON.stringify({'method': 'setTimeIntervalsFromTempGMT'}))
//             }
//
//
//             // else {
//             //     let prevNum = +dateNumber.getAttribute('date').split('.')[0] - 1;
//             //     let prevMonth = +dateNumber.getAttribute('date').split('.')[1];
//             //     if (String(prevMonth).length < 2) {
//             //         prevMonth = '0' + prevMonth;
//             //     }
//             //     let prevYear = +dateNumber.getAttribute('date').split('.')[2];
//             //     console.log(prevNum+'.'+prevMonth+'.'+prevYear)
//             //     console.log()
//             //
//             //     $('.time-intrevals-elem').each(function (k, val) {
//             //         if ($(this).attr('date') === prevNum+'.'+prevMonth+'.'+prevYear) {
//             //             console.log($(this))
//             //             $(this).html('<div>' + str + '</div>');
//             //         }
//             //     })
//             //
//             // }
//
//         } else {
//             gmt();
//             dateNumber.innerHTML = '<div>' + str + '</div>';
//             if (prevDate !== null) {
//                     $(dateNumber).children().slice(0, prevDate.childElementCount).remove();
//             }
//
//         }
//
//         function gmt() {
//             if (String(a).length < 2) {
//                 a = '0' + a;
//             }
//             if (String(b).length < 2) {
//                 b = '0' + b;
//             }
//             let newTimeInterval = a + ':' + firstM + ' - ' + b + ':' + secondM;
//             newArr.push(newTimeInterval);
//             str = newArr.join('</div><div>');
//         }
//     });
// }
// console.log(str);
// console.log(dateNumber.innerHTML);