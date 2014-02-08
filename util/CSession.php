<?php
class CSession {

    public static $AUTHINDEX = 'auth_index';
    private static $instance = null;

    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new CSession();
        }

        return self::$instance;
    }

    private $session = null;

    private function __construct() {
        session_start();
        $this->session = &$_SESSION;

        // $_SESSION is per machine based, for distributed system it is not cross machine.
        // for distributed system, use centrallized cachine services such as memcache.
    }

    public function set($key, $val) {
        $this->session[$key] = $val;
    }

    public function get($key) {
        $atReturn = null;
        if (isset($this->session[$key])) {
            $atReturn = $this->session[$key];
        }
        return $atReturn;
    }

    public function exist($key) {
        return isset($this->session[$key]);
    }

    public function logout() {
        unset($this->session[CSession::$AUTHINDEX]);
        $this->session = array();
    }
}
?>