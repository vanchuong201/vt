<?php
class Msqli {
	private static $instance = '';
	private $rs = null;
	private $conn = null;
	
	public function __construct(){
		$conn=mysqli_connect(MYSQLHOST, MYSQLUSER, MYSQLPASS) or die("Kết nối không thành công đến cơ sở dữ liệu ".mysqli_error());
		mysqli_select_db( $conn, MYSQLDATABASE ) or die("Lỗi chọn cơ sở dữ liệu ".mysqli_error());
		mysqli_query( $conn, "SET NAMES 'UTF8'" );
		$this->conn = $conn;
	}
	
	public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Msqli();
        }
        return self::$instance;
    }
    
	/**
	* Ham thực hiện câu truy vấn
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function setQuery($sql, $arySql = null) {
		$sql = $this->build_sql($sql, $arySql);
        return $this->query($sql);
	}
    
    public function query( $sql ) {
        //Thời gian bắt đầu query
        $time_start = microtime();
        $result = mysqli_query( $this->conn, $sql);
        //Thời gian kết thuc query
        $time_end = microtime();

//		Debug::setDebug( $sql.$strExplain, $time_start, $time_end);
		if($result) {
			$this->rs = $result;
			return $result;
		} else {
//            if( Debug::$debug == 1) {
//                print_r( mysqli_error($this->conn) );
//            }
//            Debug::var_dump( print_r( mysqli_error($this->conn)).' : '.$sql );
			LogEvent::writeLog( print_r( mysqli_error($this->conn), true ).' : '.$sql);
			return false;
		}
	}
	
	/**
	* Ham tra ve so mau tin
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function getNumRow($result) {
		if($numRow = mysqli_num_rows($result)) {
			mysqli_free_result($result);
			return $numRow;
		}
		else { return 0;}
	}
		
	/**
	* Ham tra ve mang cac mau tin
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function getRow($result) {
		$aryRow = array();
        if( $result ) {
            while($fetchRow = mysqli_fetch_assoc($result)) {
    			if( isset($fetchRow['id']) ) {
    				$aryRow[ $fetchRow['id'] ] = $fetchRow;
    			} else {
    				$aryRow[] = $fetchRow;
    			}
    		}
    		mysqli_free_result($result);
        }
		return $aryRow;
	}
	
	/**
	* Ham tra ve mang 1 dong mau tin
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function getOneRow($result) {
		return mysqli_fetch_assoc($result);
	}
	/**
	* Ham tra ve mang 1 mau tin
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function getOne($result) {
		if($fetchRow = mysqli_fetch_row($result)) {
			mysqli_free_result($result);
			return $fetchRow[0];
		}
		return false;
	}
	
	/**
	* Ham tra ve mang cac mau tin
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function getCol($result) {
//		$field = mysqli_field_name($result, 0);
		$aryCol = array();
		while($fetchCol = mysqli_fetch_assoc($result)) {
			$aryCol[] = $fetchCol;
		}
		//mysqli_free_result($fetchCol);
		return $aryCol;
	}
    
    /**
     * $ignore = true: bỏ qua thông báo lỗi
     * */
    public function insert($table, $aryParam, $return_insert_id = false, $replace = false, $ignore = false ) {
        $sql = $this->implode_field_value($aryParam);

		$cmd = $replace ? 'REPLACE INTO' : 'INSERT '.($ignore ? 'IGNORE' : '').' INTO';
		$return = $this->query( DB::replacePrefix("$cmd $table SET $sql") );
        if( $return ) {
            return $return_insert_id ? mysqli_insert_id($this->conn) : $return;
        }
		return false;
    }
    
    function build_sql($sql, $arySql=null) {
//        $sql = DB::replacePrefix($sql);
		return $this->asprintf($sql, $arySql);
    }
    
    function implode_field_value($array, $glue = ',') {
		$sql = $comma = '';
		foreach ($array as $k => $v) {
			$sql .= $comma."`$k`='$v'";
			$comma = $glue;
		}
		return $sql;
	}
    function insert_id() {
		return mysqli_insert_id($this->rs);
	}
    function update($table, $data, $condition, $unbuffered = false, $low_priority = false) {
		$sql = $this->implode_field_value($data);
		$cmd = "UPDATE ".($low_priority ? 'LOW_PRIORITY' : '');
		$where = '';
		if(empty($condition)) {
			$where = '1';
		} elseif(is_array($condition)) {
			$where = $this->implode_field_value($condition, ' AND ');
		} else {
			$where = $condition;
		}
		$res = $this->query( DB::replacePrefix("$cmd $table SET $sql WHERE $where") );//, $unbuffered ? 'UNBUFFERED' : '');
		return $res;
	}

    function fetch_all( $table, $ar ) {
        $where = $this->implode_field_value( $ar, 'AND' );
        $sql = "SELECT * FROM $table WHERE $where";
        if ($sql) {
           $this->rs = $this->query ( DB::replacePrefix( $sql ) );
        }

        if ($this->rs) {
            $result = array ();
            while ( $row = @mysqli_fetch_assoc ( $this->rs ) ) {
                if (isset ( $row ['id'] ))
                    $result [$row ['id']] = $row;
                else
                    $result [] = $row;
            }

            return $result;
        } else {
            return false;
        }
    }
    function asprintf() {
        $aryData = func_get_args();
        $format = array_shift($aryData);
        if (is_array($aryData[0])) {
            //$aryData = array_map('mysql_real_escape_string', $aryData[0]);
            //$aryData = array_map('addslashes', $aryData[0]);
            $aryData = $aryData[0];
        }
        $sql = vsprintf($format, $aryData);
        LogEvent::writeLog($sql);
        return $sql;
    }
}
?>
