window.onload=function(){
	
	function addMyEvent(obj,sEv,fn){
		if(obj.attachEvent){
			obj.attachEvent("on"+sEv,function(){
				fn.call(obj);
			})
		}else{
		
			obj.addEventListener(sEv,fn,false);
		}
	}

	function fnselected(obj){

		this.obj=obj;
		this.oSpan=this.obj.getElementsByTagName("span")[0];
		this.oUl=this.obj.getElementsByTagName("ul")[0];
		this.aLi=this.oUl.getElementsByTagName("li");
		this.arr=[];
		this.flag=true;
		var _this=this;
		this.oSpan.onclick=function(ev){
		
			var ev=ev||event;
			ev.cancelBubble=true;
			_this.oUl.style.display="block";
		}
		addMyEvent(document,"click",function(){
		
			_this.oUl.style.display = 'none';
		});
		for(var i=0;i<this.aLi.length;i++){
			
			this.aLi[i].onmouseover=function(){
				this.children[0].style.background="#1478dc";
			}
			this.aLi[i].onmouseout=function(){
				if (!this.selected) {
					this.children[0].style.background="";
				}
			}
			this.aLi[i].onclick=function(ev){
				var ev=ev||event;
				_this.fnClk(ev,this);
			};
		}
		
	}
	fnselected.prototype.fnClk=function(ev,t){
		if(ev.ctrlKey){
			
			if(!this.flag){
				for(var i=0;i<this.aLi.length;i++){
					this.aLi[i].children[0].style.background="";
					this.aLi[i].selected=false;
				}
				this.oSpan.innerHTML='';
				this.arr.length=0;
			}
			if(t.className==""){
				this.arr.push(t.children[0].innerHTML);
				t.className="active";
				
			}else{
				for(var i=0;i<this.arr.length;i++){
					if(this.arr[i]==t.children[0].innerHTML){
						this.arr.splice(i,1);
					}
				}
				t.className="";
			}
			if(!this.arr[0]){
				this.oSpan.innerHTML='请选择';
			}else{
				this.oSpan.innerHTML=this.arr.join(',');
			}
			this.flag=true;
			
		}else{
			
			this.flag=false;
			for(var i=0;i<this.aLi.length;i++){
				this.aLi[i].children[0].style.background="";
				this.aLi[i].className="";
				this.aLi[i].selected=false;
			}
			t.children[0].style.background="#eee";
			t.selected=true;
			this.oSpan.innerHTML=t.children[0].innerHTML;
		}
	}

	var oDiv=document.getElementById("zhuantai");
	var oDiv2=document.getElementById("leixing");
	var oDiv3=document.getElementById("jihua");
	new fnselected(oDiv);
	new fnselected(oDiv2);
	new fnselected(oDiv3);
}
