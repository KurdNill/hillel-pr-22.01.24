<?php

namespace App\Validators;

abstract class BaseValidator
{
    protected array $rules = [], $errors = [], $skip = [];
    public function validate(array $fields = []): bool
    {
        if (empty($this->rules)) {
            return true;
        }

        foreach ($fields as $key => $fieldValue) {
            if (in_array($key, $this->skip)) {
                continue;
            }

            if (!empty($this->rules[$key]) && preg_match($this->rules[$key], $fieldValue)) {
                unset($this->errors[$key]);
            }
        }

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setError(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }
}