<div id="pdomain_{$command_name}" class="popdiv pop_domain" style="display:block">
<form method="post" action="/dpc.main.add.{$collection}" onSubmit="return checkForm(this);">
    <div class="dbg">
        <div class="pmain">
            <div class="ptit">
                <div class="ptname">媒体</div>
                <div class="ptclose">
                    <input type="hidden" name="command_name" value="{$command_name}">
                    <a id="btnClose{$command_name}" href="javascript:;" onClick="closeDiv('pdomain_{$command_name}')"> <img src="/baichuan_advertisement_manage/assets_dpc/img/i_close.png" alt="关闭"> </a>
                </div>
            </div>
            <div class="dcon">
                <div class="clear">
                    <div class="f1">
                        <span class="sbtng"><input id="domain_set_1_{$command_name}" class="ibtng" type="button" value="{if strstr($tab1_name,'black')}黑名单{else} {$tab1_name} {/if}"></span>
                        {if !empty($tab2_name)}<span class="sbtng"><input id="domain_set_2_{$command_name}" class="ibtng" type="button" value="{if strstr($tab2_name,'white')}白名单{else} {$tab2_name} {/if}"></span>{/if}
                       {if !empty($tab3_name)} <span class="sbtng"><input id="domain_set_3_{$command_name}" class="ibtng" type="button" value="{$tab3_name}"></span>{/if}
                        <div id="domain_pannel_1_{$command_name}" class="pdomcon">
                            手动输入选择(每行一个):<br />
                            <textarea style="margin: 10px; padding: 5px; height: 125px; width: 625px;" name="{$tab1_name}" cols="30" rows="10">{if !empty($values1)}{foreach $values1 as $value}{$value['keyword']."\n"}{/foreach}{/if}</textarea>
                        </div>
                       {if !empty($tab2_name)} <div id="domain_pannel_2_{$command_name}" class="pdomcon" style="display:none">
                            手动输入选择(每行一个):<br />
                            <textarea  style="margin: 10px; padding: 5px; height: 125px; width: 525px;" name="{$tab2_name}" cols="30" rows="10">{foreach $values2 as $value}{$value['keyword']."\n"}{/foreach}</textarea>
                        </div>
                        {/if}
                        {if !empty($tab3_name)}
                        <div id="domain_pannel_3_{$command_name}" class="pdomcon" style="display:none">
                            手动输入选择(每行一个):<br />
                            <textarea  style="margin: 10px; padding: 5px; height: 125px; width: 625px;" name="{$tab3_name}" cols="30" rows="10"></textarea>
                        </div>
                        {/if}
                        <div class="dpbtn">
                            <div class="fr">
                                <span class="sbtnb m130">
                                    <input class="ibtnb" type="submit" value="保存"/>
                                </span>
                                <span class="sbtng m115">
                                    <input class="ibtng" type="button" value="取消" onClick="closeDiv('pdomain_{$command_name}')"/>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
    <script>
        $("#domain_set_1_{$command_name}").click(function(){
        $("#domain_pannel_1_{$command_name}").show();
        $("#domain_pannel_2_{$command_name}").hide();
        $("#domain_pannel_3_{$command_name}").hide();
        });
        $("#domain_set_2_{$command_name}").click(function(){
        $("#domain_pannel_1_{$command_name}").hide();
        $("#domain_pannel_2_{$command_name}").show();
        $("#domain_pannel_3_{$command_name}").hide();
        });
        $("#domain_set_3_{$command_name}").click(function(){
        $("#domain_pannel_1_{$command_name}").hide();
        $("#domain_pannel_2_{$command_name}").hide();
        $("#domain_pannel_3_{$command_name}").show();
        });
        function checkHttp(arr){
                var is_https=1;
                $.each(arr,function(i,n){
                        var index=$.trim(n).indexOf("https://");
                        if(index!==0){
                            return true;
                        }else{
                            is_https=2;
                            return false;
                        }
                });
                return is_https;
        }

        function checkForm(obj){
                        var tab1_name_arr=$(obj).find("textarea[name={$tab1_name}]").val().split(/\s+/); 
                            tab2_name_arr=$(obj).find("textarea[name={$tab2_name}]").val().split(/\s+/); 
                            res1=checkHttp(tab1_name_arr);
                            res2=checkHttp(tab2_name_arr);
                        if(res1==2 || res2==2){
                            alert("请去掉开始的(https://)");
                            return false;
                        }else{
                            return true;
                        }
        }
</script>
