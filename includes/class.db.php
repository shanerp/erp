<?php

/*------------------------------------------------------------------------------
** File:		class.db.php
** Class:       Simply MySQLi
** Description:	PHP MySQLi wrapper class to handle common database queries and operations 
** Author:		Mahfuz
*/

class DB
{
    private $link;

    public function log_db_errors($error, $query, $severity)
    {
        global $root_url;
        if (defined('DISPLAY_DEBUG') && DISPLAY_DEBUG && defined('ENVIRONMENT') && ENVIRONMENT == 'development') {
            echo '<pre style="border:2px solid red;">DB: ' . $this->db_name . ' <br>Error: ' . $error . ' <br>Query: ' . $query . ' </pre>';
            die();
        }else{
            //SEND EMAIL NOTIFICATION
            $emailData = "An Error Occured on Zonepick. <br> Website: {$root_url} <br> Database: ".$this->db_name." <br> Query: {$query} <br> Error: {$error}";
            if( isset($_SERVER['REQUEST_URI']) ){
              $emailData .= " <br> Query String: ".$_SERVER['REQUEST_URI'];
            }
            $headers = "MIME-Version: 1.0" . "\r\n". "Content-type:text/html;charset=UTF-8" . "\r\n".'From: support@digipro.com' . "\r\n" .
                'Reply-To: mahfuzz786@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            mail('mahfuzz786@gmail.com','Zonepick '.$severity.' Error',$emailData,$headers);
        }
        return false;
    }

    public function __construct($db_name)
    {
        global $connection;
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $this->link = new mysqli(DB_HOST, DB_USER, DB_PASS, $db_name);
        $this->db_name = $db_name;
        if (mysqli_connect_errno()) {
            $this->log_db_errors("Connect failed: %s\n", mysqli_connect_error(), 'Fatal');
            exit();
        }
    }



    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * Sanitize user data
     *
     * @access public
     * @param string , array
     * @return string, array
     *
     */
    public function filter($data)
    {
        if (!is_array($data)) {
            $data = mysqli_real_escape_string($this->link, $data);
        } else {
            //Self call function to sanitize array data
            $data = array_map(array('DB', 'filter'), $data);
        }
        return $data;
    }

    /**
     * Determine if common non-encapsulated fields are being used
     *
     * @access public
     * @param string
     * @param array
     * @return bool
     *
     */
    public function db_common($value = '')
    {
        if (is_array($value)) {
            foreach ($value as $v) {
                if (preg_match('/AES_DECRYPT/i', $v) || preg_match('/AES_ENCRYPT/i', $v) || preg_match('/now()/i',
                      $v)
                ) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            if (preg_match('/AES_DECRYPT/i', $value) || preg_match('/AES_ENCRYPT/i', $value) || preg_match('/now()/i',
                  $value)
            ) {
                return true;
            }
        }
    }

    /**
     * Perform queries
     * All following functions run through this function
     * All data run through this function is automatically sanitized using the filter function
     *
     * @access public
     * @param string
     * @return string
     * @return array
     * @return bool
     *
     */

    public function query($q,$params=array())
    {
        $query = $this->link->prepare($q);

        if ( false===$query ) {
            return $this->log_db_errors($this->link->error, $q, 'Fatal');
        }else{
                
            $query = $this->bind_params($q,$query,$params);

            $query->execute();  
            $query = $query->get_result();

            return true;
        }
    }

    /**
     * Determine if database table exists
     *
     * @access public
     * @param string
     * @return bool
     *
     */
    public function table_exists($name)
    {
        $check = $this->link->query("SELECT * FROM '$name' LIMIT 1");
        if ($check) {
            return true;
        } else {
            return false;
        }
        mysqli_free_result($check);
    }


    /**
     * Count number of rows found matching a specific query
     *
     * @access public
     * @param string
     * @return int
     *
     */
    public function num_rows($q,$params=array())
    {
		
        $query = $this->link->prepare($q);

        $query = $this->bind_params($q,$query,$params);

        $query->execute();
        $query = $query->get_result();

        if (mysqli_error($this->link)) {
            $this->log_db_errors(mysqli_error($this->link), $query, 'Fatal');
            return mysqli_error($this->link);
        } else {
            $return = mysqli_num_rows($query);
            mysqli_free_result($query);
            return $return;
        }
    }


    /**
     * Run check to see if value exists, returns true or false
     *
     * Example Usage:
     * $check_user = array(
     *    'user_email' => 'someuser@gmail.com',
     *    'user_id' => 48
     * );
     * $exists = exists( 'your_table', 'user_id', $check_user );
     *
     * @access public
     * @param string database table name
     * @param string field to check (i.e. 'user_id' or COUNT(user_id))
     * @param array column name => column value to match
     * @return bool
     *
     */
    public function exists($table = '', $check_val = '', $params = array())
    {
        if (empty($table) || empty($check_val) || empty($params)) {
            return false;
            exit;
        }
        $check = array();
        foreach ($params as $field => $value) {

            if (!empty($field) && !empty($value)) {
                //Check for frequently used mysql commands and prevent encapsulation of them
                if ($this->db_common($value)) {
                    $check[] = "$field = $value";
                } else {
                    $check[] = "$field = '$value'";
                }
            }

        }
        $check = implode(' AND ', $check);

        $rs_check = "SELECT $check_val FROM " . $table . " WHERE $check";
        $number = $this->num_rows($rs_check);
        if ($number === 0) {
            return false;
        } else {
            return true;
        }
        exit;
    }


    /**
     * Return specific row based on db query
     *
     * @access public
     * @param string
     * @return array
     *
     */

    public function get_row($q,$params=array())
    {

        $query = $this->link->prepare($q);

        if ( false===$query ) {
            return $this->log_db_errors($this->link->error, $q, 'Fatal');
        }else{
                
            $query = $this->bind_params($q,$query,$params);

            $query->execute();  
            $query = $query->get_result();

            $r = mysqli_fetch_row($query);
            mysqli_free_result($query);
            return $r;
        }
    }


    /**
     * Perform query to retrieve array of associated results
     *
     * @access public
     * @param string
     * @return array
     *
     */
    private function bind_params( $q, $query, $params ){

        if( count($params) ){

            //if params in format $params = array('i'=>51,'s'=>'header'); convert to $params = array(['i'=>51],['s'=>'header'])
            if( !isset($params[0]) ){
                $p = array();
                foreach ($params as $type => $value) {
                    $p[] = [$type=>$value];
                }
                $params = $p;
                unset($p);
            }

            //if params in format $params = array(['i'=>51],['s'=>'header']);  //recommended way

            //Check for bind param count
            if ( $query->param_count != count($params) ){
                return $this->log_db_errors('Query Params count doesn\'t match. Params = '.json_encode($params), $q, 'Fatal');
            }

            $p_arr = array(); $v_arr = array(); 
            foreach ($params as $param) {
                $p_arr[] = key($param);
                $v_arr[] = $param[key($param)];
            }
            
            $bind_names[] = implode('', $p_arr);
            for ($i=0; $i<count($v_arr);$i++) 
            {
                $bind_name = 'bind' . $i;
                $$bind_name = $v_arr[$i];
                $bind_names[] = &$$bind_name;
            }
            $return = call_user_func_array(array($query,'bind_param'),$bind_names);

        }

        return $query;
    }

    public function get_result_view( $query )
    {
        $row = array();
        $query = $this->link->query( $query );
        if( mysqli_error( $this->link ) )
        {
            return $this->log_db_errors( mysqli_error( $this->link ), $query, 'Fatal' );
            return false;
        }
        else
        {
            while( $r = mysqli_fetch_array( $query, MYSQLI_ASSOC ) )
            {
                $row[] = $r;
            }
            mysqli_free_result( $query );
            return $row;   
        }
    }

    public function get_results($q,$params=array())
    {
        $row = array();

        $query = $this->link->prepare($q);

        if ( false===$query ) {
            return $this->log_db_errors($this->link->error, $q, 'Fatal');
        }else{
                
            $query = $this->bind_params($q,$query,$params);

            $query->execute();  
            $query = $query->get_result();

            while ($r = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                $row[] = $r;
            }
            mysqli_free_result($query);
            return $row;
        }
    }


    /**
     * Insert data into database table
     *
     * @access public
     * @param string table name
     * @param array table column => column value
     * @return bool
     *
     */
    public function insert($table, $variables = array(), $queryPrint = 0, $getInsertedID = 0)
    {
        $sql = "INSERT INTO " . $table;
        $fields = array();
        $values = array();
        foreach ($variables as $field => $value) {
            $fields[] = '`'.$field.'`';
            if ((strpos($value, "|_|_") > -1) && (strpos($value, "_|_|") > -1)) {
                $values[] = "'" . $this->filter(str_replace("|_|_", "", str_replace("_|_|", "", $value))) . "'";
            } else {
                if(is_numeric($value) && substr($value,0,1) == '0' && strlen($value) > 1){
                    $values[] = "'" . $this->filter($value) . "'";
                }else{
                    $values[] = is_numeric($value) ? $this->filter($value) : "'" . $this->filter($value) . "'";
                }
            }
        }
        $fields = ' (' . implode(',', $fields) . ')';
        $values = '(' . implode(',', $values) . ')';

        $sql .= $fields . ' VALUES ' . $values;
        if ($queryPrint == 1) {
            echo $sql;
        }

        //create insert log if user logged in
        if (isset($_SESSION['user_id']) && $table != 'session_log') {
            $logID = $this->accessLog($table, 'insert', "$sql");
        }
        $query = mysqli_query($this->link, $sql);


        if (mysqli_error($this->link)) {
            //return false; 
            echo mysqli_error($this->link);
            $this->log_db_errors(mysqli_error($this->link), $sql, 'Fatal');

            //remove insert log if user logged in and error occurred
            if (isset($_SESSION['user_id'])) {
                $where_clause = array(
                   'acc_id' => $logID,
                );
                $response = $nebula_db->delete('access_log', $where_clause, 1);
            }

            return false;
        } else {

            if ($getInsertedID) {
                return mysqli_insert_id($this->link);
            } else {
                return true;
            }
        }
    }

    public function insert_log($table, $variables = array(), $queryPrint = 0, $getInsertedID = 0)
    {


        $sql = 'INSERT INTO ' . $table;
        $fields = array();
        $values = array();
        foreach ($variables as $field => $value) {
            $fields[] = $field;
            $values[] = is_numeric($value) ? $this->filter($value) : "'" . $this->filter($value) . "'";
        }
        $fields = ' (' . implode(',', $fields) . ')';
        $values = '(' . implode(',', $values) . ')';

        $sql .= $fields . ' VALUES ' . $values;
        if ($queryPrint == 1) {
            echo $sql;
        }

        $query = mysqli_query($this->link, $sql);


        if (mysqli_error($this->link)) {
            echo mysqli_error($this->link);
            $this->log_db_errors(mysqli_error($this->link), $sql, 'Fatal');
            return false;
        } else {

            if ($getInsertedID) {
                return mysqli_insert_id($this->link);
            } else {
                return true;
            }
        }
    }


    /**
     * Insert data KNOWN TO BE SECURE into database table
     * Ensure that this function is only used with safe data
     * No class-side sanitizing is performed on values found to contain common sql commands
     * As dictated by the db_common function
     * All fields are assumed to be properly encapsulated before initiating this function
     *
     * @access public
     * @param string table name
     * @param array table column => column value
     * @return bool
     */
    public function insert_safe($table, $variables = array())
    {
        $sql = 'INSERT INTO ' . $table;
        $fields = array();
        $values = array();
        foreach ($variables as $field => $value) {
            $fields[] = $this->filter($field);
            //Check for frequently used mysql commands and prevent encapsulation of them
            $values[] = $value;
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '(' . implode(', ', $values) . ')';

        $sql .= $fields . ' VALUES ' . $values;
        $query = mysqli_query($this->link, $sql);

        if (mysqli_error($this->link)) {
            $this->log_db_errors(mysqli_error($this->link), $sql, 'Fatal');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Update data in database table
     *
     * @access public
     * @param string table name
     * @param array values to update table column => column value
     * @param array where parameters table column => column value
     * @param int limit
     * @return bool
     *
     */
    public function update($table, $variables = array(), $where = array(), $limit = null, $queryPrint = 0)
    {

        $sql = 'UPDATE ' . $table . ' SET ';
        foreach ($variables as $field => $value) {
            if ((strpos($value, '|_|_') > -1) && (strpos($value, '_|_|') > -1)) {
                $updates[] = "`$field` = '" . $this->filter(str_replace('_|_|', "",
                      str_replace('|_|_', "", $value))) . "'";
            } else {
                if (is_numeric($value)) {
                    $updates[] = "`$field` = " . $this->filter($value);
                } else {
                    $updates[] = "`$field` = '" . $this->filter($value) . "'";
                }
            }
        }
        $sql .= implode(', ', $updates);

        foreach ($where as $field => $value) {
            $value = $value;

            $clause[] = "$field = '" . $this->filter($value) . "'";
        }
        $sql .= ' WHERE ' . implode(' AND ', $clause);

        if ($limit !== null) {
            $sql .= ' LIMIT ' . $limit;
        }
        if ($queryPrint == 1) {
            echo $sql;
        }
        $query = mysqli_query($this->link, $sql);

        if (mysqli_error($this->link)) {
            $this->log_db_errors(mysqli_error($this->link), $sql, 'Fatal');
            return false;
        } else {
            //create update log if user logged in
            if (isset($_SESSION['user_id'])) {
                $this->accessLog($table, 'update', "$sql");
            }
            return true;
        }
    }


    /**
     * Delete data from table
     *
     * @access public
     * @param string table name
     * @param array where parameters table column => column value
     * @param int max number of rows to remove.
     * @return bool
     *
     */
    public function delete($table, $where = array(), $limit = null)
    {
        $sql = 'DELETE FROM ' . $table;
        foreach ($where as $field => $value) {
            $value = $value;
            $clause[] = "$field = '$value'";
        }
        $sql .= ' WHERE ' . implode(' AND ', $clause);

        if ($limit !== null) {
            $sql .= ' LIMIT ' . $limit;
        }

        $query = mysqli_query($this->link, $sql);

        if (mysqli_error($this->link)) {
            //return false; //
            $this->log_db_errors(mysqli_error($this->link), $sql, 'Fatal');
            return false;
        } else {
            //create delete log if user logged in
            if (isset($_SESSION['user_id'])) {
                $this->accessLog($table, 'delete', "$sql");
            }
            return true;
        }
    }

    public function accessLog($table, $action, $sql)
    {
        global $org, $org_id, $org;
        $databaseName = $this->db_name;
        $nebula_db = $this->getNebulaDB();

        $user_id = $_SESSION["user_id"];
        //keep record of updated page
        $db_arr = array(
           "acc_user_id" => $user_id,
           "acc_org_id" => $org_id,
           "acc_channel_id" => $org['channel_id'],
           "acc_logtype" => 'CMS',
           "acc_module" => '',
           "acc_description" => $sql,
           "acc_tableName" => $table,
           "acc_action" => $action,
           "acc_database" => $databaseName
        );

        return $nebula_db->insert_log('access_log', $db_arr, 0, 1);
    }


    /**
     * Get last auto-incrementing ID associated with an insertion
     *
     * @access public
     * @param none
     * @return int
     *
     */
    public function lastid()
    {
        return mysqli_insert_id($this->link);
    }

    /**
     * Get number of fields
     *
     * @access public
     * @param query
     * @return int
     */
    public function num_fields($query)
    {
        $query = $this->link->query($query);
        return mysqli_num_fields($query);
        mysqli_free_result($query);
    }

    /**
     * Get field names associated with a table
     *
     * @access public
     * @param query
     * @return array
     */
    public function list_fields($query)
    {
        $query = $this->link->query($query);
        return mysqli_fetch_fields($query);
        mysqli_free_result($query);
    }

    /**
     * Truncate entire tables
     *
     * @access public
     * @param array database table names
     * @return int number of tables truncated
     *
     */
    public function truncate($tables = array())
    {
        if (!empty($tables)) {
            $truncated = 0;
            foreach ($tables as $table) {
                $truncate = 'TRUNCATE TABLE `' . trim($table) . '`';
                mysqli_query($this->link, $truncate);
                if (!mysqli_error($this->link)) {
                    $truncated++;
                }
            }
            return $truncated;
        }
    }

    /**
     * Output results of queries
     *
     * @access public
     * @param string variable
     * @param bool echo [true,false] defaults to true
     * @return string
     *
     */
    public function display($variable, $echo = true)
    {
        $out = '';
        if (!is_array($variable)) {
            $out .= $variable;
        } else {
            $out .= '<pre>';
            $out .= print_r($variable, true);
            $out .= '</pre>';
        }
        if ($echo === true) {
            echo $out;
        } else {
            return $out;
        }
    }

    /**
     * Function to execute dynamic user query
     *
     * @access public
     * @param string
     * @return array
     *
     */
    public function execute_dynamic_query($query)
    {
        // Restrict Delete/Update/Insert queries
        $restricted_keywords = array('delete', 'truncate', 'insert', 'update');
        if (count(array_intersect(array_map('strtolower', explode(' ', $query)), $restricted_keywords)) > 0) {
            $error_msg = 'Query contains restricted keywords. Only SELECT queries are allowed.';
            return $error_msg;
        }
        $row = array();
        $query = $this->link->query($query);
        if (mysqli_error($this->link)) {
            return $this->log_db_errors(mysqli_error($this->link), $query, 'Fatal');
        } else {
            if (is_object($query)) {
                // Select query
                while ($r = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    $row[] = $r;
                }
                mysqli_free_result($query);
                return $row;
            } else {
                // Insert/Update/Delete Query
                return 'success';
            }

        }
    }

    /**
     * Disconnect from db server
     * Called automatically from __destruct function
     */
    public function disconnect()
    {
        mysqli_close($this->link);
    }
}