<!DOCTYPE html>
<html>
    <head>
        <meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo htmlspecialchars(tpl_function_part("/main.main.header"), ENT_QUOTES); ?>
		<style>
			html, body{ height:100%; }
			.full-bg{ position: fixed; width: 100%; height: 100%; z-index: -10; background: rgba(0,0,0,0.5)}
			.login-top{ width:100%; position:absolute; background:#FFFFFF; height: 70px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);  -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.5);  -moz-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.5); }
			.login-top .top{ float: none; margin: auto; width: 61.8%; min-width:840px; height: 100%; }
			.login-block{ width: 61.8%; height:480px; margin:auto; min-width:840px; }
		</style>
    </head>
    <body>
    	<div class="full-bg">
    		<!--<img src="https://cdn.url.bi/image/index.php" style="min-width: 100%; min-height: 100%; max-width: 2000px; max-height: 1200px;"/>-->
    		<!--<img src="/baichuan_advertisement_manage/image/index.php" style="min-width: 100%; min-height: 100%; max-width: 2000px; max-height: 1200px;"/>-->
    		<img src="http://localhost:8001/image/index.php" style="min-width: 100%; min-height: 100%; max-width: 2000px; max-height: 1200px;"/>
    	</div>
		<div class="login-top">
			<div class="top">
                <div class="tlogo">
                    <img src="<?php echo htmlspecialchars(Tpl::$_tpl_vars["loginLogo"], ENT_QUOTES); ?>" alt="广告推广平台" height="50"/>
                </div>
            </div>
		</div>
        <div class="main_block" style="margin:0; background:none;">
			<div class="login-block">
				<div class="logform" style="margin-top:140px; float:right; background:#FFFFFF; background:rgba(255,255,255,0.8);">
                    <noscript><span style="color: red;">JS已被禁用，请开启</span><br><br></noscript>
                    <!--[if lte IE 8]>
                        <span style="color: red;">浏览器版本过低，部分功能无法使用，建议升级浏览器</span><br><br>
                    <![endif]-->
		            <h1 class="logtit" style="font-size:14px;">用户登录:
                        <?php if(!empty(Tpl::$_tpl_vars["error"])){; ?>
		                <font color="red">
		                    <?php echo htmlspecialchars(Tpl::$_tpl_vars["error"], ENT_QUOTES); ?>
		                </font><?php }; ?>
		            </h1>
		            <form class="logfr" action="/baichuan_advertisement_manage/user.main.login" method="post" id="keydown">
		                <div>
							<input name="username" id="username" type="text" class="input_txt border_radius" placeholder="&nbsp&nbsp注册邮箱 / 用户名" style="line-height:34px;" required="required">
		                </div>
		                <div>
							<input name="password" id="pwd" type="password" class="input_txt border_radius" onpaste="return false" onselectstart="return false" placeholder="&nbsp&nbsp密码" style="line-height:34px;" required="required" />
		                </div>
		                <div class="yanzheng"  style="width:300px;height:60px;">
			                <table >
						        <tr>
						        	<td><input name="code" style="width:100px;height:40px;font-size:16px;line-height:34px;" type="text"  placeholder="&nbsp&nbsp验证码" id="inputCode" required="required" /></td>
						            <td> <div title="点击更换验证码" class="code" id="checkCode" onclick="createCode()" style="background-repeat:no-repeat;margin-left: 50px;width:160px;height:50px;cursor: pointer;"></div></td>
						        </tr>
						    </table>
		                </div>
						<label for="jzw" align="absmiddle">
		                    <input id="jzw" type="checkbox" value="" style="vertical-align:middle;"/> 记住我
		                </label>
		                <div class="clear">
		                </div>
		                <div class="btndiv" style="height:40px;">
		                	<input type="submit" onclick="login()" class="btn btn-squared btn-primary fr ml20" value="登录" />
							<input type="button" class="btn btn-squared btn-default fr" value="注册" disabled="disabled" />
		                </div>
		            </form>
		        </div>
			</div>
        </div>
        <?php echo htmlspecialchars(tpl_function_part("/main.main.loginfooter"), ENT_QUOTES); ?>
        <script src="/baichuan_advertisement_manage/assets_admin/js/jquery.md5.js"></script>
        <script src="/baichuan_advertisement_manage/assets_admin/js/base64.js"></script>

        

    <script language="javascript" type="text/javascript">
        function createCode() {
            var checkCode = document.getElementById("checkCode");
            checkCode.style.backgroundImage = 'url("baichuan_advertisement_manage/user.main.getCode.png?_='+ Date.now()+'")';
        }   
	   createCode();

        function login() {
            var password = $("#pwd").val();
            var username = $("#username").val();
            var base = new Base64();
            var code    = $("input[name='code']").val();
            password = getEncryption(password, code);
            $("input[name='password']").val(password);
            var username = base.encode(username);
            $("#username").val(username);
            $("#keydown").submit();
        }

        function getEncryption(password,code) {
            var str = $.md5(password)+code.toLowerCase();
            return str;
        }

     </script>
    </body>
</html>
