dsp业务系统修改，edit by 方正 2019.8.13

1.	数据库adp_stuff_info表去掉stuff_id主键属性，将 adid添加为主键

2.	修改新增广告组时的添加逻辑，修改文件为：/app_admin/ad/group.page.php

3.	修改上传素材时没有添加media_name的问题
修改文件为：/app_admin/ad/stufflibrary.page.php，并在/config/config.php下添加配置项$config['media_name'] = "bmcc"

4.	修改视频素材上传尺寸限制，修改文件：/app_admin/ad/stufflibrary.page.php

5.	去掉新增广告第3步预览操作,修改文件：/app_admin/templates/ad/step_3.html

6.	有关layer.js中使用$.layer报错的问题修改了以下文件
app_admin/templates/default/admin/user_ggz.html
app_admin/templates/default/header.tpl
app_admin/templates/default/admin/contractManagement_list.html
www/assets_admin/js/layer/layer.js

7.	修改nginx图片下载问题
location /stuff/ {
		default_type image/png;
        alias /data/stuff/;
    }

8.	修改预览广告时请求main.js问题，修改文件为：/app_admin/ad/preview.page.php

9.	修改新增广告组中所有弹窗的关闭图片不显示问题
    修改方法：
    1). 删掉/www/assets_admin/img/i_close.png
    2). 复制/www/assets_admin/img/close-gray.png并重命名为i_close.png



