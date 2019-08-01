<?php
class cache_page{
	public static function set($expiretime){
		@header("Pragma:private");
		@header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
		@header("Expires: " . gmdate("D, d M Y H:i:s", time()+$expiretime) . " GMT");
		@header("Cache-Control: max-age=" . "$expiretime");
	}

}
