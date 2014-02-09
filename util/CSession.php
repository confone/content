<?php
class CSession {

    public static $AUTHINDEX = 'auth_index';
	public static $SESSION_KEY = 'CONFONESESSIONID';
	public static $LAST_ACTIVE = 'LAST_ACTIVE';

	private $sessionId = null;
	private $sessionCache = null;

	private static $CSESSION = null;


	public static function instance() {
		if (!isset(self::$CSESSION)) {
			self::$CSESSION = new CSession();
		}

		return self::$CSESSION;
	}

	private function __construct() {
		$this->sessionCache = CacheUtil::getInstance();

		if (isset($_COOKIE[self::$SESSION_KEY])) {
			$this->sessionId = $_COOKIE[self::$SESSION_KEY];
		} else {
			global $component_name;

			$time = md5(microtime());
			$rand = md5(rand(0, 10000));
			$this->sessionId = $component_name.substr($rand, 0, 5).substr($time, -10, 10);

			while ($this->sessionCache->get($this->sessionId)) {
				usleep(rand(100, 1000));

				$time = md5(microtime());
				$rand = md5(rand(0, 10000));
				$this->sessionId = $component_name.substr($rand, 0, 5).substr($time, -10, 10);
			}

			setcookie(self::$SESSION_KEY, $this->sessionId, 0, '/', '', false, true);
		}
	}

	public function set($key, $value) {
		$session = $this->sessionCache->get($this->sessionId);
		if (!$session) {
			$session = array();
		}
		$session[$key] = $value;
		$session[self::$LAST_ACTIVE] = time();
		$this->sessionCache->set($this->sessionId, $session);
	}

	public function get($key) {
		$session = $this->sessionCache->get($this->sessionId);
		$session[self::$LAST_ACTIVE] = time();
		$this->sessionCache->set($this->sessionId, $session);
		if (isset($session[$key])) {
			return $session[$key];
		} else {
			return null;
		}
	}

	public function destroy() {
		$this->sessionCache->delete($this->sessionId);
	}
}
?>