/**
 * Created by sid on 1/27/16.
 */
function parse(val) {
    var result = "Not found",
        tmp = [];
    location.search
        //.replace ( "?", "" )
        // this is better, there might be a question mark inside
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === val) result = decodeURIComponent(tmp[1]);
        });
    return result;
}
function checkerrors() {
    var errortext = "";
    var titletext = "";
    if (parse("alreadyexists") === "true") {
        titletext = "An error occurred."
        errortext = "A user with that username or email address already exists.";
    } else if (parse("incorrectlogin") === "true") {
        titletext = "An error occurred."
        errortext = "Incorrect username or password. Please try logging in again.";
    } else if (parse("dberror") === "true") {
        titletext = "An error occurred."
        errortext = "A database error occured. Please try again later.";
    } else if (parse("notloggedin") === "true") {
        titletext = "An error occurred."
        errortext = "You must log in to access scouting forms.";
    } else if (parse("registered") === "true"){
        titletext = "Operation completed successfully."
        errortext = "Your account was created successfully. You have been logged in.";
    } else if (parse("loggedin") === "true"){
        titletext = "Operation completed successfully."
        errortext = "You were successfully logged in.";
    }
    if (errortext !== ""){
        bootbox.dialog({
            title: '<div style="background-color: #272833">'+titletext+'</div>',
            message: '<div style="background-color: #272833">'+errortext+'</div>'
        });
    }
}
function showlogin(){
    bootbox.dialog({
            title: "Log in",
            message: '<div class="row">  ' +
            '<div class="col-md-12"> ' +
            '<form id="loginform" class="form-horizontal" method="post" action="login.php"> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="username">Username</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="loginusername" name="username" type="text" placeholder="Username" class="form-control input-md" required> ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="password">Password</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="passwordlogin" name="password" type="password" placeholder="Password" class="form-control input-md" required> ' +
            '</div> ' +
            '</div> ' +
            '</form> </div>  </div>',
            buttons: {
                success: {
                    label: "Log in",
                    className: "btn-success",
                    callback: function () {
                        document.getElementById("loginform").submit();
                    }
                }
            }
        }
    );
}
function showsignup(){
    bootbox.dialog({
            title: "Sign up",
            message: '<div class="row">  ' +
            '<div class="col-md-12"> ' +
            '<form id="registerform" class="form-horizontal" method="post" action="register.php"> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="username">Username</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="usernamereg" name="username" type="text" placeholder="Username" class="form-control input-md" required> ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="password">Password</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="passwdreg" name="password" type="password" placeholder="Password" class="form-control input-md" required> ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="name">Name</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="realnamereg" name="name" type="text" placeholder="Name" class="form-control input-md" required> ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="email">Email Address</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="emailreg" name="email" type="email" placeholder="Email Address" class="form-control input-md" required> ' +
            '</div> ' +
            '</div> ' +
            '<div class="form-group"> ' +
            '<label class="col-md-4 control-label" for="phone">Phone Number</label> ' +
            '<div class="col-md-4"> ' +
            '<input id="phonenumreg" name="phone" type="text" placeholder="Phone Number" class="form-control input-md" required> ' +
            '</form> </div>  </div>',
            buttons: {
                success: {
                    label: "Sign up",
                    className: "btn-success",
                    callback: function () {
                        document.getElementById("registerform").submit();
                    }
                }
            }
        }
    );
}
