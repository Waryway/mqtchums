<?php
namespace mqtchums\calendar;

class Day {
    private $eventList;
    /**
     * @var \DateTime
     */
    private $date;

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function AddEvent(Event $event)
    {
        $this->eventList[] = $event;
    }

    public function RemoveEvent(Event $event)
    {
        foreach($this->eventList as $key => $existingEvent)
        {
            if($event->isDuplicate($existingEvent))
            {
                unset($this->eventList[$key]);
            }
        }
    }

    public function GetEventList()
    {
        return $this->eventList;
    }

    public function ClearEventList()
    {
        $this->eventList = [];
    }
    
    public function BuildEventList()
    {
        Database::
    }
    

    public function __construct(\DateTime $date)
    {
        $this->setDate($date);
        $this->
    }
}
?>