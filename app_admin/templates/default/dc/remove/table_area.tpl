   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt20 tb_area_report">
      <tr>
        <th>ID</th>
        <th>DSP名称</th>
        <th>竞价次数</th>
        <th>竞价成功次数</th>
        <th>曝光量</th>
        <th>点击量</th>
        <th>消耗(元)</th>
      </tr>
{if !empty($result)}
    {foreach($result as $key=>$v)}
        <tr>
            <td>{$v['dspid']}</td> 
            <td>{$v['dspname']}</td> 
            <td>{$v['bidreq']|default:0}</td> 
            <td>{$v['bidsucc']|default:0}</td> 
            <td>{$v['push']|default:0}</td> 
            <td>{$v['click']|default:0}</td> 
            <td>{$v['pprice']|default:0}</td> 
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
