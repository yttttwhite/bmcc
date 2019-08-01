<?php
class fliter{
    
    public  function fliter($str){
        $arrWord = file('dict.txt');
        $resTrie = trie_filter_new();
        foreach ($arrWord as $k => $v) {
            trie_filter_store($resTrie, $v);
        }
        trie_filter_save($resTrie, __DIR__ . '/blackword.tree');
        $resTrie = trie_filter_load(__DIR__ . '/blackword.tree');
        $arrRet = trie_filter_search_all($resTrie, $str);
        return $arrRet;
    }

}

