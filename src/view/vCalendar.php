<?php
namespace mqtchums\view;

use mqtchums\calendar\Calendar;
use mqtchums\twig\TwigLoader;

class vCalendar implements \mqtchums\interfaces\iView
{
    use \mqtchums\traits\Page;

    public function render()
    {
        echo $this->loadTwig();
    }

    public function loadTwig()
    {
        $TwigLoader = new TwigLoader();
        
        $year = $this->Session->getVariable('CalendarYear');
        $timeString = (($year === null) ? 'now' : $year .'-'. $this->Session->getVariable('CalendarMonth') . '-01 00:00:00.000000');
        $Time = new \DateTime($timeString);
        $month = $Time->format('m');
        $year = $Time->format('Y');
        $timeString = $year .'-'. $this->Session->getVariable('CalendarMonth') . '-01 00:00:00.000000';
        $Time = new \DateTime($timeString);

        $this->Session->RegisterVariable('CalendarYear', $year);
        $this->Session->RegisterVariable('CalendarMonth', $month);


        $Calendar = new Calendar($month, $year);
        $DayList = $Calendar->getDayList();
        $dayOfWeek = $Time->format('w');

        $rowLength = 7;
        $colLength = 6;

        $data = [];
        for ($row = 0; $row <  $colLength; $row++ )
        {
            for($col = 0; $col < $rowLength; $col++)
            {
                $monthIndex = ($row * $rowLength + $col) - ($dayOfWeek);

                $dayString = '';
                if(isset($DayList[$monthIndex]))
                {
                    $dayString .= $monthIndex . PHP_EOL;
                        /* @var $Day \mqtchums\calendar\Day */
                    $Day = $DayList[$monthIndex];
                    $eventList = $Day->GetEventList();

                    /* @var $event  \mqtchums\calendar\Event */
                    foreach($eventList as $event)
                    {
                        $dayString .= $event->getName() . PHP_EOL;
                    }

                }
                $data[$monthIndex + ($dayOfWeek)] = htmlentities($dayString);
            }
        }

        return $TwigLoader->render('calendar.twig', ['days'=> $data]);
    }
}

?>
