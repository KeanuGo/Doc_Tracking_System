
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
				alert("Password too weak.");
				return false;
			}else if(pass != cpass) {
				alert("Password does not match. Try Again.");
				return false;
			}
			return true;
		}else{
			alert("Invalid e-mail address!");
			return false;
		}
	}else{
		alert("All fields must filled up.");
		return false;
	}
}
