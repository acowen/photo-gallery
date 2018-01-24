<?php

/**
 * remove any zeros from the data
 *
 * @param string $marked_string
 * @return mixed
 */
function strip_zeros_from_date($marked_string="" ) {
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // then remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
    return $cleaned_string;
}

/**
 *
 * adds header with a new location of where to redirect
 *
 * @param null $location
 */
function redirect_to($location = NULL ) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

/**
 *
 * output message
 * used for error messages and success messages
 *
 * @param string $message
 * @return string
 */
function output_message($message="") {
    if (!empty($message)) {
        return "<p class=\"message\">{$message}</p>";
    } else {
        return "";
    }
}

/**
 *
 * autoload classes if they are not included
 *
 * @param $class_name
 */
function __autoload($class_name){
    $class_name = strtolower($class_name);
    $path = INCLUDES_PATH.DS."{$class_name}.php";
    if(file_exists($path)) {
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}

/**
 * include template
 *
 * @param string $template
 */
function include_layout_template($template=""){
    include(PUBLIC_PATH.DS.'layouts'.DS.$template);
}

/**
 *
 * make log of users as they log in
 *
 * @param $action
 * @param string $message
 */
function log_action($action, $message=""){
    $time = strftime('%Y-%m-%d %H:%M:%S', time());
    $content = "{$time}| {$action}: {$message}\n";
    $logfile = PRIVATE_PATH.DS.'logs'.DS.'log.txt';
    $new = file_exists($logfile) ? false : true;
    if($handle = fopen($logfile, 'a')){
        fwrite($handle, $content);
        fclose($handle);
        if($new){ chmod($logfile, 0755); }
    } else {
        echo "Could not open file for writing.";
    }
}

/**
 * get time and turn to text
 * @param string $datetime
 * @return string
 */
function datetime_to_text($datetime="") {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}


/**
 * check to see if post request
 * @return bool
 */
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * check to see if get request
 * @return bool
 */
function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

/**
 * short for htmlspecialchars
 * @param string $string
 * @return string
 */
function h($string=""){
    return htmlspecialchars($string);
}

/**
 * short for urlencode
 * @param string $string
 * @return string
 */
function u($string="") {
    return urlencode($string);
}


?>