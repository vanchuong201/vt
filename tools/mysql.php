<?php
class Mysql {
	private static $instance = '';
	private static $stt = 0;
	private $rs = null;
	private $conn = null;
	
	public function __construct(){
        $this->connect();
	}
	
	public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Mysql();
        }
        return self::$instance;
    }

    public function connect(){
        if( $this->conn ) {
            @mysql_free_result ( $this->rs );
            @mysql_close ( $this->conn );
        }

        $conn=@mysql_pconnect(MYSQLHOST, MYSQLUSER, MYSQLPASS) or die("Kết nối không thành công đến cơ sở dữ liệu ".mysql_error());
        mysql_select_db(MYSQLDATABASE, $conn) or die("Lỗi chọn cơ sở dữ liệu ".mysql_error());
        mysql_query("SET NAMES 'UTF8'", $conn);
        $this->conn = $conn;
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
        $strExplain = '';
        self::$stt++;
        $strExplain = '<table border=1 width="99%"><thead><tr><th width="20">'.self::$stt.'</th><th width="20">id</th><th width="100">select_type</th><th width="100">table</th><th width="70">type</th><th width="100">possible_keys</th><th width="50">key</th><th width="20">key_len</th><th width="200">ref</th><th width="100">rows</th><th>Extra</th></tr></thead>';
        $strExplain .= '<tr><th colspan="11">'.$sql.'</th></tr>';

//        $reExplain = mysql_query( "EXPLAIN $sql", $this->conn );
//        while($r = @mysql_fetch_assoc($reExplain)){
//            $strExplain .= "<tr style='background:#fff'>
//                <td>{$r['id']}</td>
//                <td>{$r['select_type']}</td>
//                <td>{$r['table']}</td>
//                <td>{$r['type']}</td>
//                <td>{$r['possible_keys']}</td>
//                <td>{$r['key']}</td>
//                <td>{$r['key_len']}</td>
//                <td>{$r['ref']}</td>
//                <td>{$r['rows']}</td>
//                <td>{$r['Extra']}</td></tr>";
//        }
        $strExplain .= '</table>';

        //Thời gian bắt đầu query
        $time_start = microtime();
//        $result = mysql_query("SET NAMES utf8", $this->conn);
//        mysql_set_charset('utf8');
        $result = mysql_query($sql, $this->conn);
        //Thời gian kết thuc query
        $time_end = microtime();

//		Debug::setDebug( $sql.$strExplain, $time_start, $time_end);
		if($result) {
			$this->rs = $result;
//            echo $strExplain;
			return $result;
		} else {
//            Debug::setDebug( print_r( mysql_error(), true).' : '.$sql, $time_start, $time_end);
//			LogEvent::writeLog( print_r( mysql_error(), true ).' : '.$sql);
//            echo $strExplain;
            print_r(mysql_error());
			return false;
		}
	}
	
	/**
	* Ham tra ve so mau tin
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function getNumRow($result) {
		if($numRow = mysql_num_rows($result)) {
			mysql_free_result($result);
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
            while($fetchRow = mysql_fetch_assoc($result)) {
    			if( isset($fetchRow['id']) ) {
    				$aryRow[ $fetchRow['id'] ] = $fetchRow;
    			} else {
    				$aryRow[] = $fetchRow;
    			}
    		}
    		mysql_free_result($result);
        }
		return $aryRow;
	}
	
	/**
	* Ham tra ve mang 1 dong mau tin
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function getOneRow($result) {
		return mysql_fetch_assoc($result);
	}
	/**
	* Ham tra ve mang 1 mau tin
	* Create by: Tran Thanh Tuan
	* 08/06/2011
	**/
	public function getOne($result) {
		if($fetchRow = mysql_fetch_row($result)) {
			mysql_free_result($result);
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
		$field = mysql_field_name($result, 0);
		$aryCol = array();
		while($fetchCol = mysql_fetch_assoc($result)) {
			$aryCol[] = $fetchCol[$field];
		}
		//mysql_free_result($fetchCol);
		return $aryCol;
	}
    
    /**
     * $ignore = true: bỏ qua thông báo lỗi
     * */
    public function insert($table, $aryParam, $return_insert_id = false, $replace = false, $ignore = false ) {
        $sql = $this->implode_field_value($aryParam);

		$cmd = $replace ? 'REPLACE INTO' : 'INSERT '.($ignore ? 'IGNORE' : '').' INTO';
		$return = $this->query( "$cmd $table SET $sql" );
        if( $return ) {
            return $return_insert_id ? mysql_insert_id() : $return;
        }
		return false;
    }
    
    function build_sql($sql, $arySql=null) {
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
		return mysql_insert_id($this->rs);
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
		$res = $this->query( $this->replacePrefix("$cmd $table SET $sql WHERE $where") );//, $unbuffered ? 'UNBUFFERED' : '');
		return $res;
	}

    function fetch_all( $table, $ar ) {
        $where = $this->implode_field_value( $ar, 'AND' );
        $sql = "SELECT * FROM $table WHERE $where";
        if ($sql) {
           $this->rs = $this->query ( $sql );
        }

        if ($this->rs) {
            $result = array ();
            while ( $row = @mysql_fetch_assoc ( $this->rs ) ) {
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
