<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Laporan extends Model
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'date',
        'lead',
        'deal',
        'customer_information',
        'no_wa',
        'id_customer',
        'qty',
        'order',
        'description',
        'created_by'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'id_customer');
    }
}
