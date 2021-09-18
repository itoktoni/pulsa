<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\Product;

class PurchaseDetail extends Model
{
    protected $table = 'procurement_purchase_detail';
    protected $primaryKey = 'procurement_po_detail_purchase_id';

    protected $fillable = [
        'procurement_po_detail_id',
        'procurement_po_detail_purchase_id',
        'procurement_po_detail_notes',
        'procurement_po_detail_item_product_id',
        'procurement_po_detail_item_product_description',
        'procurement_po_detail_item_product_price',
        'procurement_po_detail_qty',
        'procurement_po_detail_price',
        'procurement_po_detail_total',
        'procurement_po_detail_discount_name',
        'procurement_po_detail_discount_percent',
        'procurement_po_detail_discount_value',
        'procurement_po_detail_tax_id',
        'procurement_po_detail_tax_percent',
        'procurement_po_detail_tax_value',
    ];

    // public $with = ['module'];

    public $timestamps = false;
    public $incrementing = true;
    
    public function purchase_id()
    {
        return 'procurement_po_detail_purchase_id';
    }

    public function setPurchaseIdAttribute($value)
    {
        $this->attributes[$this->purchase_id()] = $value;
    }

    public function getPurchaseIdAttribute()
    {
        return $this->{$this->purchase_id()};
    }    

    public function product_id()
    {
        return 'procurement_po_detail_item_product_id';
    }

    public function setProductIdAttribute($value)
    {
        $this->attributes[$this->product_id()] = $value;
    }

    public function getProductIdAttribute()
    {
        return $this->{$this->product_id()};
    }

    public function qty()
    {
        return 'procurement_po_detail_qty';
    }

    public function setQtyAttribute($value)
    {
        $this->attributes[$this->qty()] = $value;
    }

    public function getQtyAttribute()
    {
        return $this->{$this->qty()};
    }

    public function price()
    {
        return 'procurement_po_detail_price';
    }

    public function setPriceAttribute($value)
    {
        $this->attributes[$this->price()] = $value;
    }

    public function getPriceAttribute()
    {
        return $this->{$this->price()};
    }
    
    public function total()
    {
        return 'procurement_po_detail_price';
    }

    public function setTotalAttribute($value)
    {
        $this->attributes[$this->total()] = $value;
    }

    public function getTotalAttribute()
    {
        return $this->{$this->total()};
    }

    public function product()
    {
        return $this->hasOne(Product::class, ProductFacades::getKeyName(), $this->product_id());
    }
}
