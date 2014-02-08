<?php
class CacheUtil {
	private $memcache = null;

	public function __construct() {
		global $cache_servers;
		$this->memcache = new Memcached();

		foreach($cache_servers as $host=>$port) {
			$this->memcache->addServer($host, $port);
		}
	}

	public function getCacheObj() {
		return $this->memcache;
	}
}
?>