<?php
//SAMAH
namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Plank\Mediable\Mediable;
use Spatie\Translatable\HasTranslations;

class Kitchen extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use Mediable;
    use HasTranslations;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id', 'state_id', 'city', 'locality', 'address_line_1', 'address_line_2', 'building_number', 'street_name', 'landmark', 'postcode', 'longitude', 'latitude', 'phone', 'phone_prefix', 'additional_phone', 'email', 'contact_email', 'notification_email', 'password', 'remember_token', 'verification_otp', 'verification_status', 'verified_date', 'approval_status', 'created_by', 'approved_date', 'status', 'payout_group_id', 'delivery', 'delivery_type', 'repeat_schedule', 'receive_order',
    ];

    public $translatable = ['name', 'description'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function reviews()
    {
        return $this->hasMany('App\Model\Review', 'kitchen_id', 'id');
    }
    public function kitchenFood()
    {
        return $this->hasMany('App\Model\KitchenFood', 'kitchen_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo('App\Model\State', 'state_id', 'id');
    }
    public function payoutGroup()
    {
        return $this->belongsTo('App\Model\PayoutGroup', 'payout_group_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country', 'country_id', 'id');
    }
    public function kitchenBanks()
    {
        return $this->hasOne('App\Model\KitchenBanks');
    }
    public function kitchenVideos()
    {
        return $this->hasMany('App\Model\KitchenVideos');
    }
    public function kitchenDetails()
    {
        return $this->hasOne('App\Model\KitchenDetails');
    }
    public function kitchenPayouts()
    {
        return $this->hasMany('App\Model\KitchenPayouts');
    }
}
