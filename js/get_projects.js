/**
 * Created by Денис on 23.06.14.
 */
var request = "./functions/get_projects.php";
var length;
var count_all = 0;
var count_my = 0;

function get_projects() {
    $.ajax({
        crossDomain: true,
        url: request,
        dataType: 'json',
        async: false,
        success: function (data) {
            if (count_all !== data.all.length) {
                for (var i = count_all; i < data.all.length; i++) {
                    var html_inner = "" +
                        "<tr>" +
                        "<td>" + data.all[i].id + "</td>" +
                        "<td>" + data.all[i].desc + "</td>" +
                        "<td>" + data.all[i].price + "</td>" +
                        "<td><input type='button' value='Выполнить' onclick='make_project(" + data.all[i].id + ")'></td>" +
                        "</tr>";
                    $("#projects_table").append(html_inner);
                }
                count_all = data.all.length;
            }

            if (count_my !== data.my_work.length) {
                for (var i = count_my; i < data.my_work.length; i++) {
                    var html_inner = "" +
                        "<tr>" +
                        "<td>" + data.my_work[i].id + "</td>" +
                        "<td>" + data.my_work[i].desc + "</td>" +
                        "<td>" + data.my_work[i].price + "</td>" +
                        "</tr>";
                    $("#my_projects").append(html_inner);
                }
                count_my = data.my_work.length;
            }
        }
    });
}

setInterval(get_projects(), 200);