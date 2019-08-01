//原位置：api.genFuChuangWrapper
wrap.style._position = "absolute";
wrap.style._bottom = "0px";
wrap.style._top = "expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight- this.offsetHeight-(parseInt(this.currentStyle.marginBottom,10)||15)));";
