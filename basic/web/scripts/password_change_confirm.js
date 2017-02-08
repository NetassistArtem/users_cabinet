/**
 * Created by artem on 27.01.17.
 */
//$("#password-change-id").click(function(){
   // alert('test');
   // $("#modal").modal("show");
    //
//<? Yii::t("flash-message","change_message_confirm") ?>;
    function destroy_submit()
    {
       // $("#modal").modal("show");
        if (confirm('Bы уверены, что хотите изменить пароль?'))
            return true;
        else return false;
    }
//});