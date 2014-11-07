
function func{
     var loginName = document.getElementById("login-name").value;
	 var loginPassword = document.getElementById("login-password").value;
	 if(loginName=="123"&&loginPassword=="123456"){
	     document.getElementById("login-field-1").style.display=none;
		 document.getElementById("login-field-2").style.display=inline;
	 }
	 else{
	     alert("input error");
	 }
}