<?php
    namespace app\models;
    use app\core\Model;
    use app\core\DbModel;
    /**
     * Class RegisterModel
     * @package app\models
     */
    class User extends DbModel{  
        public ?int $id = null;
        public string $name = ''; 
        public string $firstName = '';
        public string $lastName  = '';
        public string $userName = '';
        public string $email  = '';
        public string $password  = '';
        public string $confirmPassword = '';
        public string $jobTitle = '';
        public string $avatar = '';
        public string $dateOfBirth = '';
        public string $phoneNumber = '';
        public string $address = '' ;
        public string $createdAt = '';
        public string $updatedAt = '';
        public static function tableName():string{
            return 'account';
        }
        public function save(){
            if($this->password){
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            }
            $this->createdAt = date('d/m/y h:i:s');
            $this->updatedAt = date('d/m/y h:i:s');
            return parent::save();
        }
        // public function findOne(){
        //     return parent::findOne();
        // }
        public function checkValidName(){
            if(str_contains($this->name, ' ')){
                $pos = strpos($this->name, ' ');
                $this->lastName = substr($this->name, 0, $pos);
                $this->firstName = substr($this->name, $pos + 1);
            }
        }
        public function rules():array{
            return [
                'name'=>[self::RULE_REQUIRED, self::RULE_VALID_NAME],
                'firstName'=>[self::RULE_REQUIRED],
                'lastName'=>[self::RULE_REQUIRED],
                'userName'=>[self::RULE_REQUIRED, [self::RULE_EXIST,['table'=>$this->tableName(), 'column'=>$this->attributes()['userName'],'attribute'=>'userName']]],
                'email'=>[self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_EXIST,['table'=>$this->tableName(),'column'=>$this->attributes()['email'],'attribute'=>'email']]],
                'password'=>[self::RULE_REQUIRED, [self::RULE_MIN, 'min'=>8], [self::RULE_MAX, 'max'=> 24]],
                'confirmPassword'=>[self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=>'password']],
            ];
        }
        public static function autoAttributes():array{
            return [
                'id'=>'id'
            ];
        }
        public static function attributes():array{
            return [
                'id'=>'id',
                'firstName'=>"first_name", 
                'lastName'=>"last_name", 
                'email'=>"email",
                'userName'=>'user_name', 
                'password'=>"password",
                'jobTitle'=>'job_title',
                'avatar'=>'avatar',
                'dateOfBirth'=>'date_of_birth',
                'phoneNumber'=>'phone_number',
                'address'=>'address',
                'createdAt'=>'created_at',
                'updatedAt'=>'updated_at'
            ];
        }
        public static function mapColumns():array{
            $mapColumns = array();
            foreach(self::attributes() as  $attr=>$column){
                $mapColumns[$column] = $attr; 
            }
            return $mapColumns;
        }
        }