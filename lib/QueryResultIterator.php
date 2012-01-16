<?php
/**
 *  An itterator class for mysqli results
 */
class QueryResultIterator {
    public $result;
    
    /**
     *  constructor
     *  @param mysql_query result pointer
     */
    public function __construct (& $result) {
        $this->result =& $result;
    }
    
    /**
     * Get current result, and advance
     * @return mixed
     */
    public function get() {
        return $this->result->fetch_object();
    }
    
    /**
     *  Counts resulting rows
     *  @return int
     */
    public function count() {
        return $this->result->num_rows;
    }
    
    /**
     *  restart
     */
    public function reset() {
        return $this->result->data_seek(0);
    }
}
?>