/**
 * Created by Денис on 23.06.14.
 */

var request = "./functions/get_projects.php";
var length;
var count_all = 0;
var count_my = 0;

function get_projects() {
    if ($("#projects_table").html() == ""){
        count_all = 0;
    }
    $.ajax({
        crossDomain: true,
        url: request,
        dataType: 'json',
        async: false,
        success: function (data) {
            if (count_all !== data.all.length) {
                for (var i = count_all; i < data.all.length; i++) {
                    var html_inner;
                    var project_project_btn = "" +
                        "<input class='make_project_button' type='button' value='Выполнить' onclick='make_project(" + data.all[i].id + ")'>";
                    if (data.my_id ===  data.all[i].author_id){
                        project_project_btn = "Мой проект";
                    }
                    if (i % 2 == 0) {
                        html_inner = "" +
                            "<tr style='background-color:#f1c40f;' id='row"+ data.all[i].id +"'>" +
                            "<td align='center'>" + data.all[i].id + "</td>" +
                            "<td>" + data.all[i].desc + "</td>" +
                            "<td align='center'>" + data.all[i].price + "</td>" +
                            "<td align='center'>" + project_project_btn + "</td>" +
                            "</tr>";
                    } else {
                        html_inner = "" +
                            "<tr id='row"+ data.all[i].id +"'>" +
                            "<td align='center'>" + data.all[i].id + "</td>" +
                            "<td>" + data.all[i].desc + "</td>" +
                            "<td align='center'>" + data.all[i].price + "</td>" +
                            "<td align='center'><input class='make_project_button' type='button' value='Выполнить' onclick='make_project(" + data.all[i].id + ")'></td>" +
                            "</tr>";
                    }
                    $("#projects_table").append(html_inner);
                }
                count_all = data.all.length;
            }

            if (count_my !== data.my_work.length) {
                for (var i = count_my; i < data.my_work.length; i++) {
                    var html_inner;
                    if (i % 2 == 0){
                        html_inner = "" +
                            "<tr style='background-color:#2ecc71;'>" +
                            "<td align='center'>" + data.my_work[i].id + "</td>" +
                            "<td>" + data.my_work[i].desc + "</td>" +
                            "<td align='center'>" + data.my_work[i].price + "</td>" +
                            "<td align='center'>" + data.my_work[i].role + "</td>" +
                            "</tr>";
                    } else {
                        html_inner = "" +
                            "<tr>" +
                            "<td align='center'>" + data.my_work[i].id + "</td>" +
                            "<td>" + data.my_work[i].desc + "</td>" +
                            "<td align='center'>" + data.my_work[i].price + "</td>" +
                            "<td align='center'>" + data.my_work[i].role + "</td>" +
                            "</tr>";
                    }
                    $("#my_projects").append(html_inner);
                }
                count_my = data.my_work.length;
            }
        }
    });
};

setInterval(get_projects, 300);