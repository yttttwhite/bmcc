<script type="text/javascript">
	$(document).ready(function(){
		$(".accordion h3[current=active]").addClass("active");
		$(".accordion .snav:not([current=active])").hide();

		$(".accordion h3").click(function(){
			$(this).next(".snav").slideToggle("fast")
			.siblings(".snav").slideUp("fast");
			$(this).toggleClass("active");
			$(this).siblings("h3").removeClass("active");
		});
		$(".checkall").change(function(){
			var ck=$(this).prop("checked");
			$(this).parents("table").find("input:checkbox").prop("checked",ck);
		});
		$(".accordion a").each(function(i,item){
			if(document.location.href.indexOf($(item).attr("href"))!=-1){
				$(item).html("<b>"+$(item).html()+"</b>");
				$(item).parents("ul").attr("current","active");
				$(item).parents("ul").parents("div").show();
				$(item).parents("ul").parents("div").prev().attr("current","active").addClass("active");
			}
		});

	});
</script>

<div class="accordion">
	<h2>数据中心</h2>
	<h3 class="bort ">广告位报表</h3>
	<div class="snav" style="display: none;">
		<ul>
			<li><a href="type=all" class="type" val="all">汇总</a></li>
			<li><a href="type=day" class="type" val="day">天</a></li>
			<li><a href="type=hour" class="type" val="hour">小时</a></li>
			<li><a href="type=area" class="type" val="area">地域</a></li>
			<li><a href="type=source" class="type" val="source">来源</a></li>
			<li><a href="type=media" class="type" val="media">媒体</a></li>
		</ul>
	</div>

{*
	<h3 class="bort ">地域报表</h3>
	<div class="snav" style="display: none;">
		<ul>
			<li><a href="/baichuan_advertisement_manage/dc.main.area?type=uid"><b>总数</b></a></li>
			<li><a href="/baichuan_advertisement_manage/dc.main.area?type=pid">广告计划</a></li>
			<li><a href="/baichuan_advertisement_manage/dc.main.area?type=gid">广告组</a></li>
			<li><a href="/baichuan_advertisement_manage/dc.main.area?type=adid">广告</a></li>
		</ul>
	</div>

	<h3 class="bort">媒体报表</h3>
	<div class="snav" style="display:none;">
		<ul>
			<li><a href="/baichuan_advertisement_manage/dc.main.host?type=uid"><b>总数</b></a></li>
			<li><a href="/baichuan_advertisement_manage/dc.main.host?type=pid">广告计划</a></li>
			<li><a href="/baichuan_advertisement_manage/dc.main.host?type=gid">广告组</a></li>
			<li><a href="/baichuan_advertisement_manage/dc.main.host?type=adid">广告</a></li>
		</ul>
	</div>
*}

</div>
