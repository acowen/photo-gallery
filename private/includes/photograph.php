<?php

/**
 * Class Photograph
 */
class Photograph extends DatabaseObject {
    /**
     * @var string
     */
    protected static $table_name="photographs";
    /**
     * @var array
     */
    protected static $db_fields=array('id', 'filename', 'type', 'size', 'caption');
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $filename;
    /**
     * @var
     */
    public $type;
    /**
     * @var
     */
    public $size;
    /**
     * @var
     */
    public $caption;

    /**
     * @var
     */
    private $temp_path;
    /**
     * @var string
     */
    protected $upload_dir="images";
    /**
     * @var array
     */
    public $errors=array();
    /**
     * @var array
     */
    protected $upload_errors = array(
        // http://www.php.net/manual/en/features.file-upload.errors.php
        UPLOAD_ERR_OK 			=> "No errors.",
        UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
        UPLOAD_ERR_NO_FILE 		=> "No file.",
        UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
    );

    /**
     * function to upload file
     *
     * @param $file
     * @return bool
     */
    public function attach_file($file){
        //make sure file was uploaded else add error message
        if(!$file || empty($file) || !is_array($file)){
            $this->errors[] = "No file was uploaded.";
            return false;
        //get error number and add to error message
        } elseif($file['error'] !=0){
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            //save file attributes to class
            $this->temp_path = $file['tmp_name'];
            $this->filename = basename($file['name']);
            $this->type = $file['type'];
            $this->size = $file['size'];
            return true;
        }
    }

    /**
     * get path to image
     *
     * @return string
     */
    public function image_path(){
        return $this->upload_dir.DS.$this->filename;
    }

    /**
     * return the size of the image in bytes, KB, or MB
     *
     * @return string
     */
    public function size_as_text(){
        if($this->size < 1024) {
            return "{$this->size} bytes";
        } elseif($this->size < 1048576) {
            $size_kb = round($this->size/1024);
            return "{$size_kb} KB";
        } else {
            $size_mb = round($this->size/1048576, 1);
            return "{$size_mb} MB";
        }
    }

    /**
     *
     * return all the comments on this photo
     *
     * @return array
     */
    public function comments() {
        return Comment::find_comments_on($this->id);
    }

    /**
     * function to save image after attaching
     *
     * @return bool
     */
    public function save() {
        if(isset($this->id)) {
            $this->update();
        } else {
            //Make sure there are no errors
            if(!empty($this->errors)){return false; }
            //Make sure the caption is not too long for the DB
            if(strlen($this->caption) > 255){
                $this->errors[] = "The caption can only be 255 characters long.";
                return false;
            }
            if(empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "The file location was not available.";
                return false;
            }

            //Determine the target_path
            $target_path = PROJECT_PATH .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;

            //Make sure a file doesn't already exist
            if(file_exists($target_path)){
                $this->errors[] = "The file {$this->filename} already exists.";
                return false;
            }

            //Attempt to move the file
            if(move_uploaded_file($this->temp_path, $target_path)){
                //Success
                //save a corresponding entry to the database
                if($this->create()){
                    unset($this->temp_path);
                    return true;
                };
            }else {
                //Failure
                $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
                return false;
            }

        }
    }

    /**
     *
     * delete photo entry from database and deletes image from
     *
     * @return bool
     */
    public function destroy() {
        //First remove the database entry
        if($this->delete()){
            //then remove the file
            $target_path = PROJECT_PATH.DS.'public'.DS.$this->image_path();
            return unlink($target_path) ? true : false;
        }else {
            //database delete failed
            return false;
        }

    }
}