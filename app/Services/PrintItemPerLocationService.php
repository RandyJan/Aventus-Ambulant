<?php

namespace App\Services;

use App\Http\Resources\OrderslipDetail as ResourcesOrderslipDetail;
use App\Models\Location;
use App\Models\OrderSlipDetail;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

class PrintItemPerLocationService
{

    /**
     * @param String $osnumber
     * @param App\Models\OrderSlipDetail $items
     * @param String $header_title
     * @return array
     */
    public function handle(
        $osnumber = null,
        Collection $items,
        $header_title = null,
        $restaurant_table = null
    ): array {
        try {
            DB::beginTransaction();

            foreach ($items->groupBy('PRODUCTGROUP') as $key => $location_items) {
                # code...
                $nKey = trim($key);

                // Log::debug('PRINTER LOCATION ID: ', [$nKey]);

                $location = Location::where('PRODGROUP_ID', $nKey)->first();

                if ($location && !empty($location->PRINTER_IP)) {

                    $pingResult = checkPing($location->PRINTER_IP);
                    if (!$pingResult) {
                        continue;
                    }

                    $connector = new NetworkPrintConnector($location->PRINTER_IP, 9100);
                    $printer = new Printer($connector);

                    /* Initialize */
                    $printer->initialize();

                    $printer->feed(3);
                    $printer->setTextSize(2, 2);

                    if ($header_title != null) {
                        $printer->text($header_title . "\n");
                    }

                    // $printer -> text($osnumber . "\n");
                    if (!empty($restaurant_table)) {
                        $printer->text($restaurant_table . "\n");
                    }

                    foreach ($location_items as $key => $item) {
                        # code...
                        $printer->setTextSize(2, 2);

                        $printer->text("x" . $item->QUANTITY . "\n");
                        $printer->text($item->product->SHORTCODE . "\n");

                        if ($item->MAIN_PRODUCT_ID == $item->PRODUCT_ID && !empty($item->REMARKS)) {
                            $printer->selectPrintMode(); // Reset
                            $printer->text('notes: ' . $item->REMARKS . "\n");
                        }
                    }

                    $printer->feed(3);
                    $printer->initialize();
                    $printer->cut();
                    $printer->close();
                }
            }

            DB::commit();
            return [
                'success' => true,
                'message' => 'Ok'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
