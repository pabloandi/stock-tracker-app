<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Stock extends Model
{
    use HasFactory;

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
        if($this->retailer->name === 'Target'){

            // fetch the up-to-date details for the item
            $results = Http::get('http://foo.test')->json();

            // refresh the current stock record
            $this->update([
                'in_stock'  =>   $results['available'],
                'price'     =>   $results['price'],
            ]);
        }

    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
