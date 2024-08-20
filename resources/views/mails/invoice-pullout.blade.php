@component('mail::message')
Dear {{ $payload->customer->COMPANY }},

This email serves as a receipt for the pulled out stocks. No payment is due with this slip.
Please retain this email receipt for your records.

<br>
<table style="border: 1px solid gray; width: 100%; padding: 10px;" cellspacing="0">
 <tr>
  <td colspan="2" style="text-align: center;">
   <div style="font-size: 16px; font-weight: 500;">PULLOUT SLIP</div>
   <div style="font-size: 20px; font-weight: 700;">{{ $payload->orderslip_number }}</div>
  </td>
 </tr>
 <tr>
  <td style="border-top: 1px solid gray; width: 50%;">
    Server
  </td>
  <td style="border-top: 1px solid gray; width: 50%; text-align: right;">
    {{ $payload->prepared_by }}
  </td>
 </tr>
 <tr>
  <td style=" width: 50%;">
    Date
  </td>
  <td style=" width: 50%; text-align: right;">
    {{ $payload->date }}
  </td>
 </tr>
 <tr>
  <td style=" width: 50%;">
    Time
  </td>
  <td style=" width: 50%; text-align: right;">
    {{ $payload->time }}
  </td>
 </tr>
 <tr>
  <td style=" width: 50%;">
    Status
  </td>
  <td style=" width: 50%; text-align: right;">
    {{ $payload->status }}
  </td>
 </tr>
 <tr>
  <td colspan="2" style="border-bottom: 1px solid gray;">

  </td>
 </tr>

@foreach($payload->stores as $store)
<tr>
 <td colspan="2" style="font-weight: 500;">
  {{ trim($store->store->description) }}
 </td>
</tr>

@foreach($store->store_orders as $item)
<tr>
 <td colspan="2" style="padding-left: 20px;">
  {{ $item->parent->description }}
 </td>
</tr>

<tr>
 <td style="padding-left: 20px; width: 50%;">
    {{ $item->parent->quantity }} x {{ number_format($item->parent->price, 2) }}
 </td>
 <td style="width: 50%; text-align: right;">
    {{ number_format($item->parent->amount, 2) }}
 </td>
</tr>
@if(!empty($item->parent->remarks))
<tr>
 <td colspan="2" style="padding-left: 20px;">
    imei: {{ $item->parent->remarks }}
 </td>
</tr>
@endif
@if(!$loop->last)
<tr>
 <td colspan="2" style="padding-left: 20px;">
  <div style=" border-top: 1px solid gray; margin: 5px 0px 5px 0px;"></div>
 </td>
</tr>
@endif
@endforeach

@endforeach

<!-- DIVIDER -->
<tr>
<td colspan="2" style="border-bottom: 1px solid gray;">

</td>
</tr>
<!-- END DIVIDER -->

<!-- TOTAL -->
<tr style="font-weight: bold;">
<td style=" width: 50%;">
    TOTAL
</td>
<td style="width: 50%; text-align: right;">
    {{ $payload->total_amount }}
</td>
</tr>
<!-- END TOTAL -->

<!-- VATable Sales -->
<tr>
<td style=" width: 50%; text-align: right;">
    VATable Sales :
</td>
<td style="width: 50%; text-align: right;">
    {{ $payload->vatable_sales }}
</td>
</tr>
<!-- END VATable Sales -->

<!-- Less VAT -->
<tr>
<td style=" width: 50%; text-align: right;">
    Less VAT :
</td>
<td style="width: 50%; text-align: right;">
    {{ $payload->vat_amount }}
</td>
</tr>
<!-- END Less VAT -->

<!--VAT Ex. -->
<tr>
<td style=" width: 50%; text-align: right;">
    VAT Ex. :
</td>
<td style="width: 50%; text-align: right;">
    {{ $payload->vat_ex }}
</td>
</tr>
<!-- END VAT Ex. -->

<!--20.00% SC Disc. -->
<tr>
<td style=" width: 50%; text-align: right;">
    20.00% SC Disc. :
</td>
<td style="width: 50%; text-align: right;">
    {{ $payload->sc_discount_amount }}
</td>
</tr>
<!-- END 20.00% SC Disc. -->

<!-- GRAND TOTAL -->
<tr style="font-weight: bold; width: 50%; font-size: 20px;">
<td style="  font-weight: bold; ">
    GRAND TOTAL
</td>
<td style="width: 50%; text-align: right;">
    {{ $payload->net_amount }}
</td>
</tr>
<!-- END GRAND TOTAL -->

</table>
<br>


Thank you,<br>
{{ config('app.name') }}
@endcomponent
