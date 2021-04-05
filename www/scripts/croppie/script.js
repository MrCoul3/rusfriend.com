jQuery(document).ready(function ($) {
    let basic;
    let user_id = localStorage.getItem('user_id');
    $('.add-photo').on('click', function () {
        $("#c_input24").trigger('click');
        return false;
    });

    $('.js-main-image').on('click', function () {
        console.log('js-main-image')
        basic.croppie('result', 'base64').then(function (html) {
            $.ajaxSetup({
                headers: {
                    //
                }
            });
            $.ajax({
                url: '/croppie.php',
                type: "POST",
                data: 'photo=' + html + "&photo_c=" + $('input[name="photo_c"]').val(),
                dataType: "json"
            })
            $('.arcticmodal-overlay').css('display', 'none');
            $('.arcticmodal-container').css('display', 'none');
            setTimeout(function () {
                $('.avatar').css('backgroundImage', 'url(' + '../../images/user-avatars/'+ user_id + '_min.png' + ')');
            },500)
        });
    });


    $("#c_input24").on('change', function () {
        let formData = new FormData();
        formData.append('file', $(this)[0].files[0]);
        formData.append('user_id', user_id);
        $.ajaxSetup({
            headers: {
                //headers
            }
        });
        $.ajax({
            url: '/croppie.php',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json"
        })
            .done(function (html) {
                if (html.status == "success") {
                    $('input[name="photo_c"]').val(html.file_max);
                    $('.profile_photo_i').attr('src', html.path_max);

                    basic = $('.profile_photo_i').croppie({
                        viewport: {
                            width: 200,
                            height: 200,
                            type: 'circle'
                        }
                    });

                    $('.profile-modal-photo').arcticmodal({
                        beforeOpen: function () {

                        },
                        afterClose: function () {
                            $('.profile_photo_i').croppie('destroy');
                        }
                    });
                }
            })
    });

});