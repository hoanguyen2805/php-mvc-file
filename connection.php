<?php

class DB
{
    protected static $connectionInstance = null;
    protected $username = "root";
    protected $password = "";
    protected $host = "localhost:8081";
    protected $database = "phonestore";
    protected $_sql= "";

    public function __construct()
    {
        $this->connect();
    }

    /**
     *
     * Hoa
     * Create at
     * connect to database
     * @return PDO
     *
     */
    public function connect()
    {
        if (!isset(self::$instance)) {
            try {
                self::$connectionInstance = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database,
                    $this->username, $this->password);
                // để hiển thị tiếng việt
                self::$connectionInstance->exec("SET NAMES 'utf8'");
                // ném ra ngoại lệ khi gặp lỗi đồng thời tạo ra PHP Warning
                self::$connectionInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
        }
        return self::$connectionInstance;
    }



    public function setQuery($sql) {
        $this->_sql = $sql;
    }

    //Function execute the query
    public function execute($options=array()) {
        // dùng prepared statement để tránh bị tấn công SQL Injection
        // prepare() tạo ra một Prepared Statement
        $this->_cursor = $this->_dbh->prepare($this->_sql);
        //neu co tham so
        if($options) {  //If have $options then system will be tranmission parameters
            for($i=0;$i<count($options);$i++) {
                // truyền giá trị cho các tham số trong _sql
                $this->_cursor->bindParam($i+1,$options[$i]);
            }
        }
        // thực thi prepared statement
        $this->_cursor->execute();
        return $this->_cursor;
    }

    //Funtion load datas on table
    public function loadAllRows($options=array()) {
        // nếu không có tham số
        if(!$options) {
            // nếu truy vấn lỗi
            if(!$result = $this->execute())
                return false;
        }
        // nếu có tham số
        else {
            // nếu truy vấn lỗi
            if(!$result = $this->execute($options))
                return false;
        }
        // fetchAll la lay nhieu dong du lieu, FETCH_OBJ la tra ve 1 object cua stdClass
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    //Funtion load 1 data on the table
    public function loadRow($option=array()) {
        // nếu không có tham số
        if(!$option) {
            // nếu truy vấn lỗi
            if(!$result = $this->execute())
                return false;
        }
        else {
            // nếu truy vấn lỗi
            if(!$result = $this->execute($option))
                return false;
        }
        // truy vấn thành công
        return $result->fetch(PDO::FETCH_OBJ);//tra ve 1 object cua stdClass
    }

    //Function count the record on the table
    public function loadRecord($option=array()) {
        if(!$option) {
            if(!$result = $this->execute())
                return false;
        }
        else {
            if(!$result = $this->execute($option))
                return false;
        }
        return $result->fetch(PDO::FETCH_COLUMN);
    }

    public function getLastId() {
        return $this->_dbh->lastInsertId();
    }

    public function disconnect() {
        $this->_dbh = NULL;
    }
}

?>