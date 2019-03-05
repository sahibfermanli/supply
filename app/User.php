<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'slug', 'confirmed', 'deleted', 'deleted_at', 'email', 'password', 'DepartmentID', 'chief', 'auditor', 'delivered_person', 'password_reset'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function deleted_value() {
        return $this->deleted;
    }

    public function authority() {
        $authority = Departments::where('id', $this->DepartmentID)->select('authority_id')->first();

        return $authority->authority_id;
    }

    public function chief() {
        return $this->chief;
    }

    public function confirmed() {
        return $this->confirmed;
    }

    public function DepartmentID() {
        return $this->DepartmentID;
    }

    public function auditor() {
        return $this->auditor;
    }

    public function delivered_person() {
        return $this->delivered_person;
    }
}
