<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'consignee_id',
        'driver_id',
        'user_id',
        'tracking_num',
        'amount',
        'weight',
        'no_pieces',
        'reference_num',
        'pickup_date',
        'delivery_date',
        'notes',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pickup_date' => 'datetime',
        'delivery_date' => 'datetime',
    ];

    public function consignee()
    {
        return $this->belongsTo(Consignee::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getConsigneeAddressAttribute()
    {
        return $this->consignee->address;
    }

    public function getConsigneeEmirateAttribute()
    {
        return $this->consignee->emirate;
    }

    public function getConsigneePhoneAttribute()
    {
        return $this->consignee->phone;
    }
}
