
/*
$(window).resize(function () {

    var width = $('body').innerWidth();
    alert(width);

    if (width < 1000) {
        $('.test-22').removeClass('test-22').addClass('test-33');

    }

     });
     976
*/

function windowSize(){
    if ($(window).width() <= '976'){

        $('.account-data-block >div >div.col-sm-2').removeClass('col-sm-2').addClass('col-sm-4');
        $('.account-data-block >div >div.col-md-2').removeClass('col-md-2').addClass('col-md-4');
        $('.account-data-block >div >div.col-xs-2').removeClass('col-xs-2').addClass('col-xs-4');
    }
    if($(window).width() > '976'){

        $('.account-data-block >div >div.col-sm-4').removeClass('col-sm-4').addClass('col-sm-2');
        $('.account-data-block >div >div.col-md-4').removeClass('col-md-4').addClass('col-md-2');
        $('.account-data-block >div >div.col-xs-4').removeClass('col-xs-4').addClass('col-xs-2');
    }
}

$(window).on('load resize',windowSize);
