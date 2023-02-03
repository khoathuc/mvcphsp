<?php
    namespace app\core;
    use app\core\Model;
    use app\models;
    use PDO;
use Exception;
use PDOException;

    /**
     * Class DbModel
     * @package app\core
     */
    abstract class DbModel extends Model{
        abstract public static function tableName():string;
        abstract public static function attributes():array;
        abstract public static function mapColumns():array;
        abstract public static function autoAttributes():array;
        public function save(){
            try{
                $tableName = $this->tableName();
                $attributes = $this-> attributes();
                $autoAttributes = $this-> autoAttributes();
                $params = array();
                $columns = array();
                foreach($attributes as $attribute => $column){
                    if(!array_key_exists($attribute, $autoAttributes)){
                        array_push($params, ":$attribute");
                        array_push($columns, $column);
                    }
                }
                $statement = parent::prepare("INSERT INTO $tableName (".implode(',',$columns).") VALUES (".implode(',',$params).")");
                foreach($attributes as $attribute=>$column){
                    if(!array_key_exists($attribute, $autoAttributes)){
                        $statement->bindValue(":$attribute", $this->{$attribute});
                    }
                }
                $res = $statement->execute();
                if($res){
                    return Application::$app->db->pdo->lastInsertId();
                }
                return false;
                
                // var_dump(Application::$app->db->pdo->lastInsertId());
                // return Application::$app->db->pdo->lastInsertId();
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
        // public static function update($set,$where){['firstName'=>'khoa']['id'=>1]
        //     try{
        //         $tableName = static::tableName();
        //         $attributes = static::attributes();
        //         $setArray = array();
        //         $whereArray = array();
        //         foreach($set as $key => $value){
        //             $column = $attributes[$key];
        //             array_push($setArray, "$column = :$key");
        //         }
        //         foreach($where as $key => $value){
        //             $column = $attributes[$key];
        //             array_push($whereArray, "$column = :$key");
        //         }
        //         $query = "UPDATE $tableName SET ".implode(" , ", $setArray)." WHERE ".implode(" , ",$whereArray);
        //     }
        //     catch(Exception $e){
        //         echo $e->getMessage();
        //     }
        // }
        public static function loadStatement($body, $attributes){
            foreach($body as $key=>$value){
                $column = $attributes[$key];
                if($value){
                    $params[] = $key;
                    $statement[] = "$column= :$key";
                }
            }
            return ['params'=>$params, 'statement'=>$statement, 'body'=>$body];
        }
        public static  function findOne($where){
            try{
                $tableName = static::tableName();
                $attributes = static::attributes();
                $mapColumns = static::mapColumns();
                $whereArray = array();
                foreach($where as $key=>$value){
                    $column = $attributes[$key];
                    array_push($whereArray, "$column = :$key");
                }
                $query = "SELECT * FROM $tableName where ".implode("AND ", $whereArray);
                $statement = parent::prepare($query);
                foreach ($where as $key => $value) {
                    $statement->bindValue(":$key", $value);
                }
                $statement->execute();
                $data = $statement->fetch();
                $res = array();
                if($data){
                    foreach($data as $key=>$value){
                        if(array_key_exists($key, $mapColumns)){
                            $res[$mapColumns[$key]] = $value;
                        }
                    }
                }
                return $res;
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }