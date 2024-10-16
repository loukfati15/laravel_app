<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Define the table associated with the model
    protected $table = 'payment';

    // Define the primary key for the table
    protected $primaryKey = 'id';

    // If your primary key is not an incrementing integer, set $incrementing to false
    public $incrementing = true;

    // Specify the data type of the primary key
    protected $keyType = 'int';

    // Laravel automatically maintains `created_at` and `updated_at` timestamps,
    // but if your table does not have these columns, you can disable the timestamps
    public $timestamps = false;

    // Specify the fields that can be mass assigned
    protected $fillable = [
        'invoice_date',
        'module_gwt_id',
        'pay_state',
        'payment_date',
        'payment_type',
        'card_type',
        'no_pay_mounth',
        'delay',
        'year',
        'commentaire'
    ];

    // Optionally, you can define casts to automatically convert fields to specific types
    protected $casts = [
        'invoice_date' => 'datetime',
        'payment_date' => 'datetime',
    ];
}
