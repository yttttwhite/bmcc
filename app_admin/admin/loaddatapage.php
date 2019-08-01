<?php

 class admin_loaddata extends STpl
{

    public function pageLoad($inPath)
    {
        $user_model = new model_userInfo();
        $newPwd =  array(
     'h85unXW6',
     'aUn4KRfB',
     'bMhecmjZ',
     'JBWT7NBZ',
     'NromyFVw',
     'KZFrRVU2',
     'rs2o3hgs',
     'jVzPiPvD',
     'ksF8KiBv',
     'P6LqFauM',
     'DHWWRyX8',
     'Rwvfyw5X',
     'cFxwrK7f',
     'LSigEoCc',
     'VoCGYLgo',
     'xBWcxpiR',
     'Awnah64a',
     '7KJapEVH',    
      );
        $users  = $user_model->getData();
        var_dump($users );
    }
}
?>