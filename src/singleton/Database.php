<?php
namespace mqtchums\singleton;

class Database
{
    use \mqtchums\traits\Singleton;
    /**
     * @var \PDO
     */
    public $Db;

    /**
     * Connect to the DB. Only one DB connection is allowed at a time for a single thread.
     */
    public function Connect()
    {
        //$this->Db = null;
        try {
            $this->Db = new \PDO('mysql:host=' . \mqtchums\Configuration::$DB_SERVER . ';',
                \mqtchums\Configuration::$DB_SERVER_USERNAME, \mqtchums\Configuration::$DB_SERVER_PASSWORD);
            $this->Db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->InitializeDatabase();
        } catch (\PDOException $e) {
            error_log('Unable to connect to the Database! ' . __CLASS__ . '::' . __METHOD__ . '(' . __LINE__ . ')');
            error_log(print_r($e, true));
            error_log(print_r(`whoami`, true));
            //$this->Db = null;
        }
    }

    private function InitializeDatabase()
    {
        try {
            $connected = $this->Db->exec('use ' . \mqtchums\Configuration::$DB_DATABASE);
        } catch (\PDOException $e)
        {
            $connected = false;
        }

        if ($connected === false) {

            echo 'Creating database '.\mqtchums\Configuration::$DB_DATABASE;
            $this->Db->exec('create database ' . \mqtchums\Configuration::$DB_DATABASE);

            if ($this->Db->exec('use ' . \mqtchums\Configuration::$DB_DATABASE) === false) {
                throw new \Exception('Unable to find or create the ' . \mqtchums\Configuration::$DB_DATABASE);
            }
        }

        if(!$this->CheckDbTableExist('calendarevent')){
            print_r('creating calendar event');
            $this->Db->exec(<<<QUERY
CREATE TABLE calendarevent (
    calendareventid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    starttime BIGINT, 
    length INT,
    name VARCHAR(100),
    description VARCHAR(200)
);
QUERY
            );
        }
    }

    private function CheckDbTableExist($tableName)
    {
        $params = [
            'dbName' => \mqtchums\Configuration::$DB_DATABASE,
            'tableName' => $tableName
        ];
        $result = $this->Query('SELECT * FROM information_schema.tables WHERE table_schema = :dbName AND table_name = :tableName LIMIT 1;', $params);
        return count($result) === 1;
    }

    /**
     * Kill DB connection
     */
    public function CloseConnection()
    {
        $this->Db = null;
    }

    /**
     * The query is pretty normal, just place :varname instead of the variable you want to use. Then, use an associative array for the $params.
     *
     * $query = 'Select * from SomeTable st where st.SomeVar = :SomeVar'
     * $params = [':SomeVar' => 42];
     * -or-
     * $params = array(':SomeVar' => 42);
     *
     * @param string $query
     * @param array $params
     *
     * @return array
     */
    public function Query($query, array $params, $debugQuery = false)
    {
        $backTrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        //$query = '/* ' . $backTrace[1]['class'] .'::' .$backTrace[1]['function'] . '() */ ' . $query;

        if ($this->Db === null) {
            $this->Connect();
        }

        $params = $this->ParamsToDatabaseTypes($params);
        $statement = $this->Db->prepare($query);

        if($debugQuery) {
            $string = 'Query Debug from :'.  $backTrace[0]['class'].'::'. $backTrace[0]['function'] .'() in ' . $backTrace[0]['file'] . '('.$backTrace[0]['line'].')' . PHP_EOL;
            error_log($string . print_r($this->DebugParams($query, $params), true));
        }
        try {
            $result = $statement->execute($params);
        } catch (\Exception $e) {
            error_log('Following Query failed! (');
            error_log($query);
            error_log(') with parameters (');
            error_log(print_r($params, true));
            error_log(')' . __CLASS__ . '::' . __METHOD__ . '(' . __LINE__ . ')');

            $result = false;
        }

        if ($result === true) {
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }
        else $results = false;

        $statement->closeCursor();

        return $results;
    }

    /**
     * Magically convert known objects to database specific formats.
     *
     * @param array $params
     * @return array
     */
    private function ParamsToDatabaseTypes(array $params)
    {
        foreach($params as $key => $param)
        {
            if(\is_object($param) && (\get_class($param) === 'DateTime'))
            {
                /* @var $param \DateTime */

                $params[$key] = $param->getTimestamp();

            }
        }

        return $params;
    }


    /**
     * @credit mark at manngo dot net via http://php.net/manual/en/pdostatement.debugdumpparams.php
     *
     * @param $query
     * @param $params
     * @return mixed
     */
    private function DebugParams($query,$params) {
        $indexed = ($params==array_values($params));
        foreach ($params as $name=>$value) {
            if(is_string($value))
            {
                $value = "'$value'";
            }

            if($indexed)
            {
                $query=preg_replace('/\?/', $value, $query, 1);
            }

            else $query = str_replace(":$name", $value, $query);
        }
        return $query;
    }

}

?>
