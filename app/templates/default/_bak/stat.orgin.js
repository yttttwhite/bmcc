(function (win, headVar) {

 var doc = win.document,
 domWaiters = [],
 queue      = [], 
 handlers   = {}, 
 assets     = {}, 
 isAsync    = "async" in doc.createElement("script") || "MozAppearance" in doc.documentElement.style || win.opera,
 isHeadReady,
 isDomReady,
 api     = win[headVar] = (win[headVar] || function () { api.ready.apply(null, arguments); }),
 PRELOADING = 1,
 PRELOADED  = 2,
 LOADING    = 3,
 LOADED     = 4;
 api.unique= Math.random()
 api.Info={};
 api.LogFlag=false;
 api._js="{{{$config->host->js}}}";
 api._log="{{{$config->host->log}}}";
 api._redirect="{{{$config->host->redirect}}}";
 api._ads="{{{$config->host->ads}}}";
 api._cms="{{{$config->host->cms}}}";
 api._third_req="{{{$config->set->third_req}}}";
 api._log_flag="{{{$config->set->log}}}";

if (isAsync) {
	api.load = function () {
		var args      = arguments,
		    callback = args[args.length - 1],
		    items    = {};

		if (!isFunction(callback)) {
			callback = null;
		}

		each(args, function (item, i) {
				if (item !== callback) {
				item             = getAsset(item);
				items[item.name] = item;

				load(item, callback && i === args.length - 2 ? function () {
					if (allLoaded(items)) {
					one(callback);
					}

					} : null);
				}
				});

		return api;
	};
} else {
	api.load = function () {
		var args = arguments,
		    rest = [].slice.call(args, 1),
		    next = rest[0];
		if (!isHeadReady) {
			queue.push(function () {
					api.load.apply(null, args);
					});

			return api;
		}            
		if (!!next) {
			each(rest, function (item) {
					if (!isFunction(item)) {
					preLoad(getAsset(item));
					}
					});
			load(getAsset(args[0]), isFunction(next) ? next : function () {
					api.load.apply(null, rest);
					});                
		}
		else {
			load(getAsset(args[0]));
		}

		return api;
	};
}
api.isOverIFrame=false;
api.js = api.load;
api.ready = function (key, callback) {
	if (key === doc) {
		if (isDomReady) {
			one(callback);
		}
		else {
			domWaiters.push(callback);
		}

		return api;
	}
	if (isFunction(key)) {
		callback = key;
		key      = "ALL";
	}
	if (typeof key !== 'string' || !isFunction(callback)) {
		return api;
	}
	var asset = assets[key];
	if (asset && asset.state === LOADED || key === 'ALL' && allLoaded() && isDomReady) {
		one(callback);
		return api;
	}

	var arr = handlers[key];
	if (!arr) {
		arr = handlers[key] = [callback];
	}
	else {
		arr.push(callback);
	}

	return api;
};
api.ready(doc, function () {

		if (allLoaded()) {
		each(handlers.ALL, function (callback) {
			one(callback);
			});
		}

		if (api.feature) {
		api.feature("domloaded", true);
		}
		});


/* private functions
 *********************/
function noop() {
}

function each(arr, callback) {
	if (!arr) {
		return;
	}

	// arguments special type
	if (typeof arr === 'object') {
		arr = [].slice.call(arr);
	}

	// do the job
	for (var i = 0, l = arr.length; i < l; i++) {
		callback.call(arr, arr[i], i);
	}
}
function is(type, obj) {
	var clas = Object.prototype.toString.call(obj).slice(8, -1);
	return obj !== undefined && obj !== null && clas === type;
}

function isFunction(item) {
	return is("Function", item);
}

function isArray(item) {
	return is("Array", item);
}

function toLabel(url) {
	var items = url.split("/"),
	    name = items[items.length - 1],
	    i    = name.indexOf("?");

	return i !== -1 ? name.substring(0, i) : name;
}

function one(callback) {
	callback = callback || noop;

	if (callback._done) {
		return;
	}

	callback();
	callback._done = 1;
}

function getAsset(item) {
	var asset = {};

	if (typeof item === 'object') {
		for (var label in item) {
			if (!!item[label]) {
				asset = {
				name: label,
				url : item[label]
				};
			}
		}
	}
	else {
		asset = {
		name: toLabel(item),
      		url : item
		};
	}
	var existing = assets[asset.name];
	if (existing && existing.url === asset.url) {
		return existing;
	}

	assets[asset.name] = asset;
	return asset;
}

function allLoaded(items) {
	items = items || assets;

	for (var name in items) {
		if (items.hasOwnProperty(name) && items[name].state !== LOADED) {
			return false;
		}
	}

	return true;
}


function onPreload(asset) {
	asset.state = PRELOADED;

	each(asset.onpreload, function (afterPreload) {
			afterPreload.call();
			});
}

function preLoad(asset, callback) {
	if (asset.state === undefined) {

		asset.state     = PRELOADING;
		asset.onpreload = [];

		loadAsset({ url: asset.url, type: 'cache' }, function () {
				onPreload(asset);
				});
	}
}

function load(asset, callback) {
	callback = callback || noop;

	if (asset.state === LOADED) {
		callback();
		return;
	}

	// INFO: why would we trigger a ready event when its not really loaded yet ?
	if (asset.state === LOADING) {
		api.ready(asset.name, callback);
		return;
	}

	if (asset.state === PRELOADING) {
		asset.onpreload.push(function () {
				load(asset, callback);
				});
		return;
	}

	asset.state = LOADING;

	loadAsset(asset, function () {
			asset.state = LOADED;
			callback();
			each(handlers[asset.name], function (fn) {
				one(fn);
				});
			if (isDomReady && allLoaded()) {
			each(handlers.ALL, function (fn) {
				one(fn);
				});
			}
			});
}
function loadAsset(asset, callback) {
	callback = callback || noop;

	var ele;
	if (/\.css[^\.]*$/.test(asset.url)) {
		ele      = doc.createElement('link');
		ele.type = 'text/' + (asset.type || 'css');
		ele.rel  = 'stylesheet';
		ele.href = asset.url;
	}
	else {
		ele      = doc.createElement('script');
		ele.type = 'text/' + (asset.type || 'javascript');
		ele.src  = asset.url;
	}

	ele.onload  = ele.onreadystatechange = process;
	ele.onerror = error;

	ele.async = false;
	ele.defer = false;

	function error(event) {
		event = event || win.event;
		ele.onload = ele.onreadystatechange = ele.onerror = null;
		callback();
	}

	function process(event) {
		event = event || win.event;
		if (event.type === 'load' || (/loaded|complete/.test(ele.readyState) && (!doc.documentMode || doc.documentMode < 9))) {
			ele.onload = ele.onreadystatechange = ele.onerror = null;
			callback();
		}
	}

	var head = doc['head'] || doc.getElementsByTagName('head')[0];
	head.insertBefore(ele, head.lastChild);
}

function domReady() {
	if (!doc.body) {
		win.clearTimeout(api.readyTimeout);
		api.readyTimeout = win.setTimeout(domReady, 50);
		return;
	}

	if (!isDomReady) {
		isDomReady = true;
		each(domWaiters, function (fn) {
				one(fn);
				});
	}
}

function domContentLoaded() {
	// W3C
	if (doc.addEventListener) {
		doc.removeEventListener("DOMContentLoaded", domContentLoaded, false);
		domReady();
	}

	// IE
	else if (doc.readyState === "complete") {
		doc.detachEvent("onreadystatechange", domContentLoaded);
		domReady();
	}
};

if (doc.readyState === "complete") {
	domReady();
}

// W3C
else if (doc.addEventListener) {
	doc.addEventListener("DOMContentLoaded", domContentLoaded, false);
	win.addEventListener("load", domReady, false);
}

// IE
else {
	doc.attachEvent("onreadystatechange", domContentLoaded);
	win.attachEvent("onload", domReady);
	var top = false;

	try {
		top = win.frameElement == null && doc.documentElement;
	} catch (e) { }

	if (top && top.doScroll) {
		(function doScrollCheck() {
		 if (!isDomReady) {
		 try {
		 top.doScroll("left");
		 } catch (error) {
		 win.clearTimeout(api.readyTimeout);
		 api.readyTimeout = win.setTimeout(doScrollCheck, 50);
		 return;
		 }
		 domReady();
		 }
		 })();
	}
}

setTimeout(function () {
		isHeadReady = true;
		each(queue, function (fn) {
			fn();
			});

		}, 300);

if (!window.console) window.console = {debug: function() {}};
api.debug=function(s){
	return;
	var p = '';
	if (typeof  s=== 'string') {
		p="msg="+s;
	}else if (typeof s === 'object'){
		for(var i in s){
			p+=i+"="+escape(s[i])+"&";
		}
	}else{
		p=s;
	}
	var logUrl = 'https://'+api._log+'/stat.log.test' + "?" +p+"&unique="+api.unique+"&rand="+Math.random() ;
	var img = new Image(1,1);
	img.src = logUrl ;
	img.onload = function(){return;}
}
api.getAd = function(sn){
	return sn;
}
api.set = function(o){
	for(var i in o){
		document.cookie=i+"="+o[i]+"; path=/; domain="+api.root();
	}

}
api.root = function(){
	var redomain = '';
	var domainArray      =     new Array("com" , "net" , "org"  , "gov" , "edu");
	var domains_array     =     document.domain.split('.');
	var domain_count      =     domains_array.length-1;
	var flag = false;
	if(domains_array[domain_count]=='cn'){
		for(i=0;i<domainArray.length;i++){
			if(domains_array[domain_count-1] == domainArray[i]){
				flag =true;
				break;
			}
		}
		if(flag==true){
			redomain = domains_array[domain_count-2]+"."+domains_array[domain_count-1]+"."+domains_array[domain_count];
		}else{
			redomain = domains_array[domain_count-1]+"."+domains_array[domain_count];
		}
	}else{
		redomain = domains_array[domain_count-1]+"."+domains_array[domain_count];
	}
	return redomain;
}
api.log_stat = function(){
	if(api.LogFlag==false){
		api.LogFlag=true;
		screenWidth = 0,
		screenHeight = 0,
		r = 0,
		logUrl = '';
		screenWidth = window.screen.width;
		screenHeight = window.screen.height;
		_screen=screenWidth+"x"+screenHeight
		sid= (typeof bcdata_stat_id!= 'undefined') ?bcdata_stat_id :0;
		r = Math.round( Math.random() * 2147483647 ) ;
		logUrl = 'https://'+api._log+'/stat.log' + "?" + r;
		logUrl += "&sid=" + sid+ "&screen=" + _screen + "&referer=" + escape(document.referrer)+"&url="+escape(document.location.href);
		api.js(logUrl,function(){
		});
		/*
		var img = new Image(1,1);
		img.onload = function(){
			//api.debug("log load ok");
		}
		img.onerror=img.onabort=function(){
			//api.debug("log load error");
		}
		img.src = logUrl ;
		*/
		//api.debug("log load start");
	}
}
api.cookie= {
getItem: function (sKey) {
			 return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
		 },
setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
			 if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) { return false; }
			 var sExpires = "";
			 if (vEnd) {
				 switch (vEnd.constructor) {
					 case Number:
						 sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
						 break;
					 case String:
						 sExpires = "; expires=" + vEnd;
						 break;
					 case Date:
						 sExpires = "; expires=" + vEnd.toUTCString();
						 break;
				 }
			 }
			 document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
			 return true;
		 },
removeItem: function (sKey, sPath, sDomain) {
				if (!sKey || !this.hasItem(sKey)) { return false; }
				document.cookie = encodeURIComponent(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + ( sDomain ? "; domain=" + sDomain : "") + ( sPath ? "; path=" + sPath : "");
				return true;
			},
hasItem: function (sKey) {
			 return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
		 },
keys: /* optional method: you can safely remove it! */ function () {
														   var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
														   for (var nIdx = 0; nIdx < aKeys.length; nIdx++) { aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]); }
														   return aKeys;
													   }
};
api.log= function(){
	if(api.cookie.getItem("bcdata_sid")!=null){
		api.log_stat();
		return;
	}
	//tanx
	var url = (typeof bcdata_cms_url!= 'undefined') ?bcdata_cms_url:"https://"+api._cms+"/cms_tanx";
	url+="?rand="+Math.random();
	var img = new Image(1,1);
	img.onload = function(){
		api.log_stat();
		//baidu
		var url = (typeof bcdata_cms_url!= 'undefined') ?bcdata_cms_url:"https://"+api._cms+"/cms_baidu";
		url+="?rand="+Math.random();
		var img2 = new Image(1,1);
		img2.src = url;
		//dratio
		var ex=['fututa','jiemeng88','zuojiaju','aibang','zhongjiu.cn','cntv.cn','yoyo-hd','111yao'];
		for(var i in ex){
			if(location.host.indexOf(ex[i])!==-1){
				return;
			}
		}
		var url = (typeof bcdata_cms_url!= 'undefined') ?bcdata_cms_url:"https://"+api._cms+"/cms_dratio";
		url+="?rand="+Math.random();
		var img3 = new Image(1,1);
		img3.src = url;
	}
	//img.onerror=img.onabort=function(){
	//	api.debug("cms load error["+this.src+"]");
	//}
	img.src = url;
	//api.debug("cms load start");


	//monitor
	var isM= (typeof bcdata_monitor!= 'undefined') ?bcdata_monitor:false;
	if(isM){
		this.ready(function(){api.monitor();});
	}
};
api.monitor=function(){
	var id="";
	var iframes = document.getElementsByTagName("iframe");
	if(iframes.length>0){
		for(var i =0;i<iframes.length;i++){
			iframes[i].onmouseover = function () {
				api.isOverIFrame = true;
			};
			iframes[i].onmouseout = function () {
				api.isOverIFrame = false;
				var t = top?top:window
					if(t)setTimeout(t.focus, 0);
			};
			var t = top?top:window;
			var id = iframes[i].getAttribute("id");
			var src = iframes[i].getAttribute("src");
			var w= iframes[i].getAttribute("width");
			var h= iframes[i].getAttribute("height");
			if (typeof window.attachEvent !== 'undefined') {
				t.attachEvent('onblur', function(){processIFrameClick(id,src,w,h);});
			}else if (typeof window.addEventListener !== 'undefined') {
				t.addEventListener('blur', function(){processIFrameClick(id,src,w,h);}, false);
			}
		}
	}



	function processIFrameClick(id,src,w,h) {
		if(api.isOverIFrame) {
			api.isOverIFrame = false;
			screenWidth = 0,
						screenHeight = 0,
						r = 0,
						logUrl = '';
			screenWidth = window.screen.width;
			screenHeight = window.screen.height;
			_screen=screenWidth+"x"+screenHeight
				sid= (typeof bcdata_stat_id!= 'undefined') ?bcdata_stat_id :0;
			r = Math.round( Math.random() * 2147483647 ) ;
			logUrl = 'https://'+api._log+'/stat.monitor' + "?" + r;
			logUrl += "&sid=" + sid+ "&screen=" + _screen + "&referer=" + escape(document.referrer)+"&url="+escape(document.location.href)+"&id="+id+"&src="+escape(src)+"&width="+w+"&height="+h;
			var img = new Image(1,1);
			img.src = logUrl ;
			img.onload = function(){return;}
			//if(typeof bcdata_cms_url!= 'undefined'){
			//	var img_cms = new Image(1,1);
			//	img_cms.src = bcdata_cms_url;
			//	img_cms.onload = function(){return;}
			//}
		}
		var t = top?top:window
		if(t)setTimeout(t.focus(), 0);
	}
}
})(window,"BCStat");
BCStat.log();

