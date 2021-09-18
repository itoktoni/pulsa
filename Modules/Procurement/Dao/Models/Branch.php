<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Branch extends Model
{
    use SoftDeletes, Userstamps;
    
    protected $table = 'procurement_branch';
    protected $primaryKey = 'procurement_branch_id';

    protected $fillable = [
        'procurement_branch_id',
        'procurement_branch_name',
        'procurement_branch_description',
        'procurement_branch_created_at',
        'procurement_branch_updated_at',
        'procurement_branch_deleted_at',        
        'procurement_branch_created_by',
        'procurement_branch_updated_by',
        'procurement_branch_deleted_by',
        'procurement_branch_status',
        'procurement_branch_address',
    ];

    public $timestamps = true;
    public $incrementing = true;
    public $rules = [
        'procurement_branch_name' => 'required|min:3',
    ];

    const CREATED_AT = 'procurement_branch_created_at';
    const UPDATED_AT = 'procurement_branch_updated_at';
    const DELETED_AT = 'procurement_branch_deleted_at';

    const CREATED_BY = 'procurement_branch_created_by';
    const UPDATED_BY = 'procurement_branch_updated_by';
    const DELETED_BY = 'procurement_branch_deleted_by';

    public $searching = 'procurement_branch_name';
    public $status_name = 'procurement_branch_status';

    public $datatable = [
        'procurement_branch_id' => [false => 'Code', 'width' => 50],
        'procurement_branch_name' => [true => 'Name'],
        'procurement_branch_status' => [true => 'Status', 'width' => 100,'class' => 'text-center', 'status' => 'status'],
    ];
    
    public $status    = [
        '1' => ['Enable', 'info'],
        '0' => ['Disable', 'default'],
    ];
}
