<?php
namespace mqtchums\view;

use mqtchums\calendar\Calendar;
use mqtchums\twig\TwigLoader;

class vCalendar implements \mqtchums\interfaces\iView
{
    use \mqtchums\traits\Page;

    public function render()
    {
        error_log('Session: ' . print_r($_SESSION, true));

        echo $this->loadTwig();
    }

    public function loadTwig()
    {
        $TwigLoader = new TwigLoader();
        $currentTime = new \DateTime('now');
        $currentYear = $this->Session->IsRegistered('CalendarYear') ? $this->Session->getVariable('CalendarYear') : $currentTime->format('Y');
        $currentMonth = $this->Session->IsRegistered('CalendarMonth') ? $this->Session->getVariable('CalendarMonth') : $currentTime->format('m');


        $year = isset($this->args['CalendarYear']) ? $this->args['CalendarYear'] : $currentYear;
        $month = isset($this->args['CalendarMonth']) ? $this->monthtoint($this->args['CalendarMonth']) : $currentMonth;
        $monthNumber = $month;
        $this->Session->RegisterVariable('CalendarYear', $year);
        $this->Session->RegisterVariable('CalendarMonth', $month);
        
        $Time = new \DateTime( $year .'-'. $month . '-01 00:00:00.000000');

        $Calendar = new Calendar($month, $year);
        $DayList = $Calendar->getDayList();
        $dayOfWeek = $Time->format('w');


        $month = $Time->format('F');
        $year = $Time->format('Y');
        $rowLength = 7;
        $colLength = 6;

        $data = [];
        for ($row = 0; $row <  $colLength; $row++ )
        {
            for($col = 0; $col < $rowLength; $col++)
            {
                $monthIndex = ($row * $rowLength + $col) - ($dayOfWeek);

                $dayString = '';
                $data[$monthIndex + ($dayOfWeek)] = [];

                if(isset($DayList[$monthIndex]))
                {
                    $data[$monthIndex + ($dayOfWeek)][] = $monthIndex;
                    //$dayString .= $monthIndex . PHP_EOL;
                        /* @var $Day \mqtchums\calendar\Day */
                    $Day = $DayList[$monthIndex];
                    $eventList = $Day->GetEventList();

                    /* @var $event  \mqtchums\calendar\Event */
                    foreach($eventList as $event)
                    {
                      //  $dayString .= $event->getName() . PHP_EOL;
                        $data[$monthIndex + ($dayOfWeek)][] = $event->getName();
                    }

                }

            }
        }
        error_log(print_r($_SESSION, true));
        return $TwigLoader->render('calendar.twig', ['days'=> $data, 'currentmonth' => $month, 'nextMonth' => $this->inttomonth($monthNumber + 1), 'previousMonth' => $this->inttomonth($monthNumber-1), 'nextMonthYear'=>($monthNumber==12?$year+1:$year), 'previousMonthYear'=> $monthNumber==1 ? $year-1:$year, 'year' => $year]);
    }

    private function monthtoint($month)
    {
        $ary = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        for($i =1; $i<=12; $i++)
        {
            if($ary[$i-1] === $month)
            {
                return $i;
            }
        }
    }

    private function inttomonth($int)
    {

        if($int == 0 )
        {
            $int = 12;
        }
        if($int == 13)
        {
            $int = 1;
        }
        $ary = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return $ary[$int-1];
    }
}

?>
