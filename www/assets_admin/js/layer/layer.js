function isFunction(fn) {
    return (!!fn&&!fn.nodename&&fn.constructor!=String&&fn.constructor!=RegExp&&fn.constructor!=Array&&/function/i.test(fn+""));
}

function layerGet(msg,url){
	var index = layer.confirm(msg, {btn: ['确认','取消'], shade: 0.8,shadeClose: true}, 
		function(){$.get(url,function(response){layer.msg(response);});}, 
		function(){layer.close(index);}
	);
}

function layerConfirm(msg,url,refresh){
	var index = layer.confirm(
			msg, 
			{btn: ['确认','取消'], shade: 0.8,shadeClose: true}, 
			function(){$.get(url,function(response){layer.msg(response);if (refresh) {window.location.replace(location.href);}});}, 
			function(){layer.close(index);}
	);
}

function layerLoad(url, refresh){
	$.get(url,function(response){layer.msg(response); if(refresh){window.location.replace(location.href);}});
}

function layerIframeNew(msg,url,width,height){
	width = width+'px';
	height = height+'px';
	
	layer.open({
	    type: 2,
	    title: msg,
	    shadeClose: true,
	    shade: 0.8,
	    area: [width, height],
	    content: url
	});
}

function layerWindow(msg,url,width,height){
	width = width+'px';
	height = height+'px';
	
	layer.open({
	    type: 2,
	    title: msg,
	    closeBtn: false,
	    shade: [0],
	    area: [width, height],
	    content: [url, 'no'], //iframe的url，no代表不显示滚动条
	});

}

function layerDom(selector){
	layer.open({
	    type: 1,
	    shade: false,
	    title: false, //不显示标题
	    content: $('.layer_notice'), //捕获的元素
	    cancel: function(index){
	        layer.close(index);
	        this.content.show();
	    }
	});
}

function layerHtml(html) {
	layer.open({
	    type: 1,
		shade: [0.5,'#000'],
		shadeClose: true,
		area: ['360px', '160px'],
	    title: false, //不显示标题
	    content: html
	});

}

//以前版本的
function lightBox(html) {
	layerHtml(html)
	return ;
	//弹出一个页面层
	$.layer({
		type: 1,
		title: false, //不显示默认标题栏
		shade: [0.5,'#000'],
		area: ['360px', '160px'],
		shadeClose: true,
		page: {html: html}
	});
}

function layerDivById(id){
	var dom = document.getElementById(id);
	var html = dom.innerHTML;
	
	//弹出一个页面层
	var layerIndex = $.layer({
		type: 1,
		title: false, //不显示默认标题栏
		shade: [0.5,'#000'],
		area: [dom.style.width, dom.style.height],
		shadeClose: true,
		page: {html: html}
	});
	
	return layerIndex;
}

function layerIframe(title, url, width, height){
	layerIframeNew(title, url, width, height);
	return;
	height = height+34;
	$.layer({
	    type: 2,
	    shadeClose: true,
	    title: [title, 'background:#0099CC;color:#FFFFFF;'],
	    closeBtn: [0, true],
	    shade: [0.6, '#000'],
	    border: [0],
	    offset: ['10%',''],
	    //area: ['1000px', ($(window).height() - 50) +'px'],
	    area: [width+'px', height+'px'],
	    iframe: {src: url}
	});
}

function layerConfirmGet(url,msg){
	layerConfirm(url, msg, true);
	return;

	$.layer({
	    area: ['auto','auto'],
	    offset: ['20%',''],
	    shade: [0.6, '#000'],
	    dialog: {
	        msg: msg,
	        btns: 2,                    
	        type: 4,
	        btn: ['确认','取消'],
	        yes: function(){
	            $.get(
	            		url,
	            		function(response){
	            			layer.msg(response, 1, 1);
	            			location.reload();
	            		}
	            	);
	        },
	        no: function(){
	        }
	    }
	});
}

function ShowDIV(thisObjID) {
	$("#BgDiv").css({ display: "block", height: $(document).height() });
	var yscroll = document.documentElement.scrollTop;
	//$("#" + thisObjID).css("top", "100px");
	$("#" + thisObjID).css("display", "block");
	//document.documentElement.scrollTop = 0;
	}

function closeDiv(thisObjID) {
	$("#BgDiv").css("display", "none");
	$("#" + thisObjID).css("display", "none");
	}