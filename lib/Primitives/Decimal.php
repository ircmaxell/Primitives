<?php

namespace Primitives;

class Decimal {
    protected $value = 0;
    protected $precision = 0;
    protected $specified = true;

    public function __construct($value, $precision = 0, $specified = true) {
        $this->value = $this->toPrecision($value, $precision);
        $this->precision = abs($precision);
        $this->specified = $specified;
    }

    public function equals($value) {
        return 0 === $this->doOp($value, '=');
    }

    public function compare($value) {
        return $this->doOp($value, '=');
    }

    public function add($value) {
        return $this->doOp($value, '+');
    }

    public function subtract($value) {
        return $this->doOp($value, '-');
    }

    public function multiply($value) {
        return $this->doOp($value, '*');
    }

    public function divide($value) {
        return $this->doOp($value, '/');
    }

    public function mod($value) {
        return $this->doOp($value, '%');
    }

    public function percent($value) {
        return $this->doOp($value, 'percent');
    }

    public function getValue() {
        $value = (string) $this->value;
        if (strlen($value) < $this->precision) {
            $value = str_pad($value, $this->precision, '0', STR_PAD_LEFT);
        }
        return substr($value, 0, -1 * $this->precision) . '.' . substr($value, -1 * $this->precision);
    }

    protected function doOp($value, $op) {
        $new = new static(0);
        $right = $this->fromPrimitive($value);
        if ($right->specified) {
            $new->precision = min($right->precision, $this->precision);
            $l = $this->toPrecision($this->value, $new->precision);
            $r = $right->toPrecision($right->value, $new->precision);
        } else {
            $new->precision = $this->precision;
            $l = $this->value;
            $r = $right->toPrecision($right->value, $new->precision);
        }
        switch ($op) {
            case '+':
                $new->value = $l + $r;
                break;
            case '-':
                $new->value = $l - $r;
                break;
            case 'percent':
                $r = self::adjustPrecision($right->value, $new->precision - 2); 
            case '*':
                $new->value = self::adjustPrecision($l * $r, -1 * $new->precision);
                break;
            case '/':
                $new->value = self::adjustPrecision($l / $r, $new->precision);
                break;
            case '%':
                $new->value = $l % $r;
                break;
            case '=':
                return $l - $r;
                break;
        }
        return $new;
    }

    protected function fromPrimitive($value) {
        if ($value instanceof self) {
            return $value;
        } elseif (is_int($value)) {
            $new = clone $this;
            $new->value = $value;
            $new->precision = 0;
            $new->specified = false;
        } elseif (is_string($value) && is_numeric($value)) {
            $new = clone $this;
            $decimal = strpos($value, '.');
            if ($decimal === false) {
                $new->value = (int) $value;
                $new->precision = 0;
                $new->specified = false;
            } else {
                $precision = strlen($value) - $decimal - 1;
                $new->precision = $precision;
                $new->value = (int) str_replace('.', '', $value);
                $new->specified = false;
            }
        } elseif (is_float($value)) {
            $new = clone $this;
            $new->value = self::adjustPrecision($value, $this->precision);
            $new->specified = false;
        } else {
            throw new \LogicException('Invalid value provided!');
        }
        return $new;
    }

    protected function toPrecision($value, $new) {
        return self::adjustPrecision($value, $new - $this->precision);
    }

    protected static function adjustPrecision($value, $precision) {
        return (int) ($value * pow(10, $precision));
    }

}