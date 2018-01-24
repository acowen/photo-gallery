<?php
require_once(INCLUDES_PATH . DS . 'database.php');

/**
 * Class DatabaseObject
 *
 * Parent class to objects that have entries in the DB
 *
 */
class DatabaseObject {
//Common Database Methods
    /**
     * returns array of all objects of the child class table from the database
     * @return array
     */
    public static function find_all() {
        $sql = " users";
        return static::find_by_sql("SELECT * FROM " .static::$table_name);
    }

    /**
     * Get return an object by id.
     *
     * @param int $id
     * @return bool|mixed
     *
     */
    public static function find_by_id($id=0){
        global $database;
        $sql = "SELECT * FROM ".static::$table_name." Where id=". $database->escape_value($id). " LIMIT 1";
        $result_array = static::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    /**
     * Query SB with sql string, return instantiated objects
     *
     * @param string $sql
     * @return array
     *
     */
    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

    /**
     * Return count of all rows in the table
     *
     * @return mixed
     */
    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }


    /**
     * returns an object with the record retrieved
     *
     * @param $record
     * @return mixed
     *
     */
    private static function instantiate($record){
        //Could check that $record exists and is an array
        $class_name = get_called_class();
        $object = new $class_name;

        //after object is created go through all records and assign them to the objects attributes
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    /**
     * checks to see if there is a field that matches for the given object
     * @param $attribute
     * @return bool
     *
     */
    private function has_attribute($attribute){
        $object_vars = $this->attributes();
        return array_key_exists($attribute, $object_vars);
    }

    /**
     * return an array of attribute keys and their values
     * return get_object_vars($this);
     *
     * @return array
     */
    protected function attributes(){
        $attributes = array();
        foreach (static::$db_fields as $field){
            if(property_exists($this, $field)){
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    /**
     * DB escapes all attributes.
     *
     * @return array
     */
    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        //escape all values
        foreach($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    /**
     * Decide whether to update or create record in the DB.
     *
     * @return bool
     */
    public function save(){
        //A new record wont have an id yet
        return isset($this->id) ? $this->update() : $this->create();
    }

    /**
     * Create new record in DB.
     *
     * @return bool
     */
    public function create(){
        global $database;
        $attributes = $this->sanitized_attributes();

        //remove id attribute
        array_shift($attributes);

        $sql = "INSERT INTO ". static::$table_name ." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        }else {
            return false;
        }
    }

    /**
     * Update DB with attributes.
     * @return bool
     */
    public function update(){
        global $database;
        $attributes = $this->sanitized_attributes();
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE ". static::$table_name ." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id='". $database->escape_value($this->id) ."'";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    /**
     * Delete record from database.
     *
     * @return bool
     */
    public function delete(){
        global $database;
        $sql = "DELETE FROM ". static::$table_name ." ";
        $sql .= "WHERE id=" . $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        echo $sql;
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

}