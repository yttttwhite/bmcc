function checkAll(e,inputClass){
	var checkBoxName = e.id;
	var currnetStatus = e.name;
	var dom = document.getElementById(checkBoxName);
	
	if(currnetStatus == 'checked-yes'){
		dom.innerHTML = "";
		dom.name = "checked-no"
		$(inputClass).iCheck('uncheck');
	}else{
		dom.innerHTML = '<i class="fa fa-check fa-lg"></i>';
		dom.name = "checked-yes"
		$(inputClass).iCheck('check');
	}
}

function icheckSelectAll(e,icheckClass){
	var dom = document.getElementById(e.id);
	var currnetStatus = e.name;
	
	if(currnetStatus == 'checked'){
		dom.name = "unchecked"
		$(icheckClass).iCheck('uncheck');
	}else{
		dom.name = "checked"
		$(icheckClass).iCheck('check');
	}
}