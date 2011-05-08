<?php
// Paging Library for Layer8Daily
// @author Craig Weber (http://crgwbr.com)
// @date   May 8, 2011


class Paginator {
    // Setting default - Set these to whatever you need at runtime
    public $table_name = "table";
    public $filter = null;
    public $rows_per_page = 2;
    public $order_by = "date DESC"; 
    
    /**
    Takes set table, filter, and page number, and return the MySQL query result set.
    @param page_number  Page to get
    @returns MySQL result set
    */
    public function get_page($page_number) {
        // Calculate Limit and Offset
        $limit = $this->rows_per_page;
        $offset = ($page_number - 1) * $this->rows_per_page;
        // Build Query and return results
        if ($this->filter) {
            $query = "SELECT * FROM ".$this->table_name." WHERE ".$this->filter." ORDER BY ".$this->order_by." LIMIT ".$limit." OFFSET ".$offset;
        } else {
            $query = "SELECT * FROM ".$this->table_name." ORDER BY ".$this->order_by." LIMIT ".$limit." OFFSET ".$offset;
        }
        $results = mysql_query($query);
        return $results;
    }
    
    /**
    Get total row count for set table
    @returns integer
    */
    public function get_row_count() {
        // Get Total Row Count
        if ($this->filter) {
            $count = mysql_query("SELECT COUNT(*) FROM ".$this->table_name." WHERE ".$this->filter);
        } else {
            $count = mysql_query("SELECT COUNT(*) FROM ".$this->table_name);
        }
        $count = mysql_fetch_array($count);
        $count = $count[0];
        return $count;
    }
    
    /**
    Return true if the provided page has a next page (pagenumber+1)
    @return bool
    */
    public function has_next($page_number=null) {
        return $this->page_exists($page_number+1);
    }
    
    /**
    Return true if the provided page has a previous page (pagenumber-1)
    @return bool
    */
    public function has_previous($page_number=null) {
        return $this->page_exists($page_number-1);
    }
    
    /**
    Return true if the provided page has a result set larger than 1
    @return bool
    */
    public function page_exists($page_number) {
        if ($page_number > 0) {
            $count = $this->get_page($page_number);
            $count = mysql_num_rows($count);
            $exists = ($count > 0);
            return $exists;
        } else { 
            return false;
        }
    }
}
?>