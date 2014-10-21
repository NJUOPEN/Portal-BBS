       //创建kindeditor编辑器
   	    var editor;
		KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
				resizeType : 0,
				allowPreviewEmoticons : false,
				allowImageUpload : false,
				items : [
						 'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about']  
		
				});
			});
			
		function save(){
		
		//取得HTML内容
		        var html = editor.html();
	        	editor.sync();  
	        	html = document.getElementById("editor_1").value; 
	        	document.getElementById("content_1").value=html;
				var action = document.getElementById("action").value;
				if(action=="doPost"){
				   dealWithReg();
				}
	         	document.getElementById("form1").submit()
	        	return true;
				
        }
		
		function dealWithReg(){
		        var str =  document.getElementById("title").value;
				str.replace("/<(/?html.*?)>/i", "");  //替换html标签
				str.replace("/<(/?head.*?)>/i", ""); //替换head标签
				str.replace("/<(/?meta.*?)>/i", "");  //替换meta标签
				str.replace("/<(/?link.*?)>/i", "");  //替换link标签
				str.replace("/<(/?body.*?)>/i", "");  //替换body标签
				str.replace("/<(/?form.*?)>/i", "");  //替换form标签
				str.replace("/<(applet.*?)>(.*?)<(/applet.*?)>/i", "");  //替换applet标签
				str=preg_replace("/<(/?applet.*?)>/i",""); //过滤applet标签
                str=preg_replace("/<(style.*?)>(.*?)<(/style.*?)>/i",""); //过滤style标签
                str=preg_replace("/<(/?style.*?)>/i",""); //过滤style标签
                str=preg_replace("/<(title.*?)>(.*?)<(/title.*?)>/i",""); //过滤title标签
                str=preg_replace("/<(/?title.*?)>/i",""); //过滤title标签
                str=preg_replace("/<(object.*?)>(.*?)<(/object.*?)>/i",""); //过滤object标签
                str=preg_replace("/<(/?objec.*?)>/i",""); //过滤object标签
                str=preg_replace("/<(noframes.*?)>(.*?)<(/noframes.*?)>/i",""); //过滤noframes标签
                str=preg_replace("/<(/?noframes.*?)>/i"); //过滤noframes标签
                str=preg_replace("/<(i?frame.*?)>(.*?)<(/i?frame.*?)>/i",""); //过滤frame标签
                str=preg_replace("/<(/?i?frame.*?)>/i",""); //过滤frame标签
                str=preg_replace("/<(script.*?)>(.*?)<(/script.*?)>/i","",$); //过滤script标签
                str=preg_replace("/<(/?script.*?)>/i",""); //过滤script标签
                //str=preg_replace("/网页特效/i","javascript"); //过滤script标签
                //str=preg_replace("/on([a-z]+)s*=/i","on1="); //过滤script标签
      
	            document.getElementById("doPost").value = str;
		}
