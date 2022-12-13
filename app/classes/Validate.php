<?php

class Validate
{
    private $passed = false;
    private $errors = [];
    private $db = null;

    public function __construct()
    {
        $this->db = QueryBuilder::getInstance();
    }

    public function check($source, $items = [])
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $ruleValue) {
                $value = $source[$item];

                if ($rule == 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $ruleValue) {
                                $this->addError("The {$item} must be at least {$ruleValue} characters");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $ruleValue) {
                                $this->addError("The {$item} must be no more than {$ruleValue} characters");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$ruleValue]) {
                                $this->addError("The {$item} must match {$ruleValue}");
                            }
                            break;
                        case 'unique':
                            if ($this->db->read($ruleValue, [$item => $value])) {
                                $this->addError("The {$item} alredy exists");
                            }
                            break;
                        case 'email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("The {$item} must be valid email");
                            }
                    }
                }
            }
        }
        if (empty($this->errors)) {
            $this->passed = true;
        }
        return $this;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isPassed()
    {
        return $this->passed;
    }
}
