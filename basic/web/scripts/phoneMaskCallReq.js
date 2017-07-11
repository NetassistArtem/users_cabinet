$("input#callrequestform-phone").focus(function(){
    alert('test');
    $("input#callrequestform-phone").inputmask("+380 (99) 999 99 99",{
        "onincomplete": function(){ alert('Поле -Телефон- заполнено не до конца'); }
    });

});

