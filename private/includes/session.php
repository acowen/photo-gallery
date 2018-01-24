<?php

/**
 * Class Session
 *
 * Used to manage user login
 */
class Session {

    /**
     * @var bool
     */
    private $logged_in=false;
    /**
     * @var
     */
    public $user_id;
    /**
     * @var
     */
    public $message;

    /**
     * Session constructor.
     *
     * checks user login when created to update variables @user_id and @logged_in
     */
    function __construct() {
        session_start();
        $this->check_message();
        $this->check_login();
        if($this->logged_in) {
            // actions to take right away if user is logged in
        } else {
            // actions to take right away if user is not logged in
        }
    }

    /**
     * check if user is logged in
     *
     * @return bool
     */
    public function is_logged_in() {
        return $this->logged_in;
    }

    /**
     * login the user by storing id in the session
     *
     * @param $user
     */
    public function login($user) {
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->logged_in = true;
        }
    }

    /**
     * logout user unset session information
     */
    public function logout() {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
    }

    /**
     * check that an id is set in session
     * set logged in to true
     * else set logged in to false
     */
    private function check_login() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

    /**
     * @param string $msg
     * @return mixed
     */
    public function message($msg=""){
        if(!empty($msg)) {
            //then this is "set message"
            //make sure you understand why $this->message=$msg wouldn't work
            $_SESSION['message'] = $msg;
        }else{
            //then this is "get message"
            return $this->message;
        }
    }

    /**
     *
     */
    private function check_message() {
        //Is there a message stored in the session?
        if(isset($_SESSION['message'])){
            //Add it as an attribure and erase the stored version
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

}

/**
 * start new session when session is created
 */
$session = new Session();
$message = $session->message();

?>