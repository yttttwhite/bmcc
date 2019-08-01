<div class="dbg">
  <div class="pmain">
  <div class="ptit">
    <div class="ptname">按媒体选择人群</div>
    <div class="ptclose"><a href="javascript:;" id="btnClose" onClick="closeDiv('pdomain_3')"><img src="/baichuan_advertisement_manage/assets_admin/img/i_close.png" alt="关闭" /></a></div>
  </div>
  <div class="dcon">
  
      <div class="toolbar-bc">
        <div class="selMenu smzt mr15">
            <select>
                <option>媒体类型</option> 
                <option></option> 
            </select>
        </div>
        <span class="iSearch"><input id="search_media_type_txt" type="text" class="itxt" value="媒体名称" size="20" /></span>
      </div>
      <script>
      $(document).ready(function(){
        $("#media_ok").click(function(){
				var host_ids="";
				var host_labels="";
                console.log($(this).parents());
				$(this).parents().find(".hostdiv").find(".hostlb>input:checked").each(function(i,item){
                    if($(item).val()){
                        host_ids+=$(item).val()+":";
                        host_labels+=$(item).attr("data")+":";
                    }
				});
				$("#media_value").val(host_ids);
				$("#media_label").val(host_labels);
				closeDiv('pdomain_3');
			});
        
              
      })
        slideToggle=function(cateid){
                        $("#catediv"+cateid).slideToggle("fast");    
                    }
      </script>
      <div id="media_type" class="hostdiv">
          {foreach $crowds_new as $cate_type=>$hosts} 
            <div>
                <div class="accordion rqltit" id=catetitle{$hosts[0]['cateid']} onClick="slideToggle('{$hosts[0]["cateid"]}')">{$cate_type}</div>
                <div id=catediv{$hosts[0]['cateid']} style="display:none" >
                {$i=1}
                {foreach $hosts as $host}
                {if $i%4==1 && $i>4}<br />{/if}
                <label class="hostlb" for="mt{$i}"><input id="mt{$i++}" data="{$host['hostname']}" type="checkbox" 
                    {if(!empty($group->policys))}
                      {foreach $group->policys as $policy}
                        {if $policy->herd_id==$host['hostid']}checked{/if}
                      {/foreach}
                    {/if}
                value="{$host['hostid']}"/>{$host['hostname']}</label> 
                {/foreach}
                </div>
            </div>
          {/foreach}
      </div>                   
        
      <div class="dpbtn">
      <div>
          <a id="1" href="">1</a>
          <a id="2" href="">2</a>
          <a id="3" href="">3</a>
          <a id="4" href="">4</a>
          <a id="5" href="">5</a>
      </div>
        <div class="fr">
          <span class="sbtnb ml30"><input name="" id="media_ok" type="button" class="ibtnb" value="确定" onClick="closeDiv('pdomain_3')" /></span>
          <span class="sbtng ml15"><input name="" type="button" class="ibtng" value="取消" onClick="closeDiv('pdomain_3')" /></span>
        </div>
      </div>
      

  </div>
  </div>
</div>
