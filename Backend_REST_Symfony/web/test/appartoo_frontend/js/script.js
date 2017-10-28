$(function() {


    function hidall() {

        $("[class^=lista]").filter(function() {
            var num = this.className.slice(5,6);
            var $elem = $('.lista'+num);
            //            alert('the number is '+num)
            $('.lista'+num).hide();
            $('.group'+num).parent('li').removeClass( "active" )
        });
    }

    function show(num) {
        $('.lista'+num).show();
        $('.group'+num).parent('li').addClass('active');
        //            $('').removeClass( "myClass yourClass" )

    }


    $("[class^=group]").click(function() {
        var num = this.className.slice(5,6);
        hidall();
        //        alert('just')
        show(num);
    });


    // init
    hidall();
    show(1);

    $('.special').attr('id', 'your-id-value');


    $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

    $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

});
