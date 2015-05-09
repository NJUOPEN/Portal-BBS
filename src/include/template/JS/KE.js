       //创建kindeditor编辑器
   	    var editor;
		KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
				resizeType : 0,
				width:750,
				height:200,
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
		        if (!editor) return false;	//如果无法获取editor对象，那下面的代码也无法执行T_T
	        	editor.sync();
	        	var html = document.getElementById("editor_1").value;	//取得HTML内容 
	        	document.getElementById("content_1").value=html; 
				var action = document.getElementsByName("action"); //getElementsByName返回的是一个数组，因为不同元素的name可能相同
				var container;
				for(var i in action)
				{
					if (action[i].value=="doPost"){ //检测到“发表主题”动作
					
						container=document.getElementById("title");
						if (container.value=="")	//过滤前内容为空，说明未填写
						{
							alert("请填写帖子标题后再发表！");
							return false;
						}
						dealWithTitle(container);
						if (container.value=="")	//过滤后内容为空，说明填写的全部是非法内容⊙﹏⊙
						{
							alert("帖子标题含有无效内容，请重新填写后提交！");
							return false;
						}
						
						container=document.getElementById("content_1");
						//目前暂时允许发表主题的内容为空
						var content_1_empty;
						if (container.value=="") content_1_empty=true;
						else content_1_empty=false;						
				   		dealWithContent(container);
				   		if (container.value=="" && content_1_empty==false)
						{
							alert("帖子含有无效内容，请重新填写后提交！");
							return false;
						}
				   		break;
					}
					else if(action[i].value=="doReply"){ //检测到“发表回复”动作
						container=document.getElementById("content_1");
						if (container.value=="")
						{
							alert("帖子内容不能为空！");
							return false;
						}
				   		dealWithContent(container);
				   		if (container.value=="")
						{
							alert("帖子含有无效内容，请重新填写后提交！");
							return false;
						}
				   		break;					
					}
				}
				//alert(document.getElementById("content_1").value);//调试用，测试完成后请注释掉；下同
				//alert(document.getElementById("title").value);
	         	document.getElementById("postForm").submit()
	        	return true;
				
        }
		
		function dealWithContent(obj){	//过滤帖子内容中的有害标签；注意：此时所有"<"、">"已被编辑器转义
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
                str=str.replace(/&lt;(iframe.*?)&gt;(.*?)&lt;(\/iframe.*?)&gt;/gi," "); //过滤iframe标签
                str=str.replace(/&lt;(\/?iframe.*?)&gt;/gi," "); //过滤iframe标签
                
                str=str.replace(/(\s*$)/g,"");	//过滤结尾多余的空白字符
                
	            obj.value = str;
		}
		
		function dealWithTitle(obj){	//过滤帖子帖子中的有害标签
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
                str=str.replace(/&lt;(iframe.*?)&gt;(.*?)&lt;(\/iframe.*?)&gt;/gi," "); //过滤iframe标签
                str=str.replace(/&lt;(\/?iframe.*?)&gt;/gi," "); //过滤iframe标签
                     
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
                	str=str.replace(/<(img.*?)\/>/gi," "); //替换img标签
                	//TODO:添加更多可能导致标题样式被破坏的标签
                
                str=str.replace(/(^\s*)|(\s*$)/g, "");	//过滤开头或结尾多余的空白字符
                
	            obj.value = str;
		}
		
		function clearPost(){
			var container=document.getElementById('title');
			if (container)	container.value='';
			if (editor)	editor.text('');
		}
