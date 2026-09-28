<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Filter implements ValidationRule
{
    protected array $forbidden;

    public function __construct(array $forbidden)
    {
        $this->forbidden = array_map('strtolower', $forbidden);
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array(strtolower($value), $this->forbidden)) {
            $fail('the input value is forbedin');
        }
    }
}