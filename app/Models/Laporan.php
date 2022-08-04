<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Laporan extends Model
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

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
        'source',
        'created_by',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'id_customer');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function keterangan()
    {
        return $this->belongsTo('App\Models\User', 'description');
    }
}
