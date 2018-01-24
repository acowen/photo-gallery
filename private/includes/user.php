<?php
require_once(INCLUDES_PATH . DS . 'database.php');

/**
 * Class User
 *
 *
 */
class User extends DatabaseObject {

    /**
     * @var string
     */
    protected static $table_name="users";
    /**
     * @var array
     */
    protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'email');

    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    protected $password;
    /**
     * @var
     */
    public $first_name;
    /**
     * @var
     */
    public $last_name;
    /**
     * @var
     */
    public $email;

    /**
     * get full name
     *
     * @return string
     */
    public function full_name() {
        if(isset($this->first_name) && isset($this->last_name)) {
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }

    /**
     * hash password when creating new user or updating password
     *
     * @param $password
     */
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * finds users in the database by username
     *
     * @param $username
     * @return bool|mixed
     */
    public static function find_by_username($username){
        global $database;
        $sql = "SELECT * FROM ".self::$table_name." Where username='". $database->escape_value($username). "' LIMIT 1";
        $result_array = static::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    /**
     * authenticates user
     * checks hashed password from database with entered password
     *
     * @param string $username
     * @param string $password
     * @return bool|mixed
     */
    public static function authenticate($username="", $password="") {
        global $database;
        $user = self::find_by_username($username);
        if($user){
            return password_verify($password, $user->password) ? $user : false;
        } else {
            return false;
        }
    }

    // Common Database Methods

    /**
     * finds all of the child's class objects from the database
     *
     * @return array|bool|mysqli_result|resource
     */
    public static function find_all() {
        return self::find_by_sql("SELECT * FROM ".self::$table_name);
    }

}