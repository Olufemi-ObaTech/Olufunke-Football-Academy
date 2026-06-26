<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    // Fields that should never be sanitized (passwords, tokens, binary data)
    protected array $except = [
        'password',
        'password_confirmation',
        '_token',
        '_method',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        $request->merge($this->clean($input));

        return $next($request);
    }

    protected function clean(array $data): array
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->except, true)) {
                continue;
            }

            if (is_array($value)) {
                $data[$key] = $this->clean($value);
            } elseif (is_string($value)) {
                // Strip HTML tags and trim whitespace
                $data[$key] = trim(strip_tags($value));
            }
        }

        return $data;
    }
}
