<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Plank\Mediable\Mediable;

class DeliveryPartner extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use SoftDeletes;
    use Mediable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'gender_id', 'payout_group_id', 'password', 'phone', 'phone_prefix', 'driving_licence_number', 'status', 'approval_status', 'approved_date', 'verification_status', 'verification_otp', 'verified_date', 'availability_status', 'address_line_1', 'address_line_2', 'street_name', 'landmark', 'city', 'country_id', 'state_id', 'postcode', 'latitude', 'longitude', 'kyc_proof', 'kyc_id_number', 'kyc_name', 'approval_request_date', 'last_latitude', 'last_longitude', 'location_updated_at',
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

    public function bank()
    {
        return $this->hasOne('App\Model\DeliveryPartnerBank', 'delivery_partner_id', 'id');
    }

    public function payoutGroup()
    {
        return $this->belongsTo('App\Model\PayoutGroup', 'payout_group_id', 'id');
    }

    public function deliveryPartnerPayouts()
    {
        return $this->hasMany('App\Model\DeliveryPartnerPayouts');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country', 'country_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo('App\Model\State', 'state_id', 'id');
    }

}
