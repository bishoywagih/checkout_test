<?php

namespace App\Http\Controllers;

use App\Core\App;
use App\Exceptions\ValidationException;
use App\Http\Middleware\CsrfMiddleware;
use App\Services\Validator;
use PDO;

class Controller
{
    protected PDO $db;
    protected array $errors = [];
    /**
     * @throws \App\Exceptions\CsrfTokenException
     */
    public function __construct()
    {
        (new CsrfMiddleware())->handle([]);
        $this->db = (new App())->get('database');
    }

    /**
     * @throws ValidationException
     */
    protected function validate(array $fields, array $rules)
    {
        $validator = new Validator($fields);
        $validator->mapFieldsRules($rules);
        if (! $validator->validate()) {
            throw new ValidationException($fields, $validator->errors());
        }
    }

    /**
     * @throws ValidationException
     */
    protected function myValidator(array $data, array $rules)
    {
        foreach ($data as $key => $value) {
            if(isset($rules[$key])){
                foreach ($rules[$key] as $ruleKey => $rule) {
                    if(is_string($ruleKey)){
                        $this->{"validate" . $ruleKey}($key, $value, $rule);
                    }
                    else {
                        $this->{"validate" . $rule}($key, $value);
                    }

                }
            }
        }

        if(count($this->errors) > 0){
            throw new ValidationException($data, $this->errors);
        }
    }

    protected function validateRequired($field, $value)
    {
        if (is_null($value) || (is_string($value) && trim($value) === '')) {
            $this->errors[$field][] = "{$field} field is required";
        }
    }

    /**
     * Validate that a field is a valid e-mail address
     *
     * @param  string $field
     * @param  mixed $value
     * @return bool
     */
    protected function validateEmail($field, $value)
    {
        if (filter_var($value, \FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[$field][] = "{$field} field is not a valid Email";
        }
    }

    protected function validateMaxLength($field, $value, $rules)
    {
    }

    protected function validateMin($field, $value, $rules)
    {
//        dd($rules);
    }

    protected function validateImage($field, $value, $rules)
    {
        foreach ($rules as $key => $rule){
            if ($key === 'mimes') {
                $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
                if (! in_array($ext, $rule)){
                    $this->errors[$field][] = "invalid {$field} type";
                }
            }
            if ($key === 'size') {
                if($rule < number_format($value['size'] / (1024 * 1024), 2) ){
                    $this->errors[$field][] = "invalid {$field} size";
                }
            }
        }
    }
}
