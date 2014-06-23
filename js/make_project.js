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
                alert('Проект успешно выполнен!');
                $("#row" + id).empty();
                $("#money").empty();
                $("#money").append(data);
            }
        }
    });
}