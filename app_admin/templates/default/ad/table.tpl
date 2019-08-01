<table width="100%" border="0" cellspacing="0" cellpadding="0" class="reportab mt20">
      <tr>
        <th>地域</th>
        <th>展现数</th>
        <th>点击数</th>
        <th>总费用</th>
      </tr>
{foreach($area_report as $key=>$v)}
    <tr>
        <td>{$key}</td> 
        <td>{$v['show']}</td> 
        <td>{$v['click']}</td> 
        <td>{$v['cost']}</td> 
    
    </tr>
{/foreach}
</table>
<div class="turnpage">
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


