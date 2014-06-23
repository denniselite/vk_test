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
            if (data == "OK") {
                alert('Проект успешно добавлен!');
            }
            else if (data == "FALSE_AUTH"){
                alert('Вы должны войти в систему');
            }
            else if (data == "FALSE_WORKER"){
                alert('Добавлять проекты может только заказчик');
            }
        }
    });
});