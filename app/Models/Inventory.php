<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = ['id','userId'];
     
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
