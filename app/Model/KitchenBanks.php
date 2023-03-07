<?php
//SAMAH
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KitchenBanks extends Model
{
    use SoftDeletes;

    protected $fillable = ['bank_name', 'branch', 'payment_method', 'account_number', 'ifsc', 'swift', 'email', 'type', 'status', 'default', 'kitchen_id'];

    protected $dates = ['deleted_at'];
}
