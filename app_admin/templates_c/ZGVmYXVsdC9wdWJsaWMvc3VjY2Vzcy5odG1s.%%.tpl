<html>
<head>
<meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
<title>跳转页面</title>
<script type="text/javascript">
	var i = <?php echo htmlspecialchars(Tpl::$_tpl_vars["second"], ENT_QUOTES); ?>;
	var intervalid;
	intervalid = setInterval("fun()", 1000);
	function fun() {
		if (i == 0) {
			window.location.href = "<?php echo htmlspecialchars(Tpl::$_tpl_vars["url"], ENT_QUOTES); ?>";
			clearInterval(intervalid);
		}
		document.getElementById("mes").innerHTML = i;
		i--;
	}
</script>
</head>
<body>
	<div class="redirect-container">
		<div id="error">
			<p><?php echo htmlspecialchars(Tpl::$_tpl_vars["msg"], ENT_QUOTES); ?></p>
			<p>将在<span id="mes"><?php echo htmlspecialchars(Tpl::$_tpl_vars["second"], ENT_QUOTES); ?></span>秒钟后返回.</p>
			<p><a href="<?php echo htmlspecialchars(Tpl::$_tpl_vars["url"], ENT_QUOTES); ?>" class="btn btn-info fr btn-squared btn-sm">立即返回</a></p>
		</div>
	</div>
</body>
</html>