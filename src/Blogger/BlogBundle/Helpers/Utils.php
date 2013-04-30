<?php
namespace Blogger\BlogBundle\Helpers; 
class Utils{
    
    static public function log($msg)
    {
        $fd = fopen(__DIR__ .'/debuglog.txt'   , 'a');
        $str = '[' . date('Y-m-d H:i:s') . '] ' . $msg;
        fwrite($fd, $str . "\n");
        fclose($fd);
    }
    

    static public function clearLog($logThis=false,$place='')
    {
        $filename = __DIR__ . '/debuglog.txt';
        $fd = fopen($filename, 'w');
        ftruncate($fd,0);
        fclose($fd);
        if($logThis) self::log(__METHOD__ . ": $place Log cleared");
    }
    
}