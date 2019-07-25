$(function() {
//限制只能输入数字
	$.fn.numeral = function() {            
	  this.bind("keypress",function(e) {       
		var code = (e.keyCode ? e.keyCode : e.which);  //兼容火狐 IE   
		
		if(code == 46) {
			return code;
		}         
		return code >= 48 && code<= 57;       
	  });       
	  this.bind("blur", function() {       
		if (this.value.lastIndexOf(".") == (this.value.length - 1)) {       
			this.value = this.value.substr(0, this.value.length - 1);       
		} else if (isNaN(this.value)) {   
			this.value = "";       
		}       
	  });       
	  this.bind("paste", function() {       
		var s = clipboardData.getData('text');       
		if (!/\D/.test(s));       
		value = s.replace(/^0*/, '');       
		return false;       
	  });       
	  this.bind("dragenter", function() {       
		return false;       
	  }); 
			
	  this.bind("keyup", function() {            
	  });       
	}
});