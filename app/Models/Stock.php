<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $fillable = [
        'price', 'url', 'sku', 'in_stock'
    ];

    protected $casts = [
        'in_stock'  => 'boolean'
    ];

    public function track()
    {
        // hit a API endpoint


        $status = $this->retailer
                        ->client()
                        ->checkAvailability($this);


        // refresh the current stock record
        $this->update([
            'in_stock'  =>   $status->available,
            'price'     =>   $status->price,
        ]);

        $this->recordHistory();
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }

    protected function recordHistory()
    {
        $this->history()->create([
            'price'         =>  $this->price,
            'in_stock'         =>  $this->in_stock,
            'product_id'    =>  $this->product_id,
            'stock_id'      =>  $this->id,
        ]);
    }
}
