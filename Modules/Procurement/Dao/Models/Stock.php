<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\Product;
use Modules\Procurement\Dao\Facades\BranchFacades;

class Stock extends Model
{   
    use PowerJoins;
    protected $table = 'stocks';
    protected $primaryKey = 'stock_id';

    protected $fillable = [
        'stock_id',
        'stock_branch_id',
        'stock_product_id',
        'stock_qty',
    ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'stock_branch_id' => 'required',
        'stock_product_id' => 'required',
        'stock_qty' => 'required',
    ];

    public $searching = 'stock_id';

    public $datatable = [
        'stock_id' => [false => 'Code', 'width' => 50],
        'stock_branch_id' => [false => 'Code', 'width' => 50],
        'procurement_branch_name' => [true => 'Branch'],
        'item_product_name' => [true => 'Product'],
        'stock_product_id' => [false => 'Name'],
        'stock_qty' => [true => 'Qty', 'width' => 50,'class' => 'text-center', 'status' => 'status'],
    ];
    
    public $status    = [
        '1' => ['Enable', 'info'],
        '0' => ['Disable', 'default'],
    ];

    public function branch_id()
    {
        return 'stock_branch_id';
    }

    public function setBranchIdAttribute($value)
    {
        $this->attributes[$this->branch_id()] = $value;
    }

    public function getBranchIdAttribute()
    {
        return $this->{$this->branch_id()};
    }
    
    public function product_id()
    {
        return 'stock_product_id';
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
        return 'stock_qty';
    }

    public function setQtyAttribute($value)
    {
        $this->attributes[$this->qty()] = $value;
    }

    public function getQtyAttribute()
    {
        return $this->{$this->qty()};
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, BranchFacades::getKeyName(), $this->branch_id());
    }
    
    public function product()
    {
        return $this->hasOne(Product::class, ProductFacades::getKeyName(), $this->product_id());
    }
}
