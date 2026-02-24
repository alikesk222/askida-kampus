<?php

namespace Core;

class Validator
{
    private array $errors = [];
    private array $data   = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function required(string $field, string $label = ''): static
    {
        $label = $label ?: $field;
        if (!isset($this->data[$field]) || trim((string)$this->data[$field]) === '') {
            $this->errors[$field] = "$label alanı zorunludur.";
        }
        return $this;
    }

    public function email(string $field, string $label = ''): static
    {
        $label = $label ?: $field;
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "$label geçerli bir e-posta adresi değil.";
        }
        return $this;
    }

    public function min(string $field, int $min, string $label = ''): static
    {
        $label = $label ?: $field;
        if (!empty($this->data[$field]) && mb_strlen((string)$this->data[$field]) < $min) {
            $this->errors[$field] = "$label en az $min karakter olmalıdır.";
        }
        return $this;
    }

    public function max(string $field, int $max, string $label = ''): static
    {
        $label = $label ?: $field;
        if (!empty($this->data[$field]) && mb_strlen((string)$this->data[$field]) > $max) {
            $this->errors[$field] = "$label en fazla $max karakter olabilir.";
        }
        return $this;
    }

    public function numeric(string $field, string $label = ''): static
    {
        $label = $label ?: $field;
        if (!empty($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field] = "$label sayısal bir değer olmalıdır.";
        }
        return $this;
    }

    public function minVal(string $field, float $min, string $label = ''): static
    {
        $label = $label ?: $field;
        if (isset($this->data[$field]) && is_numeric($this->data[$field]) && (float)$this->data[$field] < $min) {
            $this->errors[$field] = "$label en az $min olmalıdır.";
        }
        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(): string
    {
        return array_values($this->errors)[0] ?? '';
    }
}
