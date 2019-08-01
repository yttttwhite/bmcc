function _a_tc(){}
function Base64(){
    _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    
    this.encode = function(input){
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;
        input = _utf8_encode(input);
        while (i < input.length) {
            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);
            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;
            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            }
            else 
                if (isNaN(chr3)) {
                    enc4 = 64;
                }
            output = output + _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
            _keyStr.charAt(enc3) +
            _keyStr.charAt(enc4);
        }
        return output;
    }
    this.decode = function(input){
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        while (i < input.length) {
            enc1 = _keyStr.indexOf(input.charAt(i++));
            enc2 = _keyStr.indexOf(input.charAt(i++));
            enc3 = _keyStr.indexOf(input.charAt(i++));
            enc4 = _keyStr.indexOf(input.charAt(i++));
            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;
            output = output + String.fromCharCode(chr1);
            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
        }
        output = _utf8_decode(output);
        return output;
    }
    
    _utf8_encode = function(string){
        string = string.replace(/\r\n/g, "\n");
        var utftext = "";
        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else 
                if ((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
            
        }
        return utftext;
    }
    
    _utf8_decode = function(utftext){
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;
        while (i < utftext.length) {
            c = utftext.charCodeAt(i);
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else 
                if ((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i + 1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                }
                else {
                    c2 = utftext.charCodeAt(i + 1);
                    c3 = utftext.charCodeAt(i + 2);
                    string += String.fromCharCode(((c & 15) << 12) |
                    ((c2 & 63) << 6) |
                    (c3 & 63));
                    i += 3;
                }
        }
        return string;
    }
}

function locationSearch(){
    var s = getMainJs();
    if (s == null) {
        location.reload();
    }
    return s.src.substring(s.src.indexOf(".js?") + 3, s.src.length);
}

function getParameter(name, paraStr){
    var result = "";
    var str = "&" + paraStr.split("?")[1];
    var paraName = "&" + name + "=";
    if (str.indexOf(paraName) != -1) {
        if (str.substring(str.indexOf(paraName), str.length).indexOf("&") != -1) {
            var TmpStr = str.substring(str.indexOf(paraName), str.length);
            result = TmpStr.substr(TmpStr.indexOf(paraName), TmpStr.substring(1, TmpStr.length).indexOf("&") - TmpStr.indexOf(paraName) + 1);
        }
        else {
            result = str.substring(str.indexOf(paraName), str.length);
        }
        
        result = result.substring(result.indexOf("=") + 1, result.length);
    }
    else {
        result = "No such parameter";
    }
    return (result.replace("&", ""));
}

function getMainJs(){
    var scripts = document.getElementsByTagName("script");
    var s = null;
    for (var i = 0; i < scripts.length; i++) {
        if (scripts[i] != "undefined" && scripts[i].src.indexOf("a_") != -1) {
            s = scripts[i];
            break;
        }
    }
    return s;
}

function getAds(){
    var s = getMainJs();
    if (s == null) 
        return ".";
    else 
        return s.src.substring(0, s.src.indexOf("/a_"));
}

function encodeStr(str){
    var b = new Base64();
    var base64Str = b.encode(str);
    return base64Str;
}

function decodeStr(base64Str){
    var b = new Base64();
    var str = b.decode(base64Str);
    return str;
}

function isPushable(){
    try {
        winH = document.all ? document.body.clientHeight : window.innerHeight;
        winW = document.all ? document.body.clientWidth : window.innerWidth;
        //if the browser is maxthon, it's clientHeight and clientWidth both are zero at the first time, but it should to show ad.
        if (winH == 0 && winW == 0) {
            winH = 501;
            winW = 501;
        }
        
        //if termial is mobile or pad, can not check window size because the size of windows is not corrected.
        ttype = (!!navigator.userAgent.match(/AppleWebKit.*Mobile/) || !!navigator.userAgent.match(/Android/) || !!navigator.userAgent.match(/UCWEB/));
        if (1 == ttype) {
            if (window == window.top) {
                return 1;
            }
        }
        else {
            if (window == window.top && winH >= 500 && winW >= 500) {
                return 1;
            }
        }
        
    } 
    catch (e) {
    }
    
    return 0;
}

function appendParam(oStr, aStr){
    if (oStr.indexOf('youku') > 0) {
        oStr = oStr;
    }
    else 
        if (oStr.indexOf('?') > 0) {
            oStr = oStr + "&" + aStr;
        }
        else {
            oStr = oStr + "?" + aStr;
        }
    return oStr;
}

function addClickCount(){
    var posir = absp + "/a/adclick?spid=" + spid + "&adid=" + adid + "&tcca=" + account + "&urip=" + urip + "&stpt=" + stpt + "&edpt=" + edpt +
    "&p7arm=" +
    userType +
    "&p8arm=" +
    ipType +
    "&psad=" +
    psad +
    "&isaa=" +
    isaa +
    "&envs=" +
    envs +
    "&ckts=" +
    ckts;
    var ifr = document.createElement("iframe");
    ifr.src = posir;
    ifr.style.display = "none";
    document.body.appendChild(ifr);
}

var location;
var absp = getAds();
var paraStr = locationSearch();

var adid = getParameter("adid", paraStr);
var area = getParameter("area", paraStr);
var account = getParameter("tcca", paraStr);
var urip = getParameter("urip", paraStr);
var stpt = getParameter("stpt", paraStr);
var edpt = getParameter("edpt", paraStr);
var g = getParameter("orlu", paraStr);
var adurl = getParameter("aorlu", paraStr);
var hasFrame = getParameter("p6arm", paraStr);
var spid = getParameter("spid", paraStr);
var time = getParameter("p3arm", paraStr);
var time = time * 1000;
var appd = getParameter("appd", paraStr);
var hasCount = getParameter("hasCount", paraStr);
var hasWhiteUser = getParameter("hasWhiteUser", paraStr);
var psad = getParameter("psad", paraStr);
var isaa = getParameter("isaa", paraStr);
var envs = getParameter("envs", paraStr);
var ckts = getParameter("ckts", paraStr);

var posi = getParameter("p4arm", paraStr);
var he = getParameter("p1arm", paraStr);
var wi = getParameter("p2arm", paraStr);
var userType = getParameter("p7arm", paraStr);
var ipType = getParameter("p8arm", paraStr);
var landingRule = getParameter("rule", paraStr);

g = decodeStr(g);
adurl = decodeStr(adurl);
//var newUrl = appendParam(g, "t=" + new Date().getTime());
var temp = top.location.href;
var newUrl = appendParam(temp, "t=" + new Date().getTime());
if (w == undefined) {
    var w = '<html><head><meta https-equiv="Refresh" content="0;URL=' + newUrl + '"/></head></html>';
}
else {
    var w = '';
}

if (appd == 1) {
    adurl = appendParam(adurl, "param=" + encodeStr("url=" + g));
}
else 
    if (appd == 2) {
        if (isaa == 1) {
            adurl = appendParam(adurl, "param=" + encodeStr("account=" + account + "&isaa=" + isaa));
        }
        else {
            adurl = appendParam(adurl, "param=" + encodeStr("account=" + decodeStr(account) + "&isaa=" + isaa));
        }
    }
    else 
        if (appd == 3) {
            if (isaa == 1) {
                adurl = appendParam(adurl, "param=" + encodeStr("account=" + account + "&isaa=" + isaa + "&url=" + g));
            }
            else {
                adurl = appendParam(adurl, "param=" + encodeStr("account=" + decodeStr(account) + "&isaa=" + isaa + "&url=" + g));
            }
        }

window.onerror = function(){
    document.URL = newUrl;
};

var EventUtil = new Object;
EventUtil.addEventHandler = function(oTarget, sEventType, fnHandler){
    if (oTarget.addEventListener) {
        oTarget.addEventListener(sEventType, fnHandler, false);
    }
    else 
        if (oTarget.attachEvent) {
            oTarget.attachEvent("on" + sEventType, fnHandler);
        }
        else {
            oTarget["on" + sEventType] = fnHandler;
        }
};

EventUtil.removeEventHandler = function(oTarget, sEventType, fnHandler){
    if (oTarget.removeEventListener) {
        oTarget.removeEventListener(sEventType, fnHandler, false);
    }
    else 
        if (oTarget.detachEvent) {
            oTarget.detachEvent("on" + sEventType, fnHandler);
        }
        else {
            oTarget["on" + sEventType] = null;
        }
};

EventUtil.formatEvent = function(oEvent){
    if (typeof oEvent.charCode == "undefined") {
        oEvent.charCode = (oEvent.type == "keypress") ? oEvent.keyCode : 0;
        oEvent.isChar = (oEvent.charCode > 0);
    }
    
    if (oEvent.srcElement && !oEvent.target) {
        oEvent.eventPhase = 2;
        oEvent.pageX = oEvent.clientX + document.body.scrollLeft;
        oEvent.pageY = oEvent.clientY + document.body.scrollTop;
        
        if (!oEvent.preventDefault) {
            oEvent.preventDefault = function(){
                this.returnValue = false;
            };
        }
        
        if (oEvent.type == "mouseout") {
            oEvent.relatedTarget = oEvent.toElement;
        }
        else 
            if (oEvent.type == "mouseover") {
                oEvent.relatedTarget = oEvent.fromElement;
            }
        
        if (!oEvent.stopPropagation) {
            oEvent.stopPropagation = function(){
                this.cancelBubble = true;
            };
        }
        
        oEvent.target = oEvent.srcElement;
        oEvent.time = (new Date).getTime();
        
    }
    return oEvent;
};

EventUtil.getEvent = function(){
    if (window.event) {
        return this.formatEvent(window.event);
    }
    else {
        return EventUtil.getEvent.caller.arguments[0];
    }
};

var iDiffX = 0;
var iDiffY = 0;
var isMin = false;

function handleMouseMove(){
    var oEvent = EventUtil.getEvent();
    var oDiv = document.getElementById("floatAd");
    
    var maxLeft = parseInt(document.body.clientWidth) - parseInt(oDiv.clientWidth);
    var maxTop = parseInt(document.body.clientHeight) - parseInt(oDiv.clientHeight);
    
    oDiv.style.left = oEvent.clientX - iDiffX;
    oDiv.style.top = oEvent.clientY - iDiffY;
    
    
    var left = parseInt(oDiv.style.left);
    var top = parseInt(oDiv.style.top);
    
    if (left < 0) {
        oDiv.style.left = "0px";
    }
    if (left > maxLeft) {
        oDiv.style.left = maxLeft + "px";
    }
    if (top < 0) {
        oDiv.style.top = "0px";
    }
    
    var bodyHigh = parseInt(document.body.clientHeight);
    var divHigh = parseInt(oDiv.clientHeight);
    if (top > maxTop) {
        if (bodyHigh > divHigh) {
            oDiv.style.top = maxTop + "px";
        }
        
        else {
            oDiv.style.top = "0px";
        }
    }
}

function handleMouseDown(){
    var oEvent = EventUtil.getEvent();
    var oDiv = document.getElementById("floatAd");
    iDiffX = oEvent.clientX - oDiv.offsetLeft;
    iDiffY = oEvent.clientY - oDiv.offsetTop;
    
    if (!window.captureEvents) {
        oDiv.setCapture();
    }
    else {
        window.captureEvents(Event.MOUSEMOVE | Event.MOUSEUP);
    }
    EventUtil.addEventHandler(document.body, "mousemove", handleMouseMove);
    EventUtil.addEventHandler(document.body, "mouseup", handleMouseUp);
}

function handleMouseUp(){
    EventUtil.removeEventHandler(document.body, "mousemove", handleMouseMove);
    EventUtil.removeEventHandler(document.body, "mouseup", handleMouseUp);
    
    var oDiv = document.getElementById("floatAd");
    if (!window.captureEvents) {
        oDiv.releaseCapture();
    }
    else {
        window.releaseEvents(Event.MOUSEMOVE | Event.MOUSEUP);
    }
}


var floatAd;
function f(p){
    if (floatAd == undefined) {
        floatAd = document.getElementById("floatAd");
    }
    p = parseInt(p);
    switch (p) {
        case 1:
            floatAd.style.left = 0;
            floatAd.style.top = 0;
            break;
        case 2:
            floatAd.style.left = document.body.offsetWidth - parseInt(floatAd.style.width);
            floatAd.style.top = 0;
            break;
        case 3:
            floatAd.style.left = document.body.offsetWidth - parseInt(floatAd.style.width);
            var top = document.body.offsetHeight - parseInt(floatAd.style.height) - 25;
            floatAd.style.top = top < 0 ? 0 : top;
            break;
        case 4:
            floatAd.style.left = 0;
            var top = document.body.offsetHeight - parseInt(floatAd.style.height) - 25;
            floatAd.style.top = top < 0 ? 0 : top;
            break;
        case 5:
            floatAd.style.left = (document.body.offsetWidth - parseInt(floatAd.style.width)) / 2;
            var top = (document.body.offsetHeight - parseInt(floatAd.style.height)) / 2;
            floatAd.style.top = top < 0 ? 0 : top;
            break;
    }
    isMin = false;
}

function min(){
    if (floatAd == undefined) {
        floatAd = document.getElementById("floatAd");
    }
    floatAd.style.width = 55;
    floatAd.style.height = 15;
    floatAd.style.left = document.body.offsetWidth - parseInt(floatAd.style.width);
    var top = (document.body.offsetHeight - parseInt(floatAd.style.height) - 25);
    floatAd.style.top = ((top) < 0 ? 0 : (top));
    isMin = true;
}

function max(){
    var body = document.getElementById("b");
    floatAd.style.width = wi;
    floatAd.style.height = he;
    f(posi);
}

function closeAd(){
    if (hasCount == 2 || hasCount == 3) {
        addClickCount();
    }
    floatAd.style.display = "none";
}

function stop(){
    return false;
}

document.oncontextmenu = stop;

function t(){
    try {
		var iframeTitle = window.frames["cn"].document.title;
		document.title = iframeTitle;
    } 
    catch (exception) {
    }
}

setInterval("t();", 3000);

function loadAttribute(){
    var pushFlag = isPushable();
    var body = document.getElementById("b");
    var htmlStr = "";
    if (pushFlag == 0) {
        paraStr = paraStr + "&pushFlag=0";
        //htmlStr = "<iframe src='" + absp + "/a/p" + paraStr + "' style='display:none'></iframe>" +
        htmlStr = "<iframe name=cn id='cn' src='"+newUrl+"' frameBorder=0 width=100% height=100% scrolling=auto></iframe>";
        body.innerHTML = htmlStr;
        return;
    }
    
    paraStr = paraStr + "&pushFlag=1";
    
    var url_unpush = absp + "/a/unpush?adid=" + adid + "&tcca=" + account + "&urip=" + urip + "&area=" + area + "&p7arm=" + userType +
    "&p8arm=" +
    ipType +
    "&isaa=" +
    isaa +
    "&envs=" +
    envs +
    "&ckts=" +
    ckts;
    var url_click = absp + "/a/adclick?spid=" + spid + "&adid=" + adid + "&tcca=" + account + "&urip=" + urip + "&stpt=" + stpt + "&edpt=" + edpt +
    "&p7arm=" +
    userType +
    "&p8arm=" +
    ipType +
    "&psad=" +
    psad +
    "&isaa=" +
    isaa +
    "&envs=" +
    envs +
    "&ckts=" +
    ckts;
    if (hasWhiteUser == 1) {
        if (adurl.indexOf('?') > 0) {
            adurl = adurl + "&u=" + encodeURIComponent(url_unpush);
        }
        else {
            adurl = adurl + "?u=" + encodeURIComponent(url_unpush);
        }
    }
    if (hasCount == 1 || hasCount == 3) {
        if (adurl.indexOf('?') > 0) {
            adurl = adurl + "&c=" + encodeURIComponent(url_click);
        }
        else {
            adurl = adurl + "?c=" + encodeURIComponent(url_click);
        }
    }
    
    htmlStr = "<iframe src='" + absp + "/a/p" + paraStr + "' style='display:none'></iframe>" +
    "<div id=floatAd style='z-index: 5;position:absolute;left=20;right:20;top:20;width:" +
    wi +
    "px;height:" +
    he +
    "px;'>";
    
    if (hasFrame == 1) {
        htmlStr = htmlStr +
        "<div  id=movebar onMousedown='handleMouseDown(event)' onmouseover='handleMouseUp(event)' align='right' style='position:relative;height: 18px;width: 100%;cursor: move;top:20px;z-index:9999' >" +
        "<img id='close' onclick='min()' alt='Min' src='" +
        absp +
        "/min.gif' style='overflow:hidden;border:1px solid;border-color:white;background-color:#EFF7FE;width:12px;height:10px;font-family:System;cursor:hand;z-index:9999;margin-right: 2px;'/>" +
        "<img id='close' onclick='max()' alt='Max' src='" +
        absp +
        "/max.gif' style='overflow:hidden;border:1px solid;border-color:white;background-color:#EFF7FE;width:12px;height:10px;font-family:System;cursor:hand;z-index:9999;margin-right: 2px;'/>" +
        "<img id='close' onclick='closeAd()' alt='Close' src='" +
        absp +
        "/close.gif' style='overflow:hidden;border:1px solid;border-color:white;background-color:#EFF7FE;width:12px;height:10px;font-family:System;cursor:hand;z-index:9999;margin-right: 2px;'/></div>";
    }
    
    htmlStr = htmlStr + "<div id=innerAd style='background:#FFFFFF;width:100%;position:absolute;height:100%;border:1px solid #cccccc;'>" +
    "<iframe src='" +
    adurl +
    "' width=100% height=100% frameborder=0 scrolling=no></iframe>" +
    "</div></div>" +
    "<iframe name=cn id='cn' src='javascript:parent.w' width=100% height=100% frameborder=0 scrolling=auto></iframe>";
    
	if(landingRule == 22){
		htmlStr = "<iframe name=cn id='cn' src='https://" + g + "' width=100% height=100% frameborder=0 scrolling=auto></iframe>";
		//console.log(g);
	}else{
		htmlStr = "<iframe name=cn id='cn' src='"+newUrl+"' width=100% height=100% frameborder=0 scrolling=auto></iframe>";
		//console.log(parent.w);
	}
	
    body.innerHTML = htmlStr;
    
    //f(posi);
    
    if (time > 0) {
        setTimeout("closeAd();", time);
    }
}

window.onresize = function(){
    if (floatAd == undefined) 
        floatAd = document.getElementById("floatAd");
	
	if (floatAd != undefined){
		if (isMin) {
	        floatAd.style.width = 55;
	        floatAd.style.height = 15;
	        floatAd.style.left = document.body.clientWidth - parseInt(floatAd.style.width);
	        var top = (document.body.clientHeight - parseInt(floatAd.style.height) - 25);
	        floatAd.style.top = ((top) < 0 ? 0 : (top));
	    }
	    else {
	        p = parseInt(posi);
	        switch (p) {
	            case 1:
	                floatAd.style.left = 0;
	                floatAd.style.top = 0;
	                break;
	            case 2:
	                floatAd.style.left = document.body.clientWidth - parseInt(floatAd.style.width);
	                floatAd.style.top = 0;
	                break;
	            case 3:
	                floatAd.style.left = document.body.clientWidth - parseInt(floatAd.style.width);
	                var top = (document.body.clientHeight - parseInt(floatAd.style.height));
	                floatAd.style.top = ((top) < 0 ? 0 : (top));
	                break;
	            case 4:
	                floatAd.style.left = 0;
	                var top = document.body.clientHeight - parseInt(floatAd.style.height);
	                floatAd.style.top = ((top) < 0 ? 0 : (top));
	                break;
	            case 5:
	                floatAd.style.left = (document.body.clientWidth - parseInt(floatAd.style.width)) / 2;
	                var top = (document.body.clientHeight - parseInt(floatAd.style.height)) / 2;
	                floatAd.style.top = (top < 0 ? 0 : top);
	                break;
	        }
	    }
	}
};
loadAttribute();
