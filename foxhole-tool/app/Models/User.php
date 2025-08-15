<?php

namespace App\Models; // Lives under app/Models so Laravel auto-loads it

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Optional if you want email verification support
use Illuminate\Database\Eloquent\Factories\HasFactory; // Trait to allow factory-based test data generation
use Illuminate\Foundation\Auth\User as Authenticatable; // Base class for Laravel authentication models
use Illuminate\Notifications\Notifiable; // Trait to allow sending notifications (email, database, etc.)
use Illuminate\Support\Str; // String helper functions

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable; // Pulls in the HasFactory and Notifiable features

    /**
     * ====== Mass assignment ======
     * Defines which attributes can be bulk-assigned via create(), update(), etc.
     * Protects against accidental or malicious assignment of sensitive fields.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',     // Full name of the user
        'email',    // Email address (used for login)
        'password', // Hashed password (never stored in plain text)
    ];

    /**
     * ====== Hidden attributes ======
     * These fields won't be included when converting to arrays or JSON.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',       // Hide password hash from API responses
        'remember_token', // Token used for "remember me" login
    ];

    /**
     * ====== Attribute casting ======
     * Defines how certain fields should be automatically transformed.
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Casts to Carbon instance
            'password'          => 'hashed',   // Laravel will auto-hash when setting
        ];
    }

    /**
     * ====== Custom accessor ======
     * Returns the user's initials based on their name.
     * Example: "John Smith" → "JS"
     */
    public function initials(): string
    {
        return Str::of($this->name) // Wrap name in a Stringable object
            ->explode(' ')          // Split name into words
            ->take(2)               // Take first two words (first + last name)
            ->map(fn ($word) => Str::substr($word, 0, 1)) // Take first letter of each
            ->implode('');          // Join them back into a string with no space
    }
}
