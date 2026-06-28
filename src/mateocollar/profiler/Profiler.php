<?php
declare(strict_types=1);

namespace mateocollar\profiler;

use pocketmine\plugin\PluginBase;
use mateocollar\profiler\ProfilerEntry;
use pocketmine\Server;
use mateocollar\profiler\UpdateChecker;

class Profiler extends PluginBase{

    /** @var ProfilerEntry[] */
    private static $entries = [];
    private static $autoDump = false;
    private static $logger = null;

    public function onEnable(
    ){
        self::$logger = Server::getInstance()->getLogger();
        UpdateChecker::init($this);
    }

    /**

            === API ===

    */

    /**
     * Obtains or create a profiler
     *
     * @param string $name
     * @return ProfilerEntry
     */
    public static function get($name){
        if(!isset(self::$entries[$name])){
            self::$entries[$name] = new ProfilerEntry($name);
        }

        return self::$entries[$name];
    }

    /**
     * Start profilling
     *
     * @param string $name
     */
    public static function start($name){
        self::get($name)->start();
    }

    /**
     * Stop profilling
     *
     * @param string $name
     */
    public static function end($name){
        self::get($name)->end();
        
        if (self::$autoDump){
            self::dumpEntry($name);
        }
    }

    public static function run($name, Callable $cb, ...$args){
        self::start($name);

        try{
            return $cb(...$args);
        }
        finally{
            self::end($name);
        }
    }

	public static function dump(){
	    foreach(self::getEntries() as $entry){
	        self::$logger->info((string) $entry);
	    }
	}
	
	public static function dumpEntry($name){
	    if(!self::has($name)){
	        return false;
	    }

	    self::$logger->info((string) self::$entries[$name]);
	    return true;
	}
	
	public static function dumpDetailed(){
	    foreach(self::getEntries() as $entry){
	        self::$logger->info($entry->toDetailedString());
	    }
	}
	
	public static function dumpDetailedEntry($name){
	    if(!self::has($name)){
	        return false;
	    }
	
		self::$logger->info(self::$entries[$name]->toDetailedString());
	    return true;
	}
	
    public static function setAutoDump($bool){
        self::$autoDump = $bool;
    }

    public static function getAutoDump(){
        return self::$autoDump;
    }

    public static function has($name){
        return isset(self::$entries[$name]);
    }

    public static function remove($name){
        if(isset(self::$entries[$name]))
            unset(self::$entries[$name]);
    }

    public static function getEntries(){
        return self::$entries;
    }

    public static function getEntry($name){
        return isset(self::$entries[$name]) ?
                     self::$entries[$name] :
                     null;
    }

    public static function reset(){
        self::$entries = array();
    }
    
}
