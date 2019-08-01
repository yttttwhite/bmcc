<?php
if(isset($_GET['phpinfo'])){
    echo phpinfo();
}

if(isset($_GET['xhprof'])){
    xhprof_enable();
    
    test();
    
    $xhprof_data = xhprof_disable();
    $XHPROF_ROOT = '/data/www/bcsvn/bs_zj/www';
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";
    $xhprof_runs = new XHProfRuns_Default();
    $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");
    echo "<a href='/xhprof_html/index.php?run=$run_id&source=xhprof_foo' target='_blank' style='z-index: 1000; position: absolute; top: 0; right: 0;'>查看性能图示</a>";
    
}

function test(){
    for($i=0; $i<10000; $i++){
        echo $i;
    }
}