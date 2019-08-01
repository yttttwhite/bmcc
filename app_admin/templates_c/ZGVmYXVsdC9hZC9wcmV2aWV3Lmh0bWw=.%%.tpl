<html>
<head>
<meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>广告预览-AID:<?php echo htmlspecialchars(Tpl::$_tpl_vars["aid"], ENT_QUOTES); ?></title>
</head>
<body style="height:100%; margin:0;">
<?php if(strlen(Tpl::$_tpl_vars["url"])>10){; ?>
<iframe src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["url"], ENT_QUOTES); ?>" style="width:100%; height:100%; border:none;"></iframe>
<?php }; ?>
<script>
var mim_infod="<?php echo htmlspecialchars(Tpl::$_tpl_vars["config"]->host->admin, ENT_QUOTES); ?>";
<?php if(!empty(Tpl::$_tpl_vars["aid"])){; ?>
var mim_aid="<?php echo htmlspecialchars(Tpl::$_tpl_vars["aid"], ENT_QUOTES); ?>";
<?php }; ?>
</script>
<script src="https://<?php echo htmlspecialchars(Tpl::$_tpl_vars["config"]->host->js, ENT_QUOTES); ?>/main.js"></script>
</body>
</html>
