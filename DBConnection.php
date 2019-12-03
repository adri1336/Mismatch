<?php
class DBConnection
{    
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $error = "";

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;";
        $options = array
        (
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try
        {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        catch(PDOException $e)
        {
            $this->error = $e->getMessage();
            echo $this->error;
        }
        return $this->error;
    }

    public function getDbh()
    {
        return $this->dbh;
    }
    
    public function __toString()
    {
        return $this->error;
    }

    public function runQuery($sql)
    {
        try
        {
            $count = $this->dbh->exec($sql);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $count;
    }

    public function getQuery($sql)
    {
        $stmt = $this->dbh->query($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt;  
    }
}
?>