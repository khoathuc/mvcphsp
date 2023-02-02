<?php
    namespace app\core;
    /**
     * Class Model
     * @package app\core
     */
    abstract class Model{
        public const RULE_REQUIRED = 'required';
        public const RULE_EMAIL = 'email';
        public const RULE_MIN = 'min';
        public const RULE_MAX = 'max';
        public const RULE_MATCH = 'match';
        public const RULE_EXIST = 'exist';
        public const RULE_VALID_NAME = 'validName';
        public function loadData($data){
            foreach($data as $key=>$value){
                if(property_exists($this,$key)){
                    $this->{$key} = $value;
                }
            }
        }
        abstract function rules():array; 
        public array $errors = [];

        public function validate(){
            foreach($this->rules() as $attribute => $rules){
                $value = $this->{$attribute};
                foreach($rules as $rule){
                    if(!is_string($rule)){
                        $ruleName = $rule[0];
                    }
                    else {
                        $ruleName = $rule;
                    }
                    if($ruleName === self::RULE_VALID_NAME && !str_contains($value, ' ')){
                        $this->addError($attribute, self::RULE_VALID_NAME);
                    }
                    if($ruleName === self::RULE_REQUIRED && !$value && $value == ''){
                         $this->addError($attribute, self::RULE_REQUIRED);
                    }
                    if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                        $this->addError($attribute,self::RULE_EMAIL);
                    }
                    if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                        $this->addError($attribute, self::RULE_MIN, $rule );
                    }
                    if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                        $this->addError($attribute, self::RULE_MAX, $rule);
                    }
                    if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                        $this->addError($attribute, self::RULE_MATCH, $rule);
                    }
                    if($ruleName === self::RULE_EXIST){
                        $tableName = $rule[1]['table'];
                        $columnName = $rule[1]['column'];
                        $attribute = $rule[1]['attribute'];
                        $statement = $this->prepare("SELECT * FROM $tableName WHERE $columnName = '$value'");
                        $statement->execute();
                        $record = $statement->fetchObject();
                        if($record){
                            $this->addError($attribute, self::RULE_EXIST, ['attribute'=>$attribute]);
                        }
                    }
                }
            }
            return empty($this->errors);
        }
        public function addCustomError($attribute,$message){
            $this->errors[$attribute][] = $message;
        }
        public function addError($attribute, $rule, $params = []){
            $message = $this->errorMessage()[$rule] ?? '';
            foreach($params as $key=>$value){
                $message = str_replace("{{$key}}", $value, $message);
            }
            $this->errors[$attribute][] = $message;
            
        }
        
        public function errorMessage(){
            return [
                self::RULE_REQUIRED => 'This field is required',
                self::RULE_EMAIL => 'This field must be a valid email',
                self::RULE_MIN => 'Min length of this field must be {min}',
                self::RULE_MAX => 'Max length of this field must be {max}',
                self::RULE_MATCH => 'This field must be the same as {match}',
                self::RULE_EXIST => 'This {attribute} is already existed',
                self::RULE_VALID_NAME =>'This name is not valid, must have first name and last name'
            ];
        }
        public function hasError($attribute){
            return $this->errors[$attribute] ?? false;
        }
        public function getFirstError($attribute){
            return $this->errors[$attribute][0]??false;
        }
        public static function prepare($sql){
            return Application::$app->db->pdo->prepare($sql);
        }
    }