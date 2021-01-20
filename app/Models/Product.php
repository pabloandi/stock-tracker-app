<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name'];

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }

    public function inStock()
    {
        return $this->stock()->where('in_stock', true)->exists();
    }

    public function track()
    {
        $this->stock->each->track(
            function($stock){ $this->recordHistory($stock); }
        );
    }

    public function recordHistory(Stock $stock)
    {
        $this->history()->create([
            'price'         =>  $stock->price,
            'in_stock'         =>  $stock->in_stock,
            'stock_id'      =>  $stock->id,
        ]);
    }
}
