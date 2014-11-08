
function login_then(){             //登陆
     var loginName = document.getElementById("login-name").value;
	 var loginPassword = document.getElementById("login-password").value;
	 if(/*loginName=="NJUOPEN"&&loginPassword=="123456"*/true){
	     document.getElementById("login-field-1").style.display = "none";
	     document.getElementById("login-field-2").style.display = "block";
	 }
	 else{
	     alert("账户或密码有误");
	 }
}

function logout_then(){          //登出
    document.getElementById("login-field-1").style.display="block";
    document.getElementById("login-field-2").style.display = "none";
    document.getElementById("login-name").value = "";
    document.getElementById("login-password").value = "";
}

function click(i){
    var d = document.getElementsByClassName("postList-div-general-mark");
    d.style.backgroundColor = "rgb(0, 148, 255)";
    var c = document.getElementById("mark-2");
    c.style.backgroundColor = "rgb(202, 171, 171)";

}