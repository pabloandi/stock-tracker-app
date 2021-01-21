<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\NowInStock;
use App\UseCases\TrackStock;

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

        (new TrackStock($this))->handle();

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
