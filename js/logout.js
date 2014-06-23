/**
 * Created by Денис on 23.06.14.
 */

$("#logout_button").click(function(){
    var Cookies = document.cookie.split("; ");
    var n = Cookies.length;
    var time = new Date();
    time.setDate(time.getDate()-1);
    for (var i=0; i < n; i++) {
        var cookieName = Cookies[i].split("=")[0];
        document.cookie = cookieName + "=;expires=" + time.toGMTString();
    }
    var request = "./functions/logout.php";
    $.ajax({
        crossDomain: true,
        url: request,
        dataType: 'text',
        async: false,
        success: function(data){
            location.reload();
        }
    });
})