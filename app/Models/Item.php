<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['nameEn', 'namePt', 'typeId', 'categoryId', 'image'];
        public function inventories()
        {
        return $this->belongsToMany(Inventory::class);
        }

        public function type()
{
            return $this->belongsTo(Type::class, 'typeId');
}

}
