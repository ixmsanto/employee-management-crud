<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'mobile_number', 'email', 'address', 'profile_picture', 'gender'];

    public function educations()
    {
        return $this->hasMany(Education::class);
    }
}
