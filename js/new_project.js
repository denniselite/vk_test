/**
 * Created by Денис on 23.06.14.
 */
$("#create_project").click(function () {

    var request = "./functions/new_project.php";
    var post_data = {
        'desc': $("#desc").val(),
        'price': $("#price").val()
    };
    $.ajax({
        crossDomain: true,
        url: request,
        type: 'POST',
        dataType: 'text',
        data: post_data,
        success: function (data) {
            if (data == "FALSE_AUTH"){
                alert('Вы должны войти в систему');
            }
            else if (data == "FALSE_WORKER"){
                alert('Добавлять проекты может только заказчик');
            }
            else if (data == "NO_MONEY"){
                alert('Недостаточно средств для создания проекта');
            } else {
                $("#money").empty();
                $("#money").append(data);
                $("#project_status").empty();
                $("#project_status").hide();
                $("#project_status").append("Проект успешно добавлен");
                $("#project_status").animate({opacity: "show"}, 1500);
                $("#project_status").animate({opacity: "hide"}, 1500);
            }
        }
    });
});