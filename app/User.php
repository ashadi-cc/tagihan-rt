<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'blok', 'default_password', 'blok_name', 'blok_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //overrired username value to lowercase 
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    public function getEmailAttribute($value)
    {
        if (strpos($value, config('default.hostmail'))) {
            return '';
        }

        return $value;
    }

    public function setBlokAttribute($value)
    {
        $blok =  strtoupper($value);
        $this->attributes['blok'] = $blok;

        $splitBlok = explode('-', $blok); 
        if (count($splitBlok) == 2) {
            $this->attributes['blok_name'] = $splitBlok[0];
            $this->attributes['blok_number'] = $splitBlok[1];
        }
    }

    public function scopeWarga($query)
    {
        return $query->where('username', '<>', 'admin');
    }

    /**
     * Get the uploads for the user
     */
    public function uploads()
    {
        return $this->hasMany('App\Models\Upload');
    }

    public function billings()
    {
        return $this->hasMany('App\Models\BillingUser');
    }
}
