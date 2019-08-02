var bmap = {
	status: false,
	map: '',
    point: '',
    overlays: [],
    overlaysCache: [],
    myPolygon: '',
    myOverlay: [],
    drawingManager: '',
    styleOptions: {
        strokeColor: "#FF5A5F", //边线颜色。
        fillColor: "#FFFFFF", //填充颜色。当参数为空时，圆形将没有填充效果。
        strokeWeight: 3, //边线的宽度，以像素为单位。
        strokeOpacity: 0.9, //边线透明度，取值范围0 - 1。
        fillOpacity: 0.5, //填充的透明度，取值范围0 - 1。
        strokeStyle: 'solid' //边线的样式，solid或dashed。
    },
	
	init: function(){
        if (this.status) {
            return;
        }else{
			this.status = true;
            this.map 	= new BMap.Map('map');
            this.point 	= new BMap.Point(116.413554, 39.911013);
            var map 	= this.map;
            var styleOptions = this.styleOptions;
            map.centerAndZoom(this.point, 13);
            map.enableScrollWheelZoom();
			
			var mapStyle = [
						          {
						                    "featureType": "land",
						                    "elementType": "all",
						                    "stylers": {
						                              "color": "#e8e0d8"
						                    }
						          },
						          {
						                    "featureType": "water",
						                    "elementType": "all",
						                    "stylers": {
						                              "color": "#73b6e5"
						                    }
						          },
						          {
						                    "featureType": "green",
						                    "elementType": "all",
						                    "stylers": {
						                              "color": "#c8df9f"
						                    }
						          },
						          {
						                    "featureType": "highway",
						                    "elementType": "geometry.fill",
						                    "stylers": {
						                              "color": "#f9cb9c"
						                    }
						          },
						          {
						                    "featureType": "arterial",
						                    "elementType": "geometry.fill",
						                    "stylers": {
						                              "color": "#eeeeee"
						                    }
						          }
						];
			map.setMapStyle({
			  styleJson:mapStyle
			});
			
            //实例化鼠标绘制工具
            this.drawingManager = new BMapLib.DrawingManager(map, {
                isOpen: false, 				//是否开启绘制模式
                enableDrawingTool: true, 	//是否显示工具栏
                drawingToolOptions: {
                    anchor: BMAP_ANCHOR_TOP_RIGHT,	//位置
                    offset: new BMap.Size(5, 5), 	//偏离值
                    scale: 0.7, 	//工具栏缩放比例
                    drawingModes : [
			            //BMAP_DRAWING_MARKER,
			            BMAP_DRAWING_CIRCLE,
			            //BMAP_DRAWING_POLYLINE,
			            BMAP_DRAWING_POLYGON,
			            BMAP_DRAWING_RECTANGLE
			         ]
                },
                circleOptions: styleOptions, 		//圆的样式
                polylineOptions: styleOptions, 	//线的样式
                polygonOptions: styleOptions, 		//多边形的样式
                rectangleOptions: styleOptions 		//矩形的样式
            });
            //添加鼠标绘制工具监听事件，用于获取绘制结果
            this.drawingManager.addEventListener('overlaycomplete', bmap.overlaycomplete);
			
            /*加载一个已有的多边形*/
            if (this.myOverlay) {
                //this.loadMyOverlay();
            };
		}
    },
	
	mySetCenter:function(location){
		this.point = new BMap.Point(location.lng, location.lat);
		this.map.centerAndZoom(this.point, 14);
	},
	
	mySetCenterByCity:function(bmap){
		myCity = new BMap.LocalCity();
		myCity.get( function(result){bmap.map.setCenter(result.name);} );
	},
	
	mySetCenterByIp:function(){
		//根据IP获取位置
		var baiduIpLocationUrl = 'https://api.map.baidu.com/location/ip?ak=4BIXIpoEvRQXOqyb1G5XjNgb9unBWL8T&coor=bd09ll&callback=?';
		$.get(baiduIpLocationUrl,"",function(response){
			if(response.content.point){
				this.point = new BMap.Point(response.content.point.x, response.content.point.y);
				map.centerAndZoom(this.point, 12);
			}
		},'json');
	},
	
	search:function(){
		var local = new BMap.LocalSearch(this.map, {
			renderOptions:{ map:this.map }
		});
		var key = $("#baidu_map_search").val();
		if(key.length >= 2){
			local.search(key);
		}else{
			console.log(key);
		}
	},
	
	loadData:function(data){
		var overlays = data;
		for (var i = 0; i < overlays.length; i++) {
			if(overlays[i].type == 'polygon'){
				this.loadPolygon(overlays[i].path);
			}else if(overlays[i].type == 'circle'){
				this.loadCircle(overlays[i].center,overlays[i].radius);
			}
        }
	},
	
	loadPolygon:function(path){
		var points = new Array();
		for (var i = 0; i < path.length; i++) {
			points.push(new BMap.Point(path[i].lng, path[i].lat));
        }
		myPolygon = new BMap.Polygon(points, this.styleOptions);
		this.map.addOverlay(myPolygon);
		this.overlays.push(myPolygon);
		
		//创建右键菜单
		var overlayMenu=new BMap.ContextMenu();
		overlayMenu.addItem(new BMap.MenuItem('编辑',bmap.editTheOverlay.bind(myPolygon)));
		overlayMenu.addItem(new BMap.MenuItem('取消',bmap.exitEditTheOverlay.bind(myPolygon)));
		overlayMenu.addItem(new BMap.MenuItem('删除',bmap.removeTheOverlay.bind(myPolygon)));
		myPolygon.addContextMenu(overlayMenu);
		//双击退出编辑
        myPolygon.addEventListener("dblclick", function(e){
			e.currentTarget.disableEditing();
			return;
        });
	},
	
	loadCircle:function(center,radius){
		var center = new BMap.Point(center.lng, center.lat);
		myCircle = new BMap.Circle(center, radius,this.styleOptions);
		this.map.addOverlay(myCircle);
		this.overlays.push(myCircle);
		
		//创建右键菜单
		var overlayMenu=new BMap.ContextMenu();
		overlayMenu.addItem(new BMap.MenuItem('编辑',bmap.editTheOverlay.bind(myCircle)));
		overlayMenu.addItem(new BMap.MenuItem('取消',bmap.exitEditTheOverlay.bind(myCircle)));
		overlayMenu.addItem(new BMap.MenuItem('删除',bmap.removeTheOverlay.bind(myCircle)));
		myCircle.addContextMenu(overlayMenu);
		//双击退出编辑
        myCircle.addEventListener("dblclick", function(e){
			e.currentTarget.disableEditing();
			return;
        });
	},
	
	loadMyOverlay: function(){
        var map = this.map;
        this.clearAll();
        map.centerAndZoom(this.point, 12);
        myPolygon = new BMap.Polygon(this.myOverlay, this.styleOptions);
        this.myPolygon = myPolygon;
        try {
            //myPolygon.disenableEditing();
			//创建右键菜单
			var overlayMenu=new BMap.ContextMenu();
			overlayMenu.addItem(new BMap.MenuItem('编辑',bmap.editTheOverlay.bind(myPolygon)));
			overlayMenu.addItem(new BMap.MenuItem('取消',bmap.exitEditTheOverlay.bind(myPolygon)));
			overlayMenu.addItem(new BMap.MenuItem('删除',bmap.removeTheOverlay.bind(myPolygon)));
			myPolygon.addContextMenu(overlayMenu);
			//双击退出编辑
	        e.overlay.addEventListener("dblclick", function(e){
				e.currentTarget.disableEditing();
				return;
	        });
        } catch (e) {
			
        };
        map.addOverlay(myPolygon);
		bmap.overlays.push(myPolygon);
    },
	
	clearAll: function(){
        var map = this.map;
        var overlays = this.overlays;
        for (var i = 0; i < overlays.length; i++) {
			console.log(overlays[i]);
            map.removeOverlay(overlays[i]);
        }
        this.overlays.length = 0
        map.removeOverlay(this.myPolygon);
        this.myPolygon = '';
    },
	
	logAll: function(){
        var map = this.map;
        var overlays = this.overlays;
		console.log(overlays);
        for (var i = 0; i < overlays.length; i++) {
			var fillColor = overlays[i].getFillColor();
			if(fillColor.length>0){
				if($.isFunction(overlays[i].getCenter)){
					console.log('circle');
				}else{
					console.log('Polygon');
				}
			}else{
				console.log('Line');
			}
        }
		console.log(map.getCenter());
    },
	
	saveTag: function(){
        var map = this.map;
        var overlays = this.overlays;
		var areaInfos = new Array();
        for (var i = 0; i < overlays.length; i++) {
			var fillColor = overlays[i].getFillColor();
			if(fillColor.length>0){
				var areaInfo = {};
				if($.isFunction(overlays[i].getCenter)){
					areaInfo['type'] = 'circle';
					areaInfo['center'] = overlays[i].getCenter();
					areaInfo['radius'] = overlays[i].getRadius();
					areaInfos.push(areaInfo);
				}else{
					areaInfo['type'] = 'polygon';
					areaInfo['path'] = overlays[i].getPath();
					areaInfos.push(areaInfo);
				}
			}else{
				//console.log('Line');
			}
        }
		var areaStr = JSON.stringify(areaInfos);
		var centerStr = JSON.stringify(map.getCenter());
		var tagData = {};
		var tagId = $("#area_tag_id").val();
		if(tagId > 0){
			tagData.id = tagId;
		}
		tagData.name = $("#area_tag_name").val();
		tagData.area_valid_time = $("#area_valid_time").val();
		tagData.area_info = areaStr;
		tagData.area_center = centerStr;
		
		var saveUrl = "/baichuan_advertisement_manage/tag.area.save";
		$.post(saveUrl,tagData,function(response){
			if(response.status == 1){
				layer.msg(response.msg);
				if(response.id > 0){
					$("#area_tag_id").val(response.id);
				}
			}else{
				layer.msg(response.msg);
			}
		},'json');
    },
	
	showLatLon: function(a){
        var len = a.length;
        var s = '';
        var arr = [];
        for (var i = 0; i < len - 1; i++) {
            arr.push([a[i].lng, a[i].lat]);
            s += '<li>' + a[i].lng + ',' + a[i].lat + '<span class="red" title="删除" onclick="bmap.delPoint(' + i + ')">X</span></li>';
        }
        this.overlaysCache = arr;
        $("#panelWrap").html('<ul>' + s + '</ul>');
    },
	
	delPoint: function(i){
        if (this.overlaysCache.length <= 3) {
            alert('不能再删除, 请保留3个以上的点.');
            return;
        }
        this.overlaysCache.splice(i, 1);
        var a = this.overlaysCache;
        var newOverlay = [];
        for (var i in a) {
            newOverlay.push(new BMap.Point(a[i][0], a[i][1]));
        }
        this.myOverlay = newOverlay;
        //this.loadMyOverlay();
    },
	
	exitEditTheOverlay:function(e,ee,overlay){
		overlay.disableEditing();
	},
	
	editTheOverlay:function(e,ee,overlay){
		overlay.enableEditing();
	},
	
	removeTheOverlay:function(e,ee,overlay){
		this.map.removeOverlay(overlay);
		var index = bmap.overlays.indexOf(overlay);
		if(index > -1) {bmap.overlays.splice(index, 1);}
	},
	
	overlaycomplete: function(e){
        bmap.overlays.push(e.overlay);
        //e.overlay.enableEditing();
		
		//创建右键菜单
		var overlayMenu=new BMap.ContextMenu();
		overlayMenu.addItem(new BMap.MenuItem('编辑',bmap.editTheOverlay.bind(e.overlay)));
		overlayMenu.addItem(new BMap.MenuItem('取消',bmap.exitEditTheOverlay.bind(e.overlay)));
		overlayMenu.addItem(new BMap.MenuItem('删除',bmap.removeTheOverlay.bind(e.overlay)));
		e.overlay.addContextMenu(overlayMenu);
		//双击退出编辑
        e.overlay.addEventListener("dblclick", function(e){
			e.currentTarget.disableEditing();
			return;
        });
    },
	
	getOverLay: function(){
        var box = this.myPolygon ? this.myPolygon : this.overlays[this.overlays.length - 1];
        console.log(box.ia);
    },
	
    getCount: function(){
        var n = 0;
        if (this.myPolygon) {
            n++;
        };
        if (this.overlays) {
            n = n + this.overlays.length;
        };
        console.log(n);
    }
}