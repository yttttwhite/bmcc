function report_dc_user(divid,para){
	$.getJSON('/dc.main.ReportUserChar',para, function (data) {
        var options ={
                chart: {
                    type: 'column'
                },
                title: {
                    text: '数据报表',
                    x: -20 //center
                },
                /*
                subtitle: {
                    text: 'Source: WorldClimate.com',
                    x: -20
                },
                */
                xAxis: {},
                yAxis: {
                    min: 0,
                    title: {
                        text: '统计数据'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '数'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{ }]
        };
		  options.series= data.data;
		  options.xAxis.categories= data.cate;
          $(divid).highcharts(options);

    });

}

function report_dc_plan(divid,para){
	$.getJSON('/dc.main.ReportPlanChar',para, function (data) {
        var options ={
                chart: {
                    type: 'column'
                },
                title: {
                    text: '数据报表',
                    x: -20 //center
                },
                /*
                subtitle: {
                    text: 'Source: WorldClimate.com',
                    x: -20
                },
                */
                xAxis: {},
                yAxis: {
                    min: 0,
                    title: {
                        text: '统计数据'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '数'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{ }]
        };
		  options.series= data.data;
		  options.xAxis.categories= data.cate;
          $(divid).highcharts(options);

    });

}
//获取广告计划top10数据默认以click为基准
function getPlanTop10(paras){
    $.get("/dc.main.ReportPlanTop10", paras, function(data){ 
            var lis = "";
            $.each(data,function(i,n){
                lis+="<li>" + j + ":" + data[i]['province'] +"</li>";   
                    
            });
    });
}
function getUserReportTable(paras){
    $.get("/dc.main.ReportUserTable",paras,function(data){
          $(".reportab").remove();
          $(".turnpage").remove();
          $(".mcon").append(data);
    });
}
function getPlanReportTable(paras){
    $.get("/dc.main.ReportPlanTable",paras,function(data){
          $(".reportab").remove();
          $(".turnpage").remove();
          $(".mcon").append(data);
    });
}
function getGroupReportTable(paras){
    $.get("/dc.main.ReportGroupTable",paras,function(data){
          $(".reportab").remove();
          $(".turnpage").remove();
          $(".mcon").append(data);
    });
}
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="https://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
	var ht = table.innerHTML;
	ht = ht.replace(/\<a.*?\>(.+?)\<\/a\>/g,'$1').replace(/\<t[dh].*?input.*?t[dh]\>/g,'');
    var ctx = {worksheet: name || 'Worksheet', table: ht}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
function map_report_dc_plan(divid,paras){
    $(divid).empty();
    $(".jvectormap-label").remove();
    $.getJSON("/dc.main.AjaxGetMapData",paras,function(data){
            $(divid).vectorMap({map: 'china_zh',
                                color: "#53FF53", //地图颜色B4B4B4
//                                onRegionOver:function(event,code){
//                                                $.each(data, function (i, items) {
//                                                    if (code == items.cha) {
//                                                        //label.html(items.name + items.des);
//                                                        alert(items.name + items.des);
//                                                    }
//                                                 });
//                                },
                                onLabelShow: function (event, label, code) {//动态显示内容
                                                if(data != null){
                                                    $.each(data, function (i, items) {
                                                        if (code == items.cha) {
                                                            label.empty();
                                                            label.html(items.name + items.des);
                                                        }
                                                     });
                                                }else{
                                                        label.empty();
                                                        label.html("data is null");
                                                    
                                                }
                                             }
                               });
//            $.each(data, function (i, item) {
//                    var str_arr=item.des.split("<br>");
//                    var click_num=str_arr[1].split(":")[1];
//                    if (click_num>0) {//动态设定颜色，此处用了自定义简单的判断
//                        var josnStr = "{" + item.cha + ":'#00FF00'}";
//                        $(divid).vectorMap('set', 'colors', eval('(' + josnStr + ')'));
//                    }
//            });
//            $('.jvectormap-zoomin').click(); //放大

    });
}
