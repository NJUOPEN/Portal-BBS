
function login_then(){             //登陆
     var loginName = document.getElementById("login-name").value;
	 var loginPassword = document.getElementById("login-password").value;
	 if(/*loginName=="123"&&loginPassword=="123456"*/true){
	     document.getElementById("login-field-1").style.visibility = "hidden";
	     document.getElementById("login-field-2").style.visibility = "visable";
	 }
	 else{
	     alert("账户或密码有误");
	 }
}

function logout_then(){          //登出
    document.getElementById("login-field-1").style.display="inline";
	document.getElementById("login-field-2").style.display="none";
}

function click(){
    var d = document.getElementById("postList-div-mark-1");
	d.style.backgroundColor="black";
}