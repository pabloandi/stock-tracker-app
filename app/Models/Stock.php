<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\NowInStock;

class Stock extends Model
{
    protected $table = 'stock';

    protected $fillable = [
        'price', 'url', 'sku', 'in_stock'
    ];

    protected $casts = [
        'in_stock'  => 'boolean'
    ];

    public function track($callback = null)
    {
        // hit a API endpoint
        $status = $this->retailer
                        ->client()
                        ->checkAvailability($this);

        if(! $this->in_stock && $status->available){
            event(new NowInStock($this));
        }

        // refresh the current stock record
        $this->update([
            'in_stock'  =>   $status->available,
            'price'     =>   $status->price,
        ]);

        $callback && $callback($this);

        // $this->product->recordHistory($this);

        // $this->recordHistory();
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }




}
