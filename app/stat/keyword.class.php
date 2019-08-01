<?php
/**
 * 分析搜索引擎到来的关键字
 * 
 * @charset utf-8
 */
class stat_keyword{
	public static $parseHost = array('baidu','google','360','soso',"youdao","soku","sogou","aibang");
	/**
	 * 主方法
	 */
	public static function get($referer,&$k_host=""){
		$refererArr = parse_url($referer);
		//判断refer是否来至不需要分析的地址。

		$hasParseFun = false;
		foreach(self::$parseHost as &$host) {
			if(empty($refererArr['host']))continue;
			if(strpos ($refererArr['host'],$host) !== false) { 
				$hasParseFun = true;
				$k_host=$host;
				break;
			}  
		}

		if(!$hasParseFun)
			return false;


		if(!empty($refererArr['query']) && !empty($host)){
			$queryVars = array();
			parse_str($refererArr['query'], $queryVars);
			//调用每个搜索引擎的单独处理方法
			$method = 'parse'.ucfirst($host);
			return self::$method($queryVars);
		}
	}

	public static function parseBaidu($params){
		$searchTerms = '';
		if(isset($params['kw'])) {
			$searchTerms = $params['kw'];
		} else if(isset ($params['wd'])) {
			$searchTerms = $params['wd'];
		} else if(isset ($params['word'])) {
			$searchTerms = $params['word'];
		}
		if(isset ($params['bs'])) {
			$searchTerms .= " ".$params['bs'];
		}
		return mb_convert_encoding($searchTerms,'utf8', 'utf8,gbk');
	}

	public static function parseGoogle($params){
		$searchTerms = '';
		if(isset($params['q'])) {
			$searchTerms = $params['q'];
		}
		return mb_convert_encoding($searchTerms,'utf8', 'utf8,gbk');
	}
	public static function parseYoudao($params){
		$searchTerms = '';
		if(isset($params['q'])) {
			$searchTerms = $params['q'];
		}
		return mb_convert_encoding($searchTerms,'utf8', 'utf8,gbk');
	}

	public static function parse360($params)
	{
		$searchTerms = '';
		if(isset($params['q'])) {
			$searchTerms = $params['q'];
		}
		return mb_convert_encoding($searchTerms,'utf8', 'utf8,gbk');
	}

	public static function parseSoso($params){
		$searchTerms = '';
		if(isset($params['w'])) {
			$searchTerms = $params['w'];
		}
		if(isset ($params['bs'])) {
			$searchTerms .= " ".$params['bs'];
		}
		return mb_convert_encoding($searchTerms,'utf8', 'utf8,gbk');
	}
	public static function parseSoku($params){
		$searchTerms = '';
		if(isset($params['keyword'])) {
			$searchTerms = ($params['keyword']);
		}
		return mb_convert_encoding($searchTerms,'utf8', 'utf8,gbk');
	}
	public static function parseSogou($params){
		$searchTerms = '';
		if(isset($params['query'])) {
			$searchTerms = ($params['query']);
		}
		return mb_convert_encoding($searchTerms,'utf8', 'utf8,gbk');
	}
	public static function parseaiBang($params){
		$searchTerms = '';
		if(isset($params['q'])) {
			$searchTerms = ($params['q']);
		}
		return mb_convert_encoding($searchTerms,'utf8', 'utf8,gbk');
	}
}
