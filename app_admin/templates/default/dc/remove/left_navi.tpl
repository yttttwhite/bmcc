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
			if($(item).attr("href").indexOf(document.location.pathname)!=-1){
				console.log($(item));
				console.log($(item).parentsUntil("ul"));
				$(item).parentsUntil("ul").attr("current","active");
				console.log("D");
			}
		});

	});
</script>

<div class="accordion">
	<h2>数据中心</h2>
	<h3 class="bort ">广告位报表</h3>
	<div class="snav" style="display: none;">
		<ul>
			<li><a href="/dc.main.ad?type=uid"><b>总数</b></a></li>
			<li><a href="/dc.main.ad?type=pid">广告计划</a></li>
			<li><a href="/dc.main.ad?type=gid">广告组</a></li>
			<li><a href="/dc.main.ad?type=adid">广告</a></li>
		</ul>
	</div>

	<h3 class="bort ">地域报表</h3>
	<div class="snav" style="display: none;">
		<ul>
			<li><a href="/dc.main.area?type=uid"><b>总数</b></a></li>
			<li><a href="/dc.main.area?type=pid">广告计划</a></li>
			<li><a href="/dc.main.area?type=gid">广告组</a></li>
			<li><a href="/dc.main.area?type=adid">广告</a></li>
		</ul>
	</div>

	<h3 class="bort  active" current="active" onclick="location='/baichuan_advertisement_manage/admin.user.list'">媒体报表</h3>
	<div class="snav" style="display:block;" current="active">
		<ul>
			<li><a href="/dc.main.host?type=uid"><b>总数</b></a></li>
			<li><a href="/dc.main.host?type=pid">广告计划</a></li>
			<li><a href="/dc.main.host?type=gid">广告组</a></li>
			<li><a href="/dc.main.host?type=adid">广告</a></li>
		</ul>
	</div>

</div>
{*
      <ul>
        <span> DSP&nbsp;  <span>
        <ul>
            <li><a href="/dc.dsp">DSP竞价</a></li>
        </ul>
        <span> 媒体&nbsp;  <span>
      <ul>
        <li><a href="/dc.media">媒体收益</a></li>
        <li><a href="dc.mediaarea">地域 报表</a></li>
        <li><a href="dc.mediahour">小时 报表</a></li>
        <li><a href="dc.mediaflag">渠道 报表</a></li>
      </ul>
        <span> 广告位&nbsp;  <span>
      <ul>
        <li><a href="/dc.adv">详细广告位</a></li>
        <li><a href="dc.advarea">地域 报表</a></li>
        <li><a href="dc.advhour">小时 报表</a></li>
        <li><a href="dc.advflag">渠道 报表</a></li>
      </ul>
*}
