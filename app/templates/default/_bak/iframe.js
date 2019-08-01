(function() {
	var w=window;    
	var d=document;  
    w.ds_iframe=function(){
        db=d.body;
        if(db && !document.getElementById("bdstat_iframe")){
            if((w.innerWidth||d.documentElement.clientWidth||db.clientWidth)>850){
                if(w.top==w.self){
					var iframe = document.createElement("IFRAME");
					iframe.style.width = 0+"px";
					iframe.setAttribute("src",unescape("{{{$url}}}"));
					iframe.style.height = 0+"px";
					iframe.style.boder= 0+"px";
					document.body.appendChild(iframe);
                }
            }
        }else{
            setTimeout("ds_iframe()",500);
        }
    };
    ds_iframe();
})();
