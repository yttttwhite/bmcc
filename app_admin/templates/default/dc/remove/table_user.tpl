<table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt20 ">
{if !empty($user_report)}
          <tr>
            <th>用户名</th>
            <th>展现数</th>
            <th>点击数</th>
            <th>点击率</th>
            <th>总费用</th>
          </tr>
        {foreach($user_report as $k=>$v)}
            <tr>
                <td><span><a href="/baichuan_advertisement_manage/dc.main.ListUserPlan.{$v['user_id']}"></>{$k}</span></td>
                <td>{$v['show']|default:0}</td> 
                <td>{$v['click']|default:0}</td> 
                <td>{if(!empty($v['show']))}{round($v['click']*100/$v['show'],3)}{else}0.00{/if}%</td>
                <td>{$v['cost']|default:0}</td> 
            
            </tr>
        {/foreach}
{elseif !empty($plans)}
         <tr>
            <th>广告计划</th>
            <th>展现数</th>
            <th>点击数</th>
            <th>点击率</th>
            <th>总费用</th>
         </tr>
        {foreach($plans as $k=>$v)}
            <tr>
                <td><span><a href="/baichuan_advertisement_manage/dc.main.ReportGroup.{$v->plan_id}">{$v->plan_name}</></span></td>
                <td>{$v->report->show|default:0}</td>
                <td>{$v->report->click|default:0}</td>
                <td>{if(!empty($v->report->show))}{round($v->report->click*100/$v->report->show,3)}%{/if}</td>
                <td>{$v->report->cost|default:0}</td>
            
            </tr>
        {/foreach}
{elseif !empty($groups)}
         <tr>
            <th>广告组</th>
            <th>展现数</th>
            <th>点击数</th>
            <th>点击率</th>
            <th>总费用</th>
         </tr>
        {foreach($groups as $k=>$v)}
            <tr>
                <td><span><a href="/baichuan_advertisement_manage/dc.main.ReportStuffMap.{$v->group_id}">{$v->name}</></span></td>
                <td>{$v->report->show|default:0}</td>
                <td>{$v->report->click|default:0}</td>
                <td>{if(!empty($v->report->show))}{round($v->report->click*100/$v->report->show,3)}%{/if}</td>
                <td>{$v->report->cost|default:0}</td>
            
            </tr>
        {/foreach}
{/if}
</table>
<div class="turnpage ">
      <a href="#"><em>&lt;&lt;</em>上一页</a>
      <a href="#">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">4</a>
      <a href="#">5</a>
      <span>...</span>
      <a href="#">65</a>
      <a href="#">下一页<em>&gt;&gt;</em></a>
</div>


