/**
 * Created by Денис on 23.06.14.
 */


$("#role").click(function (){
    var request = "./functions/change_role.php";
    var post_data = {};
    $.ajax({
        crossDomain: true,
        url: request,
        type: 'POST',
        dataType: 'text',
        data: post_data,
        success: function (data) {
            location.reload();
        }
    });
});