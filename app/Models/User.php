<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Lecture;
use App\Models\Student;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
    }
}
