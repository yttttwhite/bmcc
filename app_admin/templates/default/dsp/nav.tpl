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

		});
</script>

<div class="accordion" style="margin: 0;">
	<h2>DSP管理</h2>
{*
	<h3 class="bort " {if $nav=="media"}current="active"{/if}>媒体管理</h3>
	<div class="snav" style="display:block;" {if $nav=="media"}current="active"{/if}>
		<ul>
			<li {if $nav=="media" && $nav_sub=='list'}class="sel"{/if}><a href="/media.main"><b>媒体列表</b></a></li>
			<li {if $nav=="media" && $nav_sub=='add'}class="sel"{/if}><a href="/media.main.add">新增媒体</a></li>
		</ul>
	</div>

	<h3 class="bort " {if $nav=="website"}current="active"{/if}>网站管理</h3>
	<div class="snav" style="display:block;" {if $nav=="website"}current="active"{/if}>
		<ul>
			<li {if $nav=="website" && $nav_sub=='list'}class="sel"{/if}><a href="/media.website"><b>网站列表</b></a></li>
			<li {if $nav=="website" && $nav_sub=='add'}class="sel"{/if}><a href="/media.website.add">新增网站</a></li>
		</ul>
	</div>
*}
	<h3 class="bort " {if $nav=="dsp"}current="active"{/if}>DSP管理</a></h3>
	<div class="snav" style="display:block;" {if $nav=="dsp"}current="active"{/if}>
		<ul>
			<li {if $nav=="dsp" && $nav_sub=="list"}class="sel"{/if}><a href="/dsp.main.list">DSP列表</a></li>
			<li {if $nav=="dsp" && $nav_sub=="add"}class="sel"{/if}><a href="/dsp.main.add">新增DSP</a></li>
		</ul>
	</div>

</div>
{*

      <ul>
        <li><a href="#">广告审核</a></li>
        <li><a href="#">DSP素材审核</a></li>
        <li><a href="#">DSP管理</a></li>
        <li class="nobotbor sel"><a href="#">流量控制</a></li>
      </ul>
*}
