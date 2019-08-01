<!--版权2-->
<div class="footer">
  <div class="ftcon">
	{$footer|html}
  </div>
  <span style="display:none !important;">
  	<script src="https://s95.cnzz.com/stat.php?id=1258168072&web_id=1258168072" language="JavaScript"></script>
  </span>
</div>
<script>
	jQuery(document).ready(function() {
		$windowHeight = $(window).height();
		$topHeight = $(".top").height();
		$navHeight = $(".nav").height();
		$footerHeight = $(".footer").height();
		$mainHeight = $windowHeight - $topHeight - $navHeight - $footerHeight - 20;
		$currnetMainHeight = $(".main").height();
		
		if($mainHeight > $currnetMainHeight){
			$(".main").height($mainHeight+"px");
		}
		
		$('.flat-red').iCheck({
			checkboxClass: 'icheckbox_minimal-aero',
			radioClass: 'iradio_minimal-aero',
			increaseArea: '10%' // optional
		});
	});
</script>