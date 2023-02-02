<?php
    namespace app\core\form;
    use app\core\Model;
    /**
     * Class Field
     * @package app\core\form
     */
    class Field{
        public const PASSWORD_FIELD = 'password';
        public const TEXT_FIELD = 'text';
        public const EMAIL_FIELD = 'email';
        public const FILE_FIELD = 'file';
        public const IMAGE_FIELD = 'image';
        public string $type;
        public Model $model;
        public string $attribute = '';
        public function __construct(Model $model, $attribute){
            $this->type = self::TEXT_FIELD;
            $this->model = $model;
            $this->attribute = $attribute;
        }
        public function __toString(){
            // var_dump($this->attribute);
            // exit;
            return sprintf('
            <div class = "form-group mb-3">
                <label class = "form-label">%s</label>
                <input type = "%s" name = "%s" value = "%s" class = "form-control %s">
                <div class = "invalid-feedback">
                    %s
                </div>
            </div>
            ',
             $this->attribute,
             $this->type,
             $this->attribute,
             $this->model->{$this->attribute}, 
             $this->model->hasError($this->attribute)? 'is-invalid': '',
             $this->model->getFirstError($this->attribute)
            );
            // return 1;
        }
        public function passwordField(){
            $this->type = self::PASSWORD_FIELD;
            return $this;
        }
        public function emailField(){
            $this->type = self::EMAIL_FIELD;
            return $this;
        }
    }