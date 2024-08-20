<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderSlipDetails extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(
            [
                'os_number'         => $this->OSNUMBER,
                "orderslipno"       => $this->ORDERSLIPNO,
                'orderslip_detail_id' => $this->ORDERSLIPDETAILID,
                'branch_id'         => $this->BRANCHID,
                'outlet_id'         => $this->OUTLETID,
                'device_id'         => $this->DEVICENO,
                'product_id'        => $this->PRODUCT_ID,
                "price"             => (float)$this->RETAILPRICE,
                "quantity"          => round($this->QUANTITY),
                "description"       => $this->product->DESCRIPTION,
                "unit_measure"      => $this->UNITMEASURE,
                "amount"            => (float)$this->AMOUNT,
                "net_amount"        => (float)$this->NETAMOUNT,
                'remarks'           => $this->REMARKS,
                'img_path'          => $this->product->IMAGE ? Storage::url($this->product->IMAGE) : '/assets/default-product.png',
                'requested_qty'     => $this->REQUESTEDQTY,
                // 'main_os_number'    => $this->MAIN_OSNUMBER,
                'main_product_id'   => $this->MAIN_PRODUCT_ID,
                'main_product_component_id'   => $this->MAIN_PRODUCT_COMPONENT_ID,
                'sequence'          => $this->SEQUENCE,
                'part_number'       => $this->PARTNO,
                'kds_id'            => $this->LOCATIONID,
                'location'          => $this->PRODUCTGROUP,
                'os_sc_id'          => $this->OS_SC_ID,
                'os_sc'             => $this->whenLoaded('os_sc'),
                'vatable_sales'     => $this->VATABLE_SALES,
                'vat_amount'        => $this->VAT_AMOUNT,
                'sc_discount_percentage'    => $this->SC_DISCOUNT_PERCENTAGE,
                'sc_discount_amount'        => $this->SC_DISCOUNT_AMOUNT,
                'sc_headcount'      => $this->SC_COUNT,
                'reg_headcount'     => $this->REG_COUNT,
                'is_group_meal'      => $this->IS_GROUP_MEAL,
                'group_serving'     => $this->GROUP_SERVING,
                'confirmed_at'      => $this->CONFIRMED_AT,
                'available'         => (int)$this->AVAILABLE,
                'customer_name'     =>$this->CUSTOMERNAME
            ],
            // parent::toArray($request)
        );
    }
}
