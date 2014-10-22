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
						dealWithTitle(document.getElementById("title"));
				   		dealWithContent(document.getElementById("content_1"));
				   		break;
					}
					else if(action[i].value=="doReply"){
						dealWithContent(document.getElementById("content_1"));
						break;						
					}
				}
				//alert(document.getElementById("content_1").value);//调试用，测试完成后g请注释掉；下同
				//alert(document.getElementById("title").value);
	         	document.getElementById("form1").submit()
	        	return true;
				
        }
		
		function dealWithContent(obj){  
				if (!obj) return;
		        var str =  obj.value; 
				str=str.replace(/&lt;\/?html.*?&gt;/gi, " ");  //替换html标签
				str=str.replace(/&lt;\/?head.*?&gt;/gi, " ");  //替换head标签
				str=str.replace(/&lt;\/?meta.*?&gt;/gi, " ");   //替换meta标签
				str=str.replace(/&lt;\/?link.*?&gt;/gi, " ");  //替换link标签
				str=str.replace(/&lt;\/?body.*?&gt;/gi, " ");   //替换body标签
				str=str.replace(/&lt;\/?form.*?&gt;/gi, " ");  //替换form标签
				str=str.replace(/&lt;(applet.*?)&gt;(.*?)&lt;(\/applet.*?)&gt;/gi, " ");  //替换applet标签
				str=str.replace(/&lt;(\/?applet.*?)&gt;/gi," "); //过滤applet标签
                str=str.replace(/&lt;(style.*?)&gt;(.*?)&lt;(\/style.*?)&gt;/gi, " "); //过滤style标签
                str=str.replace(/&lt;(\/?style.*?)&gt;/gi," "); //过滤style标签
                str=str.replace(/&lt;(title.*?)&gt;(.*?)&lt;(\/title.*?)&gt;/gi," "); //过滤title标签
				str=str.replace(/&lt;(\/?title.*?)&gt;/gi," "); //过滤title标签
                str=str.replace(/&lt;(object.*?)&gt;(.*?)&lt;(\/object.*?)&gt;/gi," "); //过滤object标签
                str=str.replace(/&lt;(\/?object.*?)&gt;/gi," "); //过滤object标签
                str=str.replace(/&lt;(noframes.*?)&gt;(.*?)&lt;(\/noframes.*?)&gt;/gi," "); //过滤noframes标签
                str=str.replace(/&lt;(\/?noframes.*?)&gt;/gi," "); //过滤noframes标签
                str=str.replace(/&lt;(i?frame.*?)&gt;(.*?)&lt;(\/?frame.*?)&gt;/gi," "); //过滤frame标签
                str=str.replace(/&lt;(\/?i?frame.*?)&gt;/gi," "); //过滤frame标签
                str=str.replace(/&lt;(script.*?)&gt;(.*?)&lt;(\/script.*?)&gt;/gi," "); //过滤script标签
                str=str.replace(/&lt;(\/?script.*?)&gt;/gi," "); //过滤script标签
                //str=preg_replace("/网页特效/i","javascript"); //过滤script标签
                //str=preg_replace("/on([a-z]+)s*=/i","on1="); //过滤script标签
               
	            obj.value = str;
				alert(document.getElementById("content_1").value); //测试用，调试完成请注释掉
		}
		
		function dealWithTitle(obj){
		         if (!obj) return;
		        var str =  obj.value; 
				str=str.replace(/<\/?html.*?>/gi, " ");  //替换html标签
				str=str.replace(/<\/?head.*?>/gi, " ");  //替换head标签
				str=str.replace(/<\/?meta.*?>/gi, " ");   //替换meta标签
				str=str.replace(/<\/?link.*?>/gi, " ");  //替换link标签
				str=str.replace(/<\/?body.*?>/gi, " ");   //替换body标签
				str=str.replace(/<\/?form.*?>/gi, " ");  //替换form标签
				str=str.replace(/<(applet.*?)>(.*?)<(\/applet.*?)>/gi, " ");  //替换applet标签
				str=str.replace(/<(\/?applet.*?)>/gi," "); //过滤applet标签
                str=str.replace(/<(style.*?)>(.*?)<(\/style.*?)>/gi, " "); //过滤style标签
                str=str.replace(/<(\/?style.*?)>/gi," "); //过滤style标签
                str=str.replace(/<(title.*?)>(.*?)<(\/title.*?)>/gi," "); //过滤title标签
				str=str.replace(/<(\/?title.*?)>/gi," "); //过滤title标签
                str=str.replace(/<(object.*?)>(.*?)<(\/object.*?)>/gi," "); //过滤object标签
                str=str.replace(/<(\/?object.*?)>/gi," "); //过滤object标签
                str=str.replace(/<(noframes.*?)>(.*?)<(\/noframes.*?)>/gi," "); //过滤noframes标签
                str=str.replace(/<(\/?noframes.*?)>/gi," "); //过滤noframes标签
                str=str.replace(/<(i?frame.*?)>(.*?)<(\/?frame.*?)>/gi," "); //过滤frame标签
                str=str.replace(/<(\/?i?frame.*?)>/gi," "); //过滤frame标签
                str=str.replace(/<(script.*?)>(.*?)<(\/script.*?)>/gi," "); //过滤script标签
                str=str.replace(/<(\/?script.*?)>/gi," "); //过滤script标签
                //str=preg_replace("/网页特效/i","javascript"); //过滤script标签
                //str=preg_replace("/on([a-z]+)s*=/i","on1="); //过滤script标签
                     
                //加强过滤帖子标题					 
                	str=str.replace(/<(div.*)>(.*?)<(\/div.*)>/gi," "); //替换div标签
                	str=str.replace(/<(\/?div.*)>/gi," "); //过滤div标签
                	str=str.replace(/<(span.*?)>(.*?)<(\/span.*?)>/gi," "); //替换span标签
                	str=str.replace(/<(\/?span.*?)>/gi," "); //过滤span标签
                	str=str.replace(/<(a.*?)>(.*?)<(\/a.*?)>/gi," "); //替换a标签
                	str=str.replace(/<(\/?a.*?)>/gi," "); //过滤a标签
                	str=str.replace(/<(font.*?)>(.*?)<(\/font.*?)>/gi," "); //替换font标签
                	str=str.replace(/<(\/?font.*?)>/gi," "); //过滤font标签
                	str=str.replace(/<(font.*?)>(.*?)<(\/font.*?)>/gi," "); //替换font标签
                	str=str.replace(/<(\/?font.*?)>/gi," "); //过滤font标签
                	str=str.replace(/<(table.*?)>(.*?)<(\/table.*?)>/gi," "); //替换table标签
                	str=str.replace(/<(\/?table.*?)>/gi," "); //过滤table标签
                	str=str.replace(/<(tr.*?)>(.*?)<(\/tr.*?)>/gi," "); //替换tr标签
                	str=str.replace(/<(\/?tr.*?)>/gi," "); //过滤tr标签
                	str=str.replace(/<(td.*?)>(.*?)<(\/td.*?)>/gi," "); //替换td标签
                	str=str.replace(/<(\/?td.*?)>/gi," "); //过滤td标签
                	str=str.replace(/<(ul.*?)>(.*?)<(\/ul.*?)>/gi," "); //替换ul标签
                	str=str.replace(/<(\/?ul.*?)>/gi," "); //过滤ul标签
                	str=str.replace(/<(li.*?)>(.*?)<(\/li.*?)>/gi," "); //替换li标签
                	str=str.replace(/<(\/?li.*?)>/gi," "); //过滤li标签
                	//TODO:添加更多可能导致标题样式被破坏的标签
  
	            obj.value = str;
				alert(document.getElementById("title").value); //测试用，调试完成请注释掉
		}
