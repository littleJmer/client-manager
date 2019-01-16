<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Client extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'address',
        'city',
        'state',
        'zip_code',
        'email',
        'work_phone',
        'cell_phone',
        'user_id'
    ];

    protected $appends = ['fullName', 'age', 'from'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function getFromAttribute()
    {
        return $this->city . ', ' . $this->state;
    }

    public function getRowAttribute()
    {
        return [
            'full_name' => $this->fullName,
            'age' => $this->age,
            'from' => $this->from,
        ];
    }

}
