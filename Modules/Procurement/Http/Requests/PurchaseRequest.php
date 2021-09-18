<?php

namespace Modules\Procurement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Procurement\Dao\Models\Purchase;
use Modules\System\Plugins\Helper;

class PurchaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    private static $model;

    public function __construct(Purchase $models)
    {
        self::$model = $models;
    }

    public function prepareForValidation()
    {
        $autonumber = Helper::autoNumber(self::$model->getTable(), self::$model->getKeyName(), 'PO' . date('Ym'), config('website.autonumber'));
        if (!empty($this->code)) {
            $autonumber = $this->code;
        }
        $map = collect($this->detail)->map(function ($item) use ($autonumber) {
            $product = new ProductRepository();
            $data_product = $product->singleRepository($item['temp_id'])->first();
            $total = $item['temp_qty'] * Helper::filterInput($item['temp_price']) ?? 0;
            $data['procurement_po_detail_purchase_id'] = $autonumber;
            $data['procurement_po_detail_item_product_id'] = $item['temp_id'];
            $data['procurement_po_detail_item_product_price'] = $data_product->item_product_sell ?? '';
            $data['procurement_po_detail_qty'] = Helper::filterInput($item['temp_qty']);
            $data['procurement_po_detail_price'] = Helper::filterInput($item['temp_price']) ?? 0;
            $data['procurement_po_detail_total'] = $total;
            return $data;
        });

        $product_value = Helper::filterInput($this->procurement_purchase_sum_product) ?? 0;
        $discount_value = Helper::filterInput($this->procurement_purchase_discount_value) ?? 0;
        $total_value = $product_value - $discount_value;

        $this->merge([
            'procurement_purchase_id' => $autonumber,
            'procurement_purchase_discount_value' => Helper::filterInput($this->procurement_purchase_discount_value) ?? 0,
            'procurement_purchase_sum_product' => $product_value,
            'procurement_purchase_sum_discount' => $discount_value,
            'procurement_purchase_sum_total' => $total_value,
            'detail' => array_values($map->toArray()),
        ]);

    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'procurement_purchase_to_id' => 'required',
                'detail' => 'required',
            ];
        }
        return [];
    }

    public function attributes()
    {
        return [
            'procurement_po_from_id' => 'Company',
        ];
    }

    public function messages()
    {
        return [
            'detail.required' => 'Please input detail product !'
        ];
    }
}
