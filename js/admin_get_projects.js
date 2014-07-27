/**
 * Created by Денис on 24.06.14.
 */
var request = "./functions/admin_get_projects.php";
var length;
var count = 0;
var bgColors = ['#95a5a6','#bdc3c7'];

function admin_get_projects() {
    if ($("#projects_table").html() == ""){
        count = 0;
    }
    $.ajax({
        crossDomain: true,
        url: request,
        dataType: 'json',
        async: false,
        success: function (data) {
            if (count !== data.length) {
                for (var i = count; i < data.length; i++) {
                    var html_inner;
                    html_inner = "" +
                        "<tr style='background-color:" + bgColors[i % 2] + ";' id='row"+ data[i].id +"'>" +
                        "<td align='center'>" + data[i].id + "</td>" +
                        "<td>" + data[i].desc + "</td>" +
                        "<td align='center'>" + data[i].price + "</td>" +
                        "<td>" + data[i].author_name + "</td>" +
                        "<td>" + data[i].worker_name + "</td>" +
                        "<td align='center'>" +
//                            "<input class='make_project_button' type='button' value='Удалить' onclick='delete_project(" + data[i].id + ")'>" +
                        "</td>" +
                        "</tr>";
                    $("#projects_table").append(html_inner);
                }
                count = data.length;
            }
        }
    });
};

setInterval(admin_get_projects, 300);