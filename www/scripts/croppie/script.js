jQuery(document).ready(function ($) {
    let basic;
    let user_id = localStorage.getItem('user_id');
    $('.add-photo').on('click', function () {
        $("#c_input24").trigger('click');
        return false;
    });
    let path;
    let pathMax;
    function delAvatar() {
        $('.avatar').css('backgroundImage', 'url(../../images/user-avatars/user-ico.svg)');
        let response = fetch('/handle.php', {
            method: 'Post',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({'method': 'delAvatar', path: path, pathMax: pathMax})
        });
        response.then(function (data) {
            return data.json()
        }).then(function (data) {
            console.log(data)
        });
    }
    $('.del-photo').click(function () {
        // console.log(path);
        delAvatar();
    })

    $('.js-main-image').on('click', function () {
        // console.log('js-main-image')
        delAvatar();
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
            }).done(function (html) {
                console.log(html)
                path = html.path_mini;
                // pathMax = html.path_max;
                // console.log(html.path_mini) // /images/user-avatars/61_min.png
                if(html.status == "success") {
                    $('input[name="photo_i"]').val(html.file_mini);
                    // $('.perscab-photoedit-img img').attr('src',html.path_mini);
                    // $('.avatar').css('backgroundImage', 'url(' + '../../images/user-avatars/'+ user_id + '_min.png' + ')');
                    $('.avatar').css('backgroundImage', 'url(' + '../..' + html.path_mini + ')');
                    $('.user-login__elem--avatar').attr('src', html.path_mini);
                    $('.profile-modal-photo').arcticmodal('close');
                }
            })

            // $('.arcticmodal-overlay').css('display', 'none');
            // $('.arcticmodal-container').css('display', 'none');
            // console.log(data.avatar);
            // $('.avatar').css('backgroundImage', 'url(../../images/user-avatars/user-ico.svg)');
            // setTimeout(function () {
            //     console.log('1000')
            //     $('.avatar').css('backgroundImage', 'url(../../images/user-avatars/user-ico.svg)');
            // }, 1000)
            // setTimeout(function () {
            //     console.log('2000')
            //
            //     $('.avatar').css('backgroundImage', 'url(' + '../../images/user-avatars/'+ user_id + '_min.png' + ')');
            // }, 2000)


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
                console.log(html);
                pathMax = html.path_max;
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