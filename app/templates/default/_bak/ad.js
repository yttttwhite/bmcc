var mim_sp = "{{{$sp}}}";
var mim_aid = "{{{$adid}}}";
var mim_uid = "{{{$adsl}}}";
var mim_src = "0";
(function(){
    var a = function(h, f){
        try {
            var d = document.createElement("span");
            d.innerHTML = h;
            api.writeO(d, f)
        } 
        catch (g) {
            document.write(h)
        }
    };
    var c = function(d, f){
        if (f) {
            f.appendChild(d);
            f.parentNode.appendChild(d)
        }
        else {
            var g = f || document.all || document.getElementsByTagName("*");
            var f = g[g.length - 1]
        }
        f.parentNode.appendChild(d)
    };
    var b = document.createElement("script");
    b.type = "text/javascript";
    b.src = "https://{{{$config->host->js}}}/main.js?ver={{{$config->version->main}}}&bidder={{{$bidder}}}";
    c(b)
})();
