<?php

namespace Modules\Procurement\Http\Services;

use Illuminate\Support\Facades\DB;
use Modules\Linen\Dao\Facades\StockFacades;
use Modules\Linen\Dao\Models\RewashDetail;
use Modules\Procurement\Dao\Models\PurchaseDetail;
use Modules\System\Dao\Interfaces\CrudInterface;
use Modules\System\Plugins\Alert;

class PurchaseCreateService
{
    public function save(CrudInterface $repository, $data)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($data->all());
            PurchaseDetail::insert($data['detail']);

            if(isset($check['status']) && $check['status']){

                Alert::create();
            }
            else{
                $message = env('APP_DEBUG') ? $check['data'] : $check['message'];
                Alert::error($message);
            }
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    } 
}
