<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public const ADMIN_ROLE = 1 ;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'gender',
        'address',
        'profile',
        'country',
        'email_verified_at',
        'remember_token',
        'role_id',
        'is_active'

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
    ];

    public function getFullNameAttribute(){

        return ucfirst($this->first_name)." ".ucfirst($this->last_name);
    }

    public function getRoleNameAttribute(){

        return ($this->role_id == self::ADMIN_ROLE) ? 'Admin' : 'User';
    }

    public function CountryData(){
        return $this->hasOne(Country::class,'id','country');
    }

    public function UserProductsData(){
        return  $this->belongsToMany(Product::class,'carts');

    }

    public function comments(){
        return $this->hasOne(Comment::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }


}
