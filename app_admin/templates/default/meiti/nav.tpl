{if $nav=="media"}
<a class="btn btn-squared btn-success" href="/baichuan_advertisement_manage/media.main.add?nav=2" style="width: 100%; background: #12C043;">创建媒体</a>
<br/><br/>
{/if}

{if $nav=="channel"}
<a class="btn btn-squared btn-success" href="/baichuan_advertisement_manage/media.channel.add?nav=2" style="width: 100%; background: #12C043;">创建频道</a>
<br/><br/>
{/if}

{if $nav=="tag"}
<a class="btn btn-squared btn-success" href="/baichuan_advertisement_manage/media.tag.add?nav=2" style="width: 100%; background: #12C043;">创建广告位分类</a>
<br/><br/>
{/if}

{if $nav=="position"}
<a class="btn btn-squared btn-success" href="/baichuan_advertisement_manage/media.position.add?nav=2" style="width: 100%; background: #12C043;">创建位置</a>
<br/><br/>
{/if}


<div class="accordion" style="margin-top:0;">
	<h2>媒体管理</h2>
{if(user_api::auth("media") && $config['dsp']['media'])}
	<a href="/baichuan_advertisement_manage/media?nav=2"><h3 class="bort {if $nav=="media"}active{/if}">媒体来源</h3></a>

	<a href="/baichuan_advertisement_manage/media.channel?nav=2"><h3 class="bort {if $nav=="channel"}active{/if}">频道专题</h3></a>

    <a href="/baichuan_advertisement_manage/media.tag?nav=2"> <h3 class="bort {if $nav=="tag"}active{/if}">广告位分类</h3></a>

    <a href="/baichuan_advertisement_manage/media.position?nav=2"> <h3 class="bort {if $nav=="position"}active{/if}">广告位置</h3></a>
{/if}
    <a href="/baichuan_advertisement_manage/media.schedule?nav=2" > <h3 class="bort {if $nav=="schedule"}active{/if}">广告位排期</h3></a>

</div>
