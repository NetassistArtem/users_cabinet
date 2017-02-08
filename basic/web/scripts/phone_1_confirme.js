

$(document).ready(function() {



//if($('.confirm-code-user-form').length){
  //  test();
//}

   // function test(){ // нажатие на кнопку - выпадает модальное окно

    $('.phone-1-change').click(function(event){ // нажатие на кнопку - выпадает модальное окно
        event.preventDefault();

    var url = 'phone-first-change-confirm';
  //  var clickedbtn = $(this);
    //var UserID = clickedbtn.data("userid");

    var modalContainer = $('#modal-user-code');
    var modalBody = modalContainer.find('.modal-body');
    modalContainer.modal({show:true});
    $.ajax({
        url: url,
        type: "GET",
        data: {/*'userid':UserID*/},
        success: function (data) {
            $('.modal-body').html(data);
            modalContainer.modal({show:true});
        }

    });
        $('.phone-1-change').submit();

});




/*
$(document).on("submit", '.call-request-form', function (e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: "submit-call-request",
        type: "POST",
        data: form.serialize(),
        success: function (result) {
            console.log(result);
            var modalContainer = $('#modal-contact');
            var modalBody = modalContainer.find('.modal-body');
            var insidemodalBody = modalContainer.find('.call-request-user-form');

            if (result == 'true') {

                insidemodalBody.html(result).hide(); //
                //$('#my-modal').modal('hide');

                $('div#success').removeClass("view_message");

           //     $('#success').html("<div>");

          //      $('#success > .alert-success').append("<strong>Вам перезвонят в ближайшее время</strong>");
            //    $('#success > .alert-success').append('</div>');

                setTimeout(function() { // скрываем modal через 4 секунды
                    $("#modal-contact").modal('hide');
                }, 3000);
            }
            else {

                modalBody.html(result).hide().fadeIn();
            }
        }
    });
});
*/
});
