<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected  $primaryKey = 'rol_id';

    protected $fillable = [
        'rol_name',
        'rol_description',
        'created_by',
        'created_at',
    ];

    // public function user() {
    //     return $this->hasOne('App\Models\User');
    // }

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
