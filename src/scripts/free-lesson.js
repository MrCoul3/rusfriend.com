import axios from "axios";
$(document).ready(function () {
    if ($("main").hasClass('free-lesson')) {
        console.log('free-lesson init');
        // console.log(localStorage.getItem('status'));

        // --------- проверка
        axios.post('/handle.php ', JSON.stringify({'method': 'checkLoginOnBookedLesson'}))
            .then((response) => {
                if (response.data['success'] === false) {
                    $(location).attr('href', '/index.php');
                } else {
                    if (response.data['status_2'] !== 'new') {
                        $(location).attr('href', '/index.php');
                    }
                }
            })

    }
});