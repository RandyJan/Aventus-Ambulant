<?php

namespace App\Http\Controllers;

use App\Helpers\PosPrinting;
use App\Services\CartInformationService;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PosPrintController extends Controller
{
    public function index(Request $request)
    {
        $service = new CartInformationService;


        $data = null;
        $print_data = [];

        if (isset($request->orderslip_number)) {
            $data = $service->handle($request->orderslip_number);
            if ($data['success']) {
                $data = $data['data'];
                $print_data = $this->printLogic($data);
            } else {
                $data = null;
            }
        }

        if (!isset($request->preview)) {
            // dd('print');
            $this->print($print_data);
        }

        // dd($request->all());
        return response()->json([
            'message' => 'Ok',
            'data' => [
                'cart' => $data,
                'print_data' => $print_data
            ]
        ]);
    }

    protected function printLogic($data): array
    {
        $h = new PosPrinting;
        $print_data = [];
        /**
         * PRINTING
         */
        $total_length = config('settings.esc_printer.max_length') - 15;
        array_push(
            $print_data,
            $h->centerAlign(
                config('app.name'),
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->centerAlign(
                'Application',
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->charDuplicator(
                ' ',
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->charDuplicator(
                ' ',
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyBetween(
                'Server',
                $data['prepared_by'],
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyBetween(
                'Date',
                $data['date'],
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyBetween(
                'Time',
                $data['time'],
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyBetween(
                'Status',
                $data['status'],
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyBetween(
                'Total Headcount',
                $data['total_headcount'],
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyBetween(
                'Table No.',
                $data['table_number'],
                $total_length
            )
        );

        array_push(
            $print_data,
            $h->charDuplicator(
                '-',
                $total_length
            )
        );

        // ITEMS
        foreach ($data['stores'] as $key => $store) {
            foreach ($store['store_orders'] as $order) {
                // logger(gettype($order['parent']));
                $d = json_encode($order);
                $n_order = json_decode(
                    $d,
                    true
                );
                logger($n_order);

                array_push(
                    $print_data,
                    $h->justifyLeft(
                        trim($n_order['parent']['description']),
                        $total_length
                    )
                );

                array_push(
                    $print_data,
                    $h->justifyBetween(
                        $n_order['parent']['quantity'] . " x " . number_format($n_order['parent']['price']),
                        number_format($n_order['parent']['amount'], 2),
                        $total_length
                    )
                );
            }
        }


        array_push(
            $print_data,
            $h->charDuplicator(
                '-',
                $total_length
            )
        );
        // TOTALS
        array_push(
            $print_data,
            $h->justifyBetween(
                'TOTAL',
                $data['total_amount'],
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyRight(
                $h->justifyBetween(
                    "Service Charge (" . $data['service_charge_percentage'] . "%)",
                    $data['service_charge_amount'],
                    $total_length - 2
                ),
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyRight(
                $h->justifyBetween(
                    'VATable Sales',
                    $data['vatable_sales'],
                    $total_length - 2
                ),
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyRight(
                $h->justifyBetween(
                    'Less VAT',
                    $data['vat_amount'],
                    $total_length - 2
                ),
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyRight(
                $h->justifyBetween(
                    'VAT Ex.',
                    $data['vat_ex'],
                    $total_length - 2
                ),
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyRight(
                $h->justifyBetween(
                    '20.00% SC Disc.',
                    $data['sc_discount_amount'],
                    $total_length - 2
                ),
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->justifyBetween(
                'GRAND TOTAL',
                $data['net_amount'],
                $total_length
            )
        );

        // ORDERSLIP NO.
        array_push(
            $print_data,
            $h->charDuplicator(
                '-',
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->centerAlign(
                'ORDERSLIP',
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->centerAlign(
                $data['orderslip_number'],
                $total_length
            )
        );
        array_push(
            $print_data,
            $h->charDuplicator(
                '-',
                $total_length
            )
        );


        // apply margin
        $new_data = [];
        $margin = 4;
        foreach ($print_data as $key => $item) {
            array_push(
                $new_data,
                $h->centerAlign(
                    $item,
                    $total_length + $margin
                )
            );
        }

        return $new_data;
    }

    protected function print($items = [])
    {
        $connector = null;

        if (config('settings.esc_printer.type') == 'NETWORK') {
            $connector = new NetworkPrintConnector(
                config('settings.esc_printer.address'),
                config('settings.esc_printer.port')
            );
        }
        if (config('settings.esc_printer.type') == 'LOCAL') {
            $connector = new WindowsPrintConnector(
                config('settings.esc_printer.address')
            );
        }
        $printer = new Printer($connector);
        $printer->initialize();
        $printer->feed(3);
        foreach ($items as $key => $item) {
            $printer->text($item . "\n");
        }
        $printer->feed(3);
        $printer->initialize();
        $printer->cut();
        $printer->close();
    }
}
