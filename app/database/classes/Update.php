<?php

namespace app\database\classes;

use app\database\connection\Connection;
use app\database\interfaces\UpdateInterface;
use app\database\interfaces\ActiveRecordInterface;
use app\database\interfaces\ActiveRecordExecuteInterface;
use Exception;

use function app\helpers\formatException;

class Update implements ActiveRecordExecuteInterface{

    public function __construct(private string $field, private string|int $value){
        
    }

    public function execute(ActiveRecordInterface $activeRecordInterface){
        try{
            $query = $this->createQuery($activeRecordInterface);
            
            $conn = Connection::connect();
            $prepare = $conn->prepare($query);            
            $atributos = array_merge($activeRecordInterface->getAtributos(), [$this->field => $this->value]);


            $prepare->execute($atributos);
            
            return $prepare->rowCount();

        }catch(\Throwable $throw){
            formatException($throw);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface){

        if(array_key_exists("idusuario", $activeRecordInterface->getAtributos())){
            throw new Exception("O campo idusuario não pode ser pasado para o UPDATE");
        }
        $sql = "UPDATE {$activeRecordInterface->getTable()} SET ";

            foreach($activeRecordInterface->getAtributos() as $key=> $value){
                if($key != "id"){
                    $sql.= "{$key} =:{$key},";
                }
            }

            $sql = rtrim($sql, ",");
            $sql .= " WHERE {$this->field} = :{$this->field}";

        return $sql;
    }

}