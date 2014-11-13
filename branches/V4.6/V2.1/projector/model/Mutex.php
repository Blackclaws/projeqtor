<?php
 
class Mutex
{
    var $lockname;
    var $timeout;
    var $locked;
 
    function Mutex($name, $timeout = 10)
    {
        $this->lockname = $name;
        $this->timeout = $timeout;
        $this->locked = -1;
    }
 
    function reserve()
    {
        $rs = Sql::query("SELECT GET_LOCK('".$this->lockname."', ".$this->timeout.") as mutex");
        $line=Sql::fetchLine($rs);
        $this->locked = $line['mutex'];
        //mysqli_free_result($rs);
    }
 
    function release()
    {
        $rs = Sql::query("SELECT RELEASE_LOCK('".$this->lockname."') as mutex");
        $line=Sql::fetchLine($rs);
        $this->locked = !$line['mutex'];
        //mysqli_free_result($rs);
 
    }
 
    function isFree()
    {
        $rs = Sql::query("SELECT IS_FREE_LOCK('".$this->lockname."') as mutex");
        $line=Sql::fetchLine($rs);
        $lock = (bool)$line['mutex'];
        //mysqli_free_result($rs);
        return $lock;
    }
}
 