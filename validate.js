var err_color = "rgb(200,0,0)";
var text = document.getElementsByClassName("text");

function ValidateEnrollment() {
	var name = document.getElementById("name").value;
	var uname = document.getElementById("uname").value;
	var email = document.getElementById("email").value;
	var pass = document.getElementById("password").value;
	var cpass = document.getElementById("cpassword").value;
	var emailExpression = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

	if(name != "" && uname != "" && email != "" && pass != "" && cpass != "") {
		if(email.match(emailExpression)) {
			if(pass.length < 7) {
				text[3].innerHTML = "Password too weak";
				text[3].style.color = err_color;
				return false;
			}else if(pass != cpass) {
				text[4].innerHTML = "Password does not match";
				text[4].style.color = err_color;
				return false;
			}
			return true;
		}else{
			text[1].innerHTML = "Invalid E-mail";
			return false;
		}
	}else{
		text[5].innerHTML = "All fields must be filled.";
		text[5].style.color = err_color;
		return false;
	}
}
/*
function DefaultText() {
	var tags = ["E-mail", "Username", "Password", "Confirm Password"];
	for(var x = 1; x < 6: x++) {
		document.getElementsByClassName("text")[x].innerHTML = tags[x];
	}
}*/

function ValidateSignIn() {
	var username = document.getElementsByName("user")[0].value;
	var password = document.getElementsByName("pass")[0].value;

	if(username == "" && password == "") {
		text[2].innerHTML = "Enter username and password.";
		text[2].style.color = err_color;
		return false;
	} else if(username == "") {
		text[2].innerHTML = "Input Username.";
		text[2].style.color = err_color;
		return false;
	} else if(password == "") {
		text[2].innerHTML = "Input Password.";
		text[2].style.color = err_color;
		return false;
	} else {
		return true;
	}
}
