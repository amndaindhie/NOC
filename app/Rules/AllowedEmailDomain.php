<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllowedEmailDomain implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // List of allowed domains
        $allowedDomains = [
            'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'outlook.com',
            'icloud.com',
            // Add more domains as needed
        ];

        // Extract domain from email
        $domain = substr(strrchr($value, "@"), 1);

        if (!in_array($domain, $allowedDomains)) {
            $fail('Oops! The email you entered isn’t supported. Please use an email from ' . implode(', ', $allowedDomains));
        }
    }
}
