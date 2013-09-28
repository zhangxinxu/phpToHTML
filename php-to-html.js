/*!
 * php-to-html.js by zhangxinxu(.com) 2013-09-28
*/
var timerError = null, eleError = $("#error"), showError = function(txt) {
	timerError && clearTimeout(timerError);
	eleError.css("visibility", "visible").html(txt);
	timerError = setTimeout(function() {
		eleError.css("visibility", "hidden");	
	}, 3000);
};

var dirAddress = '';
$("#formFilelist").bind("submit", function() {
	var dir = $("#inputDir").val(), form = this;	
	!this.ajaxSubmit && $.ajax({
		url: this.action,
		type: this.method,
		dataType: "json",
		data: $(this).serialize(),
		success: function(json) {
			if (json.succ && json.data) {
				var html = '';
				$.each(json.data, function(index, name) {
					html = html + '<li><input type="checkbox" id="fileCheck'+ index +'" name="filename" value="'+ name +'" checked>' +
					'<label for="fileCheck'+ index +'">'+ name +'</label></li>';
				}); 
				if (html == '') {
					html = '<li>该文件下没有任何PHP页面</li>';	
				}
				$("#fileList").show();
				$("#nameList").html(html);
			} else {
				showError(json.msg || '抱歉，出现错误。');
			}
			form.ajaxSubmit = false;
		},
		error: function() {
			showError('文件获取失败！');
			form.ajaxSubmit = false;
		}
	});
	this.ajaxSubmit = true;
	dirAddress = dir;
	return false;	
});
$("#formConvert").bind("submit", function() {
	var eleSubmit = $(this).find("input[type='submit']"),
		eleCheckboxs = $(this).find("input[type='checkbox']");
	
	var arrFilename = [];
	eleCheckboxs.each(function() {
        if (this.checked) arrFilename.push(this.value);
    });
	
	$.ajax({
		url: this.action,
		type: this.method,
		dataType: "json",
		data: {
			dir: dirAddress,
			url: $("#inputUrl").val(),
			filename: arrFilename.join()
		},
		success: function(json) {
			if (json.succ) {
				$("#succList").show();	
				$("#previewLink").attr("href", dirAddress + "\\_html");
			} else if (json.data) {
				$("input[type=checked]").each(function() {
					if ($.inArray(this.value, json.data)) {
						this.parentNode.className = "failed";
					} else {
						this.parentNode.className = "success";
					}	
				});
			}
			eleSubmit.removeAttr("disabled");
		},
		error: function() {
			showError('文件转换失败！');
			eleSubmit.removeAttr("disabled");
		}
	});
	eleSubmit.attr("disabled", "disabled");
	return false;	
});