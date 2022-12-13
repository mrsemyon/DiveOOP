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
                    $this->addError("{$item} is required\n");
                } else {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $ruleValue) {
                                $this->addError("The {$item} must be at least {$ruleValue} characters\n");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $ruleValue) {
                                $this->addError("The {$item} must be no more than {$ruleValue} characters\n");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$ruleValue]) {
                                $this->addError("The {$item} must match {$ruleValue}\n");
                            }
                            break;
                        case 'unique':
                            $check = $this->db->read($ruleValue, [$item, '=', $value]);
                            if ($check->count()) {
                                $this->addError("The {$item} alredy exists\n");
                            }
                            break;
                        case 'email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("The {$item} must be valid email\n");
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
