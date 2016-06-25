<?php
namespace mqtchums\calendar;

class Day {
    /**
     * @var Database
     */
    private $Database;

    private $eventList;

    /**
     * @var \DateTime
     */
    private $date;

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
    
    public function BuildEventList(\DateTime $date)
    {
        $this->eventList = [];
        $eventList = $this->getDatabase()->GetEventList($date);
        foreach($eventList as $item)
        {
            $this->eventList[] = new Event($item['name'], $item['description'], $item['starttime'], $item['length']);
        }
    }
    

    public function __construct(\DateTime $date)
    {
        $this->setDatabase(new Database());
        $this->setDate($date);
        $this->BuildEventList($date);
    }
}
?>