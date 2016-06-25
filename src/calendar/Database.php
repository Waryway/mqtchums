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
        $start = $date;
        $end = clone($date);
        $end->add(new \DateInterval('P1D'));
        $query = <<<QUERY
select * from calendarevent 
where starttime >= :Start and starttime < :End 
order by starttime;
QUERY;

        $result = $this->dbConnection->Query($query, ['Start' => $start , 'End'=> $end]);
        return $result;
    }

    public function GetDayList($month, $year)
    {
        $endMonth = ($month == 12 ? 1 : $month+1) ;
        $endYear = ($endMonth == 1 ? $year +1 : $year);
        $start = new \DateTime($year.'-'.$month.'-'.'01');
        $end = new \DateTime($endYear.'-'.$endMonth.'-'.'01');
        $dayList = [];
        $dateAddInterval = new \DateInterval('P1D');
        $end->sub($dateAddInterval);

        do
        {
            $dayList[$start->format('j')] = new Day($start);
            $start->add($dateAddInterval);
            $interval = date_diff($start, $end);
        } while($interval->invert !==1);

        return $dayList;
    }
}
?>