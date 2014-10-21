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
				var action = document.getElementsByName("action"); //getElementsByName返回的是一个数组，因为不同元素的name可能相同
				for(var i in action)
				{
					if (action[i].value=="doPost"){
						dealWithReg(document.getElementById("title"),true);
				   		dealWithReg(document.getElementById("content_1"));
				   		break;
					}
					else if(action[i].value=="doReply"){
						dealWithReg(document.getElementById("content_1"));
						break;						
					}
				}
				alert(document.getElementById("content_1").value);//调试用，测试完成后请注释掉；下同
				alert(document.getElementById("title").value);
	         	document.getElementById("form1").submit()
	        	return true;
				
        }
		
		function dealWithReg(obj,enhanced=false){
				if (!obj) return;
		        var str =  obj.value;
				str.replace("/<(/?html.*?)>/i", "");  //替换html标签
				str.replace("/<(/?head.*?)>/i", ""); //替换head标签
				str.replace("/<(/?meta.*?)>/i", "");  //替换meta标签
				str.replace("/<(/?link.*?)>/i", "");  //替换link标签
				str.replace("/<(/?body.*?)>/i", "");  //替换body标签
				str.replace("/<(/?form.*?)>/i", "");  //替换form标签
				str.replace("/<(applet.*?)>(.*?)<(/applet.*?)>/i", "");  //替换applet标签
				str.replace("/<(/?applet.*?)>/i",""); //过滤applet标签
                str.replace("/<(style.*?)>(.*?)<(/style.*?)>/i",""); //过滤style标签
                str.replace("/<(/?style.*?)>/i",""); //过滤style标签
                str.replace("/<(title.*?)>(.*?)<(/title.*?)>/i",""); //过滤title标签
                str.replace("/<(/?title.*?)>/i",""); //过滤title标签
                str.replace("/<(object.*?)>(.*?)<(/object.*?)>/i",""); //过滤object标签
                str.replace("/<(/?objec.*?)>/i",""); //过滤object标签
                str.replace("/<(noframes.*?)>(.*?)<(/noframes.*?)>/i",""); //过滤noframes标签
                str.replace("/<(/?noframes.*?)>/i"); //过滤noframes标签
                str.replace("/<(i?frame.*?)>(.*?)<(/i?frame.*?)>/i",""); //过滤frame标签
                str.replace("/<(/?i?frame.*?)>/i",""); //过滤frame标签
                str.replace("/<(script.*?)>(.*?)<(/script.*?)>/i",""); //过滤script标签
                str.replace("/<(/?script.*?)>/i",""); //过滤script标签
                //str=preg_replace("/网页特效/i","javascript"); //过滤script标签
                //str=preg_replace("/on([a-z]+)s*=/i","on1="); //过滤script标签
                
                if (enhanced)  //加强过滤，用于帖子标题等
                {                
                	str.replace("/<(div.*)>(.*?)<(/div.*)>/i",""); //替换div标签
                	str.replace("/<(/?div.*)>/i",""); //过滤div标签
                	str.replace("/<(span.*?)>(.*?)<(/span.*?)>/i",""); //替换span标签
                	str.replace("/<(/?span.*?)>/i",""); //过滤span标签
                	str.replace("/<(a.*?)>(.*?)<(/a.*?)>/i",""); //替换a标签
                	str.replace("/<(/?a.*?)>/i",""); //过滤a标签
                	str.replace("/<(font.*?)>(.*?)<(/font.*?)>/i",""); //替换font标签
                	str.replace("/<(/?font.*?)>/i",""); //过滤font标签
                	str.replace("/<(font.*?)>(.*?)<(/font.*?)>/i",""); //替换font标签
                	str.replace("/<(/?font.*?)>/i",""); //过滤font标签
                	str.replace("/<(table.*?)>(.*?)<(/table.*?)>/i",""); //替换table标签
                	str.replace("/<(/?table.*?)>/i",""); //过滤table标签
                	str.replace("/<(tr.*?)>(.*?)<(/tr.*?)>/i",""); //替换tr标签
                	str.replace("/<(/?tr.*?)>/i",""); //过滤tr标签
                	str.replace("/<(td.*?)>(.*?)<(/td.*?)>/i",""); //替换td标签
                	str.replace("/<(/?td.*?)>/i",""); //过滤td标签
                	str.replace("/<(ul.*?)>(.*?)<(/ul.*?)>/i",""); //替换ul标签
                	str.replace("/<(/?ul.*?)>/i",""); //过滤ul标签
                	str.replace("/<(li.*?)>(.*?)<(/li.*?)>/i",""); //替换li标签
                	str.replace("/<(/?li.*?)>/i",""); //过滤li标签
                	//TODO:添加更多可能导致标题样式被破坏的标签
                }
      
	            obj.value = str;
		}
