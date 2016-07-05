<?php
namespace mqtchums\calendar;

class Calendar {

    /**
     * @var array of Day
     */
    private $DayList; // 42!
    /**
     * @return array
     */
    public function getDayList()
    {
        return $this->DayList;
    }

    /**
     * @param array $Days
     */
    public function setDayList($Days)
    {
        $this->DayList = $Days;
    }
    /**
     * @var int
     */
    private $Year;

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->Year;
    }

    /**
     * @param int $Year
     */
    public function setYear($Year)
    {
        $this->Year = $Year;
    }

    /**
     * @var int
     */
    private $Month;

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->Month;
    }

    /**
     * @param int $Month
     */
    public function setMonth($Month)
    {
        $this->Month = $Month;
    }

    /**
     * @var Database
     */
    private $Database;

    /**
     * @param Database $Database
     */
    private function setDatabase(Database $Database)
    {
        $this->Database = $Database;
    }

    /**
     * @return Database
     */
    private function getDatabase()
    {
        return $this->Database;
    }


    public function __construct($month, $year)
    {
        $this->setDatabase(new Database());
        $this->setMonth($month);
        $this->setYear($year);
        $this->BuildDayList($month, $year);
    }

    private function BuildDayList($month, $year)
    {
       
        $this->setDayList($this->getDatabase()->GetDayList($month, $year));
    }
}
?>