$(document).ready(function () {
    if ($("main").hasClass('payment')) {
        console.log('payment init');

        // ---- закрытие окна FAQ
        $('.payment-gateway-main__faq').click(() => {
            $('.faq').addClass('faq-active');
        })
        $('.close-btn').click(()=>{
            $('.faq').removeClass('faq-active');
        })
        //------------------------------------

        // --- confirm btn click
        $('.payment-gateway-main__confirm-btn').click( () => {
            $('.success-frame').addClass('success-frame-active');
            $('.payment-gateway').addClass('payment-gateway-hidden');
            $('.instruction__item--two').removeClass('instuction-active');
            $('.instruction__item--three').addClass('instuction-active');
            // confirmation становится 1
        })

    }
});