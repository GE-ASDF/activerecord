<?php
namespace app\database\activerecord;

use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;

class Find implements ActiveRecordExecuteInterface{

    public function execute(ActiveRecordInterface $activeRecordInterface){
        var_dump($activeRecordInterface->getAtributos());
    }

}