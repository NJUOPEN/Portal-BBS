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
	         	document.getElementById("form1").submit()
	        	return true;
				
        }