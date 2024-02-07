<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'roles',
        'password',
        'is_Banned',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'roles' => 'array',
    ];

    public function isAdmin(): bool
    {
        return in_array('admin', $this->roles);
    }

    public function hasAnyRole(array $roles): bool
    {
        return count(array_intersect($roles, $this->roles)) > 0;
    }

    public function getForm(): HasOne
    {
        return $this->hasOne(Form::class);
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getProdi(): HasOne
    {
        return $this->hasOne(Prodi::class, 'id');
    }

    public function getProgress()
    {
        $form = $this->getForm;

        if (!$form) {
            return null;
        }

        $percent = [
            'personal' => 0,
            'address' => 0,
            'education' => 0,
            'parent' => 0,
            'document' => 0,
        ];

        $fieldObject = [
            'personal' => ['gender', 'religion', 'birth_date', 'birth_date', 'birth_place_city', 'birth_place_province', 'birth_place_country', 'national_id'],
            'address' => ['address', 'city', 'province', 'subdistrict', 'country', 'postal_code', 'rt', 'rw', 'phone_number', 'phone_number_alt'],
            'education' => ['last_education', 'education_number', 'education_name', 'education_city', 'education_province', 'education_subdistrict', 'education_country', 'education_postal_code', 'education_graduation_year', 'education_major', 'education_grade'],
            'parent' => ['father_name', 'father_birth_date', 'father_place', 'father_last_education', 'father_job', 'father_phone', 'father_email', 'mother_name', 'mother_birth_date', 'mother_place', 'mother_last_education', 'mother_job', 'mother_email', 'mother_phone'],
            'document' => ['ktp', 'foto', 'ijazah', 'transkrip_nilai'],
        ];

        foreach ($fieldObject as $key => $field) {
            foreach ($field as $f) {
                if ($form[$f] != null && $key != 'document') {
                    $percent[$key] += 1;
                } else if ($form->hasMedia($f) && $key == 'document') {
                    $percent[$key] += 1;
                }
            }
            $percent[$key] = ($percent[$key] / count($field)) * 100;
        }
        return $percent;
    }

    public function health(): HasOne
    {
        return $this->hasOne(Health::class);
    }

    public function historyExam(): HasMany
    {
        return $this->hasMany(ExamHistory::class);
    }

    public function getInterviews(): HasOne
    {
        return $this->hasOne(Interviews::class);
    }
}
