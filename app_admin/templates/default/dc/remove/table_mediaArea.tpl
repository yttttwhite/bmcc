   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt20 tb_area_report">
      <tr>
        <th>媒体名称</th>
        <th>地域</th>
        
        <th>访问量</th>
        <th>推送量</th>
        <th>展示量</th>
        <th>点击量</th>
        <th>收益</th>
      </tr>
{if !empty($result)}
    {foreach($result as $key=>$v)}
        <tr>
            <td>{$v['host']}</td> 
            <td>{$v['region']}</td> 
            <td>{$v['visit']+$v['push']}</td> 
            <td>{$v['push']|default:0}</td> 
            <td>{$v['show']|default:0}</td> 
            <td>{$v['click']|default:0}</td> 
            <td>{$v['show']*0.0312}</td> 
            
        </tr>
    {/foreach}
{/if}
</table>
<div class="turnpage tb_area_report">
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
