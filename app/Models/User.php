<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
<<<<<<< HEAD
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Lecture;
use App\Models\Student;
=======
>>>>>>> 2a19af7a6dc709ec7c88d4aabbe01045aa553218

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

<<<<<<< HEAD
=======
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
>>>>>>> 2a19af7a6dc709ec7c88d4aabbe01045aa553218
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

<<<<<<< HEAD
=======
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
>>>>>>> 2a19af7a6dc709ec7c88d4aabbe01045aa553218
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's role type.
     */
    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ["students", "admin", "lectures"][$value] ?? 'unknown',
        );
    }

    /**
     * Automatically create related student or lecturer record after user creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if ($user->type === 0) { // Student
                Student::create([
                    'user_id' => $user->id,
                    'student_number' => 'STU' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                ]);
            } elseif ($user->type === 2) { // Lecturer
                Lecture::create([
                    'user_id' => $user->id,
                    'staff_number' => 'LEC' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                    'department_id' => null, // Can be updated later
                ]);
            }
        });
    }

    /**
     * Define the relationship with Student.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Define the relationship with Lecture.
     */
    public function lecturer()
    {
        return $this->hasOne(Lecture::class);
=======
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
>>>>>>> 2a19af7a6dc709ec7c88d4aabbe01045aa553218
    }
}
