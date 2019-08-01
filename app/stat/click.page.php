<?php
class stat_click{
	public function pageEntry($inPath){
		if(!empty($_GET['aid'])){
			$db = new stat_db;
			$stuff=$db->getStuffByAid($_GET['aid']);
			if(!empty($stuff)){
				cache_page::set(60*10);
				echo "<html><head></head><body><span style='display:none'>{$stuff['click_js']}</span>";
				echo "广告点击监控：".$_GET['aid'];
				//echo "<a target='_blank' href='{$stuff['landing_page']}'><img src='{$stuff['addr']}'/></a><br/>";
				//echo "<table>";
				//echo "<tr><td>广告计划ID</td><td>{$stuff['plan_id']}</td></tr>";
				//echo "<tr><td>广告组ID</td><td>{$stuff['group_id']}</td></tr>";
				//echo "<tr><td>广告ID</td><td>{$stuff['adid']}</td></tr>";
				//echo "<tr><td>素材大小</td><td>{$stuff['width']}*{$stuff['height']}</td></tr>";
				echo "</body><html>";
			}else{
			    echo "广告点击监控：没有匹配到广告信息";
			}
		}else{
		    echo "广告点击监控：请指定ID";
		}
	}
	
	public function pageIframe($inPath){
		if(!empty($_GET['aid'])){
			$db = new stat_db;
			$stuff=$db->getStuffByAid($_GET['aid']);
			if(!empty($stuff)){
				cache_page::set(60*10);
				echo "<html><head></head><body style='margin:0; padding:0;'>";
				echo "<span style='display:none'>{$stuff['click_js']}</span>";
				echo "<a href=''>";
				echo "<img src='{$stuff['addr']}' style='width:100%;'/>";
				echo "</a>";
				echo "</body><html>";
			}else{
			    echo "广告展示监控：没有匹配到广告信息";
			}
		}
	}
}
