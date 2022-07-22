<?php
namespace app\database\activerecord;

use Throwable;
use app\database\connection\Connection;
use function app\helpers\formatException;

use app\database\interfaces\ActiveRecordInterface;
use app\database\interfaces\ActiveRecordExecuteInterface;

class FindBy implements ActiveRecordExecuteInterface{

    public function __construct(private string $field, private string|int $value, private string $fields = "*")
    {
        
    }

    public function execute(ActiveRecordInterface $activeRecordInterface){

        try{

            $conn = Connection::connect();
            $query = $this->createQuery($activeRecordInterface);
            $prepare = $conn->prepare($query);
            $prepare->execute([
                $this->field => $this->value
            ]);
            
            return $prepare->fetch();

        }catch(Throwable $throw){
            formatException($throw);
        }

    }

    private function createQuery($activeRecordInterface){

        $sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()} WHERE {$this->field} = :{$this->field}";
        return $sql;        

    }
}