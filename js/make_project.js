/**
 * Created by Денис on 23.06.14.
 */



function make_project(id){
    var request = "./functions/make_project.php";
    var post_data = {
        'id': id
    };
    $.ajax({
        crossDomain: true,
        url: request,
        type: 'POST',
        dataType: 'text',
        data: post_data,
        success: function (data) {
            if (data == "FALSE_WORKER"){
                alert('Только исполнитель может брать заказы');
            }
            else if (data == "FALSE_AUTH"){
                alert('Вы должны пройти авторизацию, чтобы выполнить заказ');
            } else {
                $("#row" + id).empty();
                var div_ok = "<td colspan='4' id='project_ok' class='project_ok'>Проект успешно выполнен!</td>";
                $("#row" + id).append(div_ok);
                $("#project_ok").fadeIn(1500);
                $("#project_ok").fadeOut(1500, function(){
                    $("#project_ok").empty();
                    $("#row" + id).hide();
                    $("#projects_table").empty();
                });

                $("#money").empty();
                $("#money").append(data);
            }
        }
    });
}