// QQ表情
(function($){  
	$.fn.qqFace = function(options){
		var defaults = {
			id : 'facebox',
			path : PUBLIC+'/common/images/emo/',
			assign : 'reply-textarea',
			tip : 'em_'
		};
		var option = $.extend(defaults, options);
		var assign = $('#'+option.assign);
		var id = option.id;
		var path = option.path;
		var tip = option.tip;
		var name = new Array(
		"呵呵","哈哈","吐舌","啊","酷","怒","开心","汗","泪","黑线",
		"鄙视","不高兴","真棒","钱","疑问","阴险","吐","咦","委屈","花心",
		"呼","笑眼","冷","太开心","滑稽","勉强","狂汗","乖","睡觉","惊哭",
		"生气","惊讶","喷","爱心","心碎","玫瑰","礼物","彩虹","星星月亮","太阳",
		"钱币","灯泡","茶杯","蛋糕","音乐","haha","胜利","大拇指","弱","OK"
		);
		
		
		if(assign.length<=0){
			alert('error');
			return false;
		}
		
		$(this).click(function(e){
			var strFace, labFace;
			if($('#'+id).length<=0){
				strFace ='<div id="'+id+'" class="edui-dropdown-menu edui-popup">' +
			    '<div class="edui-popup-body">' +
			     '<div class="j_emotion_container emotion_container">' +
			      '<div class="s_layer_content j_content ueditor_emotion_content">' +
			       '<div class="tbui_scroll_panel tbui_no_scroll_bar">' +
			        '<div class="tbui_panel_content j_panel_content clearfix">' +
			         '<table class="s_layer_table" cellpadding="1" cellspacing="1" align="center" style="border-collapse:collapse;" border="1" bordercolor="#e3e3e3">'+
			          '<tbody>' +
			           '<tr>';
				for(var i=1; i<=50; i++){
					strFace += '<td title="'+name[i-1]+'" class="s_face j_emotion" border="1" width="54" height="54" style="border-collapse:collapse;" align="center" bgcolor="#FFFFFF">' +
					'<a href="javascript:void(0)"><img src="'+path+i+'.png" onclick="$(\'#'+option.assign+'\').setCaret();$(\'#'+option.assign+'\').insertAtCaret(\'' + '[emo]' +name[i-1] + '[/emo]' +'\');" /></a></td>';
					if( i % 10 == 0 ) strFace += '</tr><tr>';
				}
				strFace += '</tr>' +
			          '</tbody>' +
		         '</table>' +
		        '</div>' +
		       '</div>' +
		      '</div>' +
		      '<div class="s_layer_tab">' +
		      '</div>' +
		     '</div>' +
		    '</div>' +
		   '</div>';
			}
			$(this).parents('.edui-toolbar').find('.edui-dialog-container').append(strFace);
			var offset = $(this).position();
			var top = offset.top + $(this).outerHeight();
			$('#'+id).css('top',top);
			$('#'+id).css('left',offset.left);
			$('#'+id).css('position','absolute');
			$('#'+id).show();
			e.stopPropagation();
		});
		

		$(document).click(function(){
			$('#'+id).hide();
			$('#'+id).remove();
		});
		
	};

})(jQuery);

jQuery.extend({ 
unselectContents: function(){ 
	if(window.getSelection) 
		window.getSelection().removeAllRanges(); 
	else if(document.selection) 
		document.selection.empty(); 
	} 
}); 
jQuery.fn.extend({ 
	selectContents: function(){ 
		$(this).each(function(i){ 
			var node = this; 
			var selection, range, doc, win; 
			if ((doc = node.ownerDocument) && (win = doc.defaultView) && typeof win.getSelection != 'undefined' && typeof doc.createRange != 'undefined' && (selection = window.getSelection()) && typeof selection.removeAllRanges != 'undefined'){ 
				range = doc.createRange(); 
				range.selectNode(node); 
				if(i == 0){ 
					selection.removeAllRanges(); 
				} 
				selection.addRange(range); 
			} else if (document.body && typeof document.body.createTextRange != 'undefined' && (range = document.body.createTextRange())){ 
				range.moveToElementText(node); 
				range.select(); 
			} 
		}); 
	}, 

	setCaret: function(){ 
		if(!$.browser.msie) return; 
		var initSetCaret = function(){ 
			var textObj = $(this).get(0); 
			textObj.caretPos = document.selection.createRange().duplicate(); 
		}; 
		$(this).click(initSetCaret).select(initSetCaret).keyup(initSetCaret); 
	}, 

	insertAtCaret: function(textFeildValue){ 
		var textObj = $(this).get(0); 
		if(document.all && textObj.createTextRange && textObj.caretPos){ 
			var caretPos=textObj.caretPos; 
			caretPos.text = caretPos.text.charAt(caretPos.text.length-1) == '' ? 
			textFeildValue+'' : textFeildValue; 
		} else if(textObj.setSelectionRange){ 
			var rangeStart=textObj.selectionStart; 
			var rangeEnd=textObj.selectionEnd; 
			var tempStr1=textObj.value.substring(0,rangeStart); 
			var tempStr2=textObj.value.substring(rangeEnd); 
			textObj.value=tempStr1+textFeildValue+tempStr2; 
			textObj.focus(); 
			var len=textFeildValue.length; 
			textObj.setSelectionRange(rangeStart+len,rangeStart+len); 
			textObj.blur(); 
		}else{ 
			textObj.value+=textFeildValue; 
		} 
	} 
});

$(function(){
	$('#emo_btn').qqFace();
});