<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
use Modules\Procurement\Dao\Facades\PurchaseFacades;
use Modules\Procurement\Dao\Facades\SupplierFacades;
use Modules\Procurement\Dao\Presenteres\PurchasePresenter;
use Wildside\Userstamps\Userstamps;

class Purchase extends Model
{
    use SoftDeletes, Userstamps, PowerJoins;

    protected $table = 'procurement_purchase';
    protected $primaryKey = 'procurement_purchase_id';

    protected $fillable = [
        'procurement_purchase_id',
        'procurement_purchase_created_at',
        'procurement_purchase_updated_at',
        'procurement_purchase_deleted_at',
        'procurement_purchase_created_by',
        'procurement_purchase_updated_by',
        'procurement_purchase_deleted_by',
        'procurement_purchase_code_reff',
        'procurement_purchase_code_quotation',
        'procurement_purchase_code_prepare',
        'procurement_purchase_code_delivery',
        'procurement_purchase_code_invoice',
        'procurement_purchase_date_order',
        'procurement_purchase_from_id',
        'procurement_purchase_to_id',
        'procurement_purchase_status',
        'procurement_purchase_notes_internal',
        'procurement_purchase_notes_external',
        'procurement_purchase_branch_id',
        'procurement_purchase_sum_product',
        'procurement_purchase_discount_name',
        'procurement_purchase_discount_percent',
        'procurement_purchase_discount_value',
        'procurement_purchase_sum_discount',
        'procurement_purchase_sum_total',
    ];

    // public $with = ['module'];

    public $timestamps = true;
    public $incrementing = false;
    public $rules = [
        'procurement_purchase_id' => 'required|min:3',
    ];

    const CREATED_AT = 'procurement_purchase_created_at';
    const UPDATED_AT = 'procurement_purchase_updated_at';
    const DELETED_AT = 'procurement_purchase_deleted_at';

    const CREATED_BY = 'procurement_purchase_created_by';
    const UPDATED_BY = 'procurement_purchase_updated_by';
    const DELETED_BY = 'procurement_purchase_deleted_by';

    public $searching = 'procurement_purchase_id';
    public $datatable = [
        'procurement_purchase_id' => [true => 'Code'],
        'procurement_purchase_created_at' => [true => 'Created At'],
        'procurement_purchase_date_order' => [true => 'Purchase Date'],
        'procurement_supplier_name' => [true => 'Supplier'],
        'procurement_purchase_sum_total' => [true => 'Total'],
        'procurement_purchase_status' => [true => 'Status', 'width' => 100, 'class' => 'text-center', 'status' => 'status'],
    ];

    protected $casts = [
        'procurement_purchase_date_order' => 'datetime:Y-m-d',
        'procurement_purchase_created_at' => 'datetime:Y-m-d',
    ];

    public $status    = [
        '1' => ['Create', 'info'],
        '2' => ['Receive', 'default'],
        '3' => ['Finish', 'success'],
        '4' => ['Cancel', 'danger'],
    ];

    public function detail_id()
    {
        return 'procurement_po_detail_purchase_id';
    }

    public function flag()
    {
        return 'procurement_purchase_status';
    }

    public function setFlagAttribute($value)
    {
        $this->attributes[$this->flag()] = $value;
    }

    public function getFlagAttribute()
    {
        return $this->{$this->flag()};
    }

    public function branch_id()
    {
        return 'procurement_purchase_branch_id';
    }

    public function setBranchIdAttribute($value)
    {
        $this->attributes[$this->branch_id()] = $value;
    }

    public function getBranchIdAttribute()
    {
        return $this->{$this->branch_id()};
    }

    public function supplier_id()
    {
        return 'procurement_purchase_to_id';
    }

    public function setSupplierIdAttribute($value)
    {
        $this->attributes[$this->supplier_id()] = $value;
    }

    public function getSupplierIdAttribute()
    {
        return $this->{$this->supplier_id()};
    }

    public function detail()
    {
        return $this->hasMany(PurchaseDetail::class, $this->detail_id(), PurchaseFacades::getKeyName());
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, SupplierFacades::getKeyName(), $this->supplier_id());
    }
}
