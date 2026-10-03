<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'zip',
        'province',
        'city',
        'address',
        'locality',
        'landmark',
        'district',
        'country',
        'isdefault',
    ];

    // 1) Make sure Laravel treats this as a boolean (true/false ↔ 1/0)
    protected $casts = [
        'isdefault' => 'boolean',
    ];

    // 2) Default at the model level (DB default is added via migration)
    protected $attributes = [
        'isdefault' => 0, // default value for 'isdefault'
    ];

    // 3) (Recommended) Centralize “only one default per user” here
    //    This protects you even if someone sets isdefault elsewhere.
    protected static function booted()
    {
        static::saved(function (Address $address) {
            if ($address->isdefault) {
                static::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id)
                    ->update(['isdefault' => 0]);
            }
        });
    }

    // Optional nicety: quick way to query the default
    public function scopeDefaultForUser($query, int $userId)
    {
        return $query->where('user_id', $userId)->where('isdefault', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
