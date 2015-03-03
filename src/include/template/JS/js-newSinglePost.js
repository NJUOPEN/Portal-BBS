
function post_login_then(){             //登陆
     var loginName = document.getElementById("post-login-name").value;
     var loginPassword = document.getElementById("post-login-password").value;
	 if(loginName=="NJUOPEN"&&loginPassword=="123456"){
	     document.getElementById("post-login-field-1").style.display = "none";
	     document.getElementById("post-login-field-2").style.display = "block";
	 }
	 else{
	     alert("账户或密码有误");
	     document.getElementById("login-name").value = "";
	     document.getElementById("login-password").value = "";
	 }
}

function post_logout_then(){          //登出
     document.getElementById("post-login-field-1").style.display="block";
     document.getElementById("post-login-field-2").style.display = "none";
     document.getElementById("post-login-name").value = "";
     document.getElementById("post-login-password").value = "";
}
