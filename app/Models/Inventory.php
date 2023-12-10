<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'nameEn',
        'namePt',
        'type',
        'category',
        'image'
  
        ];
        public function items()
        {
        return $this->belongsToMany(Item::class);
        }
}
