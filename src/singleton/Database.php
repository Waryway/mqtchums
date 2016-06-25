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
        $this->Db = null;
        try {
            $this->Db = new \PDO('mysql:host=' . \mqtchums\Configuration::$DB_SERVER . ';',
                \mqtchums\Configuration::$DB_SERVER_USERNAME, \mqtchums\Configuration::$DB_SERVER_PASSWORD);
            $this->InitializeDatabase();
        } catch (\Exception $e) {
            error_log('Unable to connect to the Database! ' . __CLASS__ . '::' . __METHOD__ . '(' . __LINE__ . ')');
            error_log(print_r($e, true));
            $this->Db = null;
        }
    }

    private function InitializeDatabase()
    {

        if ($this->Db->exec('use ' . \mqtchums\Configuration::$DB_DATABASE) === false) {

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
    public function Query($query, array $params)
    {
        if ($this->Db === null) {
            $this->Connect();
        }

        $params = $this->ParamsToDatabaseTypes($params);


        $statement = $this->Db->prepare($query);

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

        if ($result) {
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        $statement->closeCursor();

        return $result;
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
            if(\is_object($param) && (\get_class($param) === '\DateTime'))
            {
                /* @var $param \DateTime */

                $params[$key] = $param->getTimestamp();
            }
        }

        return $params;
    }

}

?>
