<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Supplier extends Model
{
    use SoftDeletes, Userstamps;
    
    protected $table = 'procurement_supplier';
    protected $primaryKey = 'procurement_supplier_id';

    protected $fillable = [
        'procurement_supplier_id',
        'procurement_supplier_name',
        'procurement_supplier_description',
        'procurement_supplier_created_at',
        'procurement_supplier_updated_at',
        'procurement_supplier_deleted_at',        
        'procurement_supplier_created_by',
        'procurement_supplier_updated_by',
        'procurement_supplier_deleted_by',
        'procurement_supplier_status',
        'procurement_supplier_address',
    ];

    public $timestamps = true;
    public $incrementing = true;
    public $rules = [
        'procurement_supplier_name' => 'required|min:3',
    ];

    const CREATED_AT = 'procurement_supplier_created_at';
    const UPDATED_AT = 'procurement_supplier_updated_at';
    const DELETED_AT = 'procurement_supplier_deleted_at';

    const CREATED_BY = 'procurement_supplier_created_by';
    const UPDATED_BY = 'procurement_supplier_updated_by';
    const DELETED_BY = 'procurement_supplier_deleted_by';

    public $searching = 'procurement_supplier_name';
    public $status_name = 'procurement_supplier_status';

    public $datatable = [
        'procurement_supplier_id' => [false => 'Code', 'width' => 50],
        'procurement_supplier_name' => [true => 'Name'],
        'procurement_supplier_status' => [true => 'Status', 'width' => 100,'class' => 'text-center', 'status' => 'status'],
    ];
    
    public $status    = [
        '1' => ['Enable', 'info'],
        '0' => ['Disable', 'default'],
    ];
}
