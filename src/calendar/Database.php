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

    public function GetEventList(\DateTime $date)
    {
        $query = <<<QUERY
select * from calendarevent where eventdate = :EventDate;
QUERY;

        return $this->dbConnection->Query($query, [$date]);
    }

    public function GetDayList($month, $year)
    {
        $endMonth = ($month == 12 ? 1 : $month+1) ;
        $endYear = ($endMonth == 1 ? $year +1 : $year);
        $start = new \DateTime($year.'-'.$month.'-'.'01');
        $end = new \DateTime($endYear.'-'.$endMonth.'-'.'01');

        $query = <<<QUERY
select * from calendarevent 
where eventdate >= :Start and eventdate < :End 
order by eventdate;
QUERY;

        return $this->dbConnection->Query($query, [$start, $end]);
    }
}
?>