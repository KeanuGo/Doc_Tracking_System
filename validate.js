
function ValidatePassword() {
	var name = document.getElementById("name").value;
	var uname = document.getElementById("uname").value;
	var email = document.getElementById("email").value;
	var pass = document.getElementById("password").value;
	var cpass = document.getElementById("cpassword").value;

	if(name != "" && uname != "" && email != "" && pass != "" && cpass != "") {
		if(pass.length < 7) {
			alert("Password too weak.");
			return false;
		}else if(pass != cpass) {
			alert("Password does not match. Try Again.");
			return false;
		}
		return true;
	}else{
		alert("All fields must filled up.");
		return false;
	}
}