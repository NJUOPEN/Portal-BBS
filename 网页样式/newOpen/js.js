
function func1{             //登陆
     var loginName = document.getElementById("login-name").value;
	 var loginPassword = document.getElementById("login-password").value;
	 if(loginName=="123"&&loginPassword=="123456"){
	     document.getElementById("login-field-1").style.display="none";
		 document.getElementById("login-field-2").style.display="inline";
	 }
	 else{
	     alert("input error");
	 }
}

function func2{          //登出
    document.getElementById("login-field-1").style.display="inline";
	document.getElementById("login-field-2").style.display="none";
}

function func3{
    var d = document.getElementById("postList-div-mark-1");
	d.style.backgroundColor="black";
}