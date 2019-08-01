function report(divid,para){
	$.getJSON('/report.main.data',para, function (data) {
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
                title: {
                    text: ''
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
        var chart =  $(divid).highcharts(options);

    });

}
var data_test = {
        id: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
        pv: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
        pc: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
        uv: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
        uc: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
        ipv: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
        ipc: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
        cost: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
    };
function report_echarts(divid,para){
	$.getJSON('/report.main.dataEcharts',para, function (data) {
        var default_data = {
            id: [''],
            pv: [],
            pc: [],
            uv: [],
            uc: [],
            ipv: [],
            ipc: [],
            cost: []
        }
        data = $.extend(default_data, data);
		options = {
		    title : {
		        text: '数据报表',
		    },
		    tooltip : {
		        trigger: 'axis'
		    },
		    legend: {
		        data:['PV(cpm)','PC(次)','UV(cpm)','UC(次)','IPV(cpm)','IPC(次)','花费(元)']
		    },
		    toolbox: {
		        show : true,
		        feature : {
		            mark : {show: true},
		            dataView : {show: true, readOnly: false},
		            magicType : {show: true, type: ['line', 'bar']},
		            restore : {show: true},
		            saveAsImage : {show: true}
		        }
		    },
		    calculable : true,
		    xAxis : [
		        {
		            type : 'category',
		            data : data.id//['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
		        }
		    ],
		    yAxis : [
		        {
		            type : 'value'
		        }
		    ],
		    series : [
		        {
		            name:'PV(cpm)',
		            type:'bar',
		            data:data.pv,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
		            markPoint : {
		                data : [
		                    {type : 'max', name: '最大值'},
		                    {type : 'min', name: '最小值'}
		                ]
		            },
		            markLine : {
		                data : [
		                    {type : 'average', name: '平均值'}
		                ]
		            }
		        },
		        {
		            name:'PC(次)',
		            type:'bar',
		            data:data.pc,//[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
		            markLine : {
		                data : [
		                    {type : 'average', name : '平均值'}
		                ]
		            }
		        },
                {
                    name:'UV(cpm)',
                    type:'bar',
                    data:data.uv,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    markPoint : {
                        data : [
                            {type : 'max', name: '最大值'},
                            {type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name: '平均值'}
                        ]
                    }
                },
                {
                    name:'UC(次)',
                    type:'bar',
                    data:data.uc,//[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                    markLine : {
                        data : [
                            {type : 'average', name : '平均值'}
                        ]
                    }
                },
                {
                    name:'IPV(cpm)',
                    type:'bar',
                    data:data.ipv,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    markPoint : {
                        data : [
                            {type : 'max', name: '最大值'},
                            {type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name: '平均值'}
                        ]
                    }
                },
                {
                    name:'IPC(次)',
                    type:'bar',
                    data:data.ipc,//[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                    markLine : {
                        data : [
                            {type : 'average', name : '平均值'}
                        ]
                    }
                },
		        {
		            name:'花费(元)',
		            type:'bar',
		            data:data.cost,//[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
		            //markPoint : {
		            //    data : [
		            //        {name : '年最高', value : 182.2, xAxis: 7, yAxis: 183, symbolSize:18},
		            //        {name : '年最低', value : 2.3, xAxis: 11, yAxis: 3}
		            //    ]
		            //},
		            markLine : {
		                data : [
		                    {type : 'average', name : '平均值'}
		                ]
		            }
		        }
		    ]
		};
		                    
		var myChart = echarts.init(document.getElementById(divid));
		myChart.setOption(options);

    });

}
