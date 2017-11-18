
var err_color = "rgb(200,0,0)";

function ValidateEnrollment() {
	var name = document.getElementById("name").value;
	var uname = document.getElementById("uname").value;
	var email = document.getElementById("email").value;
	var pass = document.getElementById("password").value;
	var cpass = document.getElementById("cpassword").value;
	var emailExpression = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

	var email_warning = document.getElementById("email_warning");
	var pass_warning = document.getElementById("pass_warning");
	var cpass_warning = document.getElementById("cpass_warning");
	var all = document.getElementById("all");
	var space = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";

	if(name != "" && uname != "" && email != "" && pass != "" && cpass != "") {
		email_warning.innerHTML = "";
		pass_warning.innerHTML = "";
		cpass_warning.innerHTML = "";
		all.innerHTML = "";
		
		if(email.match(emailExpression)) {
			if(pass.length < 7) {
				pass_warning.innerHTML = space + "Password too weak";
				pass_warning.style.color = err_color;
				return false;
			}else if(pass != cpass) {
				cpass_warning.innerHTML = space + "Password does not match";
				cpass_warning.style.color = err_color;
				return false;
			}
			return true;
		}else{
			email_warning.innerHTML = space + "Invalid E-mail";
			email_warning.style.color = err_color;
			return false;
		}
	}else{
		all.innerHTML = "All fields must be filled.<br><br>";
		all.style.color = err_color;
		return false;
	}
}

function ValidateSignIn() {
	var username = document.getElementsByName("user")[0].value;
	var password = document.getElementsByName("pass")[0].value;
	var text = document.getElementsByClassName("text");

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

function ValidateAddDocCode() {
	var doc_code = document.getElementsByClassName("mytext foo")[0];
	var doc_name = document.getElementsByClassName("mytext foo")[1];
	
	if(doc_code.value == "" || doc_name.value == "") {
		doc_code.innerHTML = "";
		doc_name.innerHTML = "";
		if(doc_code.value == "") {
			doc_code.placeholder = "Enter Doc Code First!";
			doc_code.style.color = err_color;
		}
		if(doc_name.value == "") {
			doc_name.placeholder = "Enter Doc Name First!";
			doc_name.style.color = err_color;	
		}
		return false;
	} else {
		return true;
	}
}
