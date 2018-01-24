<?php

require_once(INCLUDES_PATH . DS . "database.php");

/**
 * Class Comment
 *
 * used for comments on images
 *
 */
class Comment extends DatabaseObject{
    /**
     * @var string
     */
    protected static $table_name="comments";
    /**
     * list of fields object has in database
     * @var array
     */
    protected static $db_fields=array('id', 'photograph_id', 'created', 'author', 'body');

    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $photograph_id;
    /**
     * @var
     */
    public $created;
    /**
     * @var
     */
    public $author;
    /**
     * @var
     */
    public $body;

    /**
     * Function to make new comment to photo. Returns comment or false if error
     *
     * @param $photo_id
     * @param string $author //optional
     * @param string $body
     * @return bool|Comment
     */
    public static function make($photo_id, $author="Anonymous", $body=""){
        if(!empty($photo_id) && !empty($author) && !empty($body)){
            $comment = new Comment();
            $comment->photograph_id = (int)$photo_id;
            $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
            $comment->author = $author;
            $comment->body = $body;
            return $comment;
        } else {
            return false;
        }
    }

    /**
     * @param int $photo_id
     * @return array
     */
    public static function find_comments_on($photo_id=0){
        global $database;
        $sql = "SELECT * FROM " . self::$table_name;
        $sql .= " WHERE photograph_id=" . $database->escape_value($photo_id);
        $sql .= " ORDER BY created ASC";
        return self::find_by_sql($sql);
    }

}

?>