<?php
namespace mqtchums\calendar;

class Event {

    /**
     * @var \DateTime
     */
    private $startTime;
    /**
     * @var float
     */
    private $length;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param float $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function __construct($name, $description, $startTime, $length)
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setStartTime($startTime);
        $this->setLength($length);
    }
    
    public function isDuplicate(Event $event)
    {
        if($this->getName() !== $event->getName() || $this->getDescription() !== $event->getDescription() || $this->getLength() !== $event->getLength() || $this->getStartTime()->diff($event->getStartTime())->s !== 0)
        {
            return false;
        }
        return true;
    }
}
?>