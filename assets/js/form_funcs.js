/**
 * Created by sid on 1/27/16.
 */
function updateForm(robotdata){
    for(var index in robotdata) {
        if(index !== 'liftlow' && index !== 'lifthigh' && index !== 'robottype') {
            document.getElementById(index).value = robotdata[index];
        } else if(index !== 'robottype') {
            if(robotdata[index]==1){
                document.getElementById(index).checked = true;
            } else {
                document.getElementById(index).checked = false;
            }
        }
    }
}

function asyncGetRobotData() {
    var xmlhttp;
    var teamnum = document.getElementById('teamnumber').value;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var robotdata = JSON.parse(xmlhttp.responseText);
            if(robotdata != null) {
                bootbox.dialog({
                    title: 'That robot already has been scouted.',
                    message: 'A '+robotdata['robottype']+' robot under that team number already has scouting data. To update data, select Update.',
                    buttons: {
                        update: {
                            label: "Update",
                            className: "btn-primary",
                            callback: function () {
                                updateForm(robotdata);
                            }
                        },
                        cancel: {
                            label: "Cancel",
                            className: "btn-danger"
                        }
                    }
                });
            }
        }
    };
    xmlhttp.open("GET", "get_robot_data.php?teamnum="+teamnum, true);
    xmlhttp.send();
}
