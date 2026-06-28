<?php
declare(strict_types=1);

namespace mateocollar\profiler;

use mateocollar\profiler\utils\Color;

class ProfilerEntry{

    private $name;

    private $calls = 0;

    private $startTime = null;

    private $lastTime = 0;

    private $totalTime = 0;

    private $minTime = null;

    private $maxTime = 0;

    public function __construct($name){
        $this->name = $name;
    }

    public function start(){
        $this->startTime = microtime(true);
    }

    public function end(){

        if($this->startTime === null){
            return false;
        }

        $time = microtime(true) - $this->startTime;

        $this->lastTime = $time;
        $this->totalTime += $time;
        $this->calls++;

        if($this->minTime === null || $time < $this->minTime){
            $this->minTime = $time;
        }

        if($time > $this->maxTime){
            $this->maxTime = $time;
        }

        $this->startTime = null;
        return true;
    }

    public function getAverageTime(){
        return $this->calls === 0 ? 0 : $this->totalTime / $this->calls;
    }

    public function getCalls(){
        return $this->calls;
    }

    public function getLastTime(){
        return $this->lastTime;
    }

    public function getTotalTime(){
        return $this->totalTime;
    }

    public function getMinTime(){
        return $this->minTime;
    }

    public function getMaxTime(){
        return $this->maxTime;
    }

    public function getName(){
        return $this->name;
    }

    public function getMilliseconds(){
        return $this->getLastTime() * 1000;
    }

    public function getSeconds(){
        return $this->getLastTime();
    }

    public function getTotalMilliseconds(){
        return $this->getTotalTime() * 1000;
    }

    public function getAverageMilliseconds(){
        return $this->getAverageTime() * 1000;
    }

    public function getLastMilliseconds(){
        return $this->getLastTime() * 1000;
    }

    public function getMinMilliseconds(){
    	return $this->minTime === null? 0 : $this->getMinTime() * 1000;
	}

    public function getMaxMilliseconds(){
        return $this->getMaxTime() * 1000;
    }

    public function isRunning(){
        return $this->startTime !== null;
    }

    public function reset(){
        $this->calls = 0;
        $this->startTime = null;
        $this->lastTime = 0;
        $this->totalTime = 0;
        $this->minTime = null;
        $this->maxTime = 0;
    }

	public function toDetailedString(){
	    return "[Profiler] ".$this->getName()."\n".
	           "Calls : ".$this->getCalls()."\n".
	           "Last  : ".round($this->getLastMilliseconds(), 2)."ms\n".
	           "Avg   : ".round($this->getAverageMilliseconds(), 2)."ms\n".
	           "Min   : ".round($this->getMinMilliseconds(), 2)."ms\n".
	           "Max   : ".round($this->getMaxMilliseconds(), 2)."ms\n".
	           "Total : ".round($this->getTotalMilliseconds(), 2)."ms";
	}
	
	public function __toString(){
	    return "[Profiler] ".$this->getName()." took ".round($this->getMilliseconds(), 2)."ms";
	}
}
