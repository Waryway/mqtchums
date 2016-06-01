<?php
namespace mqtchums\calendar;

class Database {

    /**
     * @var \mqtchums\singleton\Database
     */
    private $dbConnection;

    private function Initialize()
    {
        
    }

    public function __construct()
    {
        $this->dbConnection = \mqtchums\singleton\Database::inst();
        
    }
}
?>