<?php
/**
 * Project: NJUOPEN/Portal-BBS
 * Contributor: WHZ
 * Filename: dispatcher.php
 *
 * 研究了emlog和网上的一些dispatcher例子,对于路由表的概念不太理解,
 * 不明白如何直接通过一个method变量就能来创造类,暂时只能将就着用switch罗列出来
 */
class Dispatcher {
    /**
     * 指示需要调用的模块
     */
    private $action;
    /**
     * 附加的参数
     */
    private $params;

    public function __construct() {
        $this->action = $_POST['action'];
        $this->params = array();
        foreach ($_POST as $key=>$val) {
            if ($key != 'action') {
                $this->params[$key]=$val;
            }
        }
    }

    public function dispatcher() {
        switch ($this->action) {
            case 'login' :
                Log::login($this->params);
                break;
            case 'logout' :
                Log::logout();
                break;
            // TODO add more
            default:
                echo 'model not found!';
        }
    }
}
?>
