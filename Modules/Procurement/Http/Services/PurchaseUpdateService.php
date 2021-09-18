<?php

namespace Modules\Procurement\Http\Services;

use Modules\Procurement\Dao\Facades\PurchaseDetailFacades;
use Modules\Procurement\Dao\Facades\StockFacades;
use Modules\Procurement\Dao\Models\PurchaseDetail;
use Modules\Procurement\Dao\Models\Stock;
use Modules\System\Dao\Interfaces\CrudInterface;
use Modules\System\Http\Services\UpdateService;
use Modules\System\Plugins\Alert;

class PurchaseUpdateService extends UpdateService
{
    public function update(CrudInterface $repository, $data, $code)
    {
        $check = $repository->updateRepository($data->all(), $code);
        PurchaseDetail::upsert($data['detail'], [
            PurchaseDetailFacades::purchase_id(),
            PurchaseDetailFacades::product_id(),
        ], [
            PurchaseDetailFacades::qty(),
            PurchaseDetailFacades::price(),
            PurchaseDetailFacades::total(),
        ]);

        if (isset($check['status']) && $check['status']) {
            $data = $check['data'];
            if($data->flag == 2)
            {
                foreach($data['detail'] as $detail)
                {
                    StockFacades::updateStock($data->branch_id, $detail->product_id, $detail->qty);
                }

                $data->flag = 3;
                $data->save();
            }
        }

        if ($check['status']) {
            Alert::update();
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }
}
