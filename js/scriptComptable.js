
$(document).ready(function () {
    //modifier apperence des elements du tableau fiche frais a rembourser partie comptable
    $("tr").click(function () {
        var check = $(this).find("input[type='checkbox']");
        if(check.prop("checked")){
            check.prop("checked", false);
            $(this).removeClass('success').addClass('default');
        }else{
            check.prop("checked", true);
            $(this).removeClass('default').addClass('success');
        }        
    });
});

