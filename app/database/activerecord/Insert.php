<?php

namespace app\database\activerecord;

use Throwable;
use app\database\connection\Connection;
use function app\helpers\formatException;
use app\database\interfaces\ActiveRecordInterface;
use app\database\interfaces\ActiveRecordExecuteInterface;

class Insert implements ActiveRecordExecuteInterface{
    
    public function execute(ActiveRecordInterface $activeRecordInterface){
        try{
            $query = $this->createQuery($activeRecordInterface);
            $conn = Connection::connect();
            $prepare = $conn->prepare($query);
            return $prepare->execute($activeRecordInterface->getAtributos());
            
        }catch(Throwable $throw){
            formatException($throw);
        }
    }
    private function createQuery(ActiveRecordInterface $activeRecordInterface){
        $sql = "INSERT INTO {$activeRecordInterface->getTable()}(";
        $sql.= implode(",", array_keys($activeRecordInterface->getAtributos())) .') VALUES(';
        $sql.= ":" . implode(",:", array_keys($activeRecordInterface->getAtributos())).')';
        return $sql;
    }
}