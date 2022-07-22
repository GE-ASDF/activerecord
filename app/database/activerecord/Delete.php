<?php
namespace app\database\activerecord;

use Exception;
use Throwable;
use app\database\connection\Connection;
use function app\helpers\formatException;

use app\database\interfaces\ActiveRecordInterface;
use app\database\interfaces\ActiveRecordExecuteInterface;

class Delete implements ActiveRecordExecuteInterface{

    public function __construct(private string $field, private string|int $value)
    {
        
    }

    public function execute(ActiveRecordInterface $activeRecordInterface){
        try{
            $query = $this->createQuery($activeRecordInterface);
            $conn = Connection::connect();
            $prepare = $conn->prepare($query);
            $prepare->execute([
                $this->field => $this->value
            ]);
            return $prepare->rowCount();
        }catch(Throwable $throw){
            formatException($throw);
        }
    }

    private function createQuery($activeRecordInterface){
        if($activeRecordInterface->getAtributos()){
            throw new Exception("Para deletar não é necessário passar atributos.");
        }

        $sql = "DELETE FROM {$activeRecordInterface->getTable()} ";
        $sql.= "WHERE {$this->field} = :{$this->field}";

        return $sql;

    }
}