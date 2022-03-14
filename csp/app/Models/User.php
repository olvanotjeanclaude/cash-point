<?php

namespace App\Models;

use App\Helper\Address;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Address;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeEmails()
    {
        return User::pluck("email")->toArray();
    }

    public function my_customers(){
        return $this->hasMany(Customer::class);
    }

    public function scopeStaffs($query,array $columns=["*"]){
        return $query->select($columns)->where("permission",3)->orderBy("name","asc")->get();
    }


    public function branchs()
    {
        return $this->belongsToMany(Branch::class, "branch_users");
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class, "client_id");
    }


    public function other_info()
    {
        return $this->hasOne(UserOtherInformation::class);
    }

    public function notes(){
        return $this->hasMany(CustomerNote::class,"customer_id");
    }

    public function meetings(){
        return $this->hasMany(Meeting::class,"customer_id");
    }

    public function my_meetings(){
        return $this->hasMany(Meeting::class);
    }

    public function income_meetings(){
        return $this->hasMany(IncomeMeeting::class);
    }

    public function getFullNameAttribute()
    {
        return ucfirst("{$this->name} {$this->surname}");
    }
}
