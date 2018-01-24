<?php

/**
 * Class Pagination
 *
 * Used to get back limited number of photos from database
 *
 */
class Pagination {
    /**
     * @var int
     */
    public $current_page;
    /**
     * @var int
     */
    public $per_page;
    /**
     * @var int
     */
    public $total_count;

    /**
     * Pagination constructor.
     * @param int $page
     * @param int $per_page
     * @param int $total_count
     */
    public function __construct($page=1, $per_page=20, $total_count=0){
        $this->current_page = (int)$page;
        $this->per_page = (int)$per_page;
        $this->total_count = (int)$total_count;
    }

    /**
     * return the offset
     *
     * @return int
     *
     */
    public function offset() {
        //Assuming 20 items per page:
        //page 1 has an offset of 0 (1-1) * 20
        //page 2 has an offset of 20 (2-1) * 20
        //  in other words, age 2 starts with item 21
        return($this->current_page -1) * $this->per_page;
    }

    /**
     * gets the total number of pages
     *
     * @return float
     */
    public function total_pages() {
        return ceil($this->total_count/$this->per_page);
    }

    /**
     * returns the previous page
     *
     * @return int
     */
    public function previous_page(){
        return $this->current_page - 1;
    }

    /**
     *
     * returns next page
     *
     * @return int
     */
    public function next_page() {
        return $this->current_page + 1;
    }

    /**
     *
     * checks to see if there is a previous page
     *
     * @return bool
     */
    public function has_previous_page(){
        return $this->previous_page() >= 1 ? true : false;
    }

    /**
     *
     * checks to see if there is a next page
     *
     * @return bool
     */
    public function has_next_page() {
        return $this->next_page() <= $this->total_pages() ? true : false;
    }

    /**
     * check to see if we are on a valid page, used for making AJAX request to get images
     *
     * @return bool
     */
    public function has_page() {
        return $this->current_page <= $this->total_pages() ? true : false;
    }
}

?>