<?php

namespace App\Console\Commands;

use App\Mail\InvoicePulloutMail;
use App\Services\CartInformationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvoicePullout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:pullout {orderslip_number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send invoice pullout email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $orderslip_number = $this->argument('orderslip_number');

        // $this->info("orderslip_number: " . $orderslip_number);

        $service = new CartInformationService;

        $result = $service->handle($orderslip_number);

        if (!$result['success']) {
            $this->error($result['message']);
            return Command::INVALID;
        }

        if (empty($result['data']['customer'])) {
            $this->error('No Customer data.');
            return Command::INVALID;
        }

        if (empty(trim($result['data']['customer']['EMAILADDRESS']))) {
            $this->error('No Customer Email Address.');
            return Command::INVALID;
        }

        //
        $payload = json_decode( json_encode($result['data']));
        $response = response()->json([
            'message' => 'Ok',
            'data' => $result['data']
        ]);

        $payload = $response->getData()->data;

        Mail::to(
            trim($result['data']['customer']['EMAILADDRESS'])
        )
            ->queue(new InvoicePulloutMail($payload));
        //

        $this->info('An email will be sent to the customer...');
        return Command::SUCCESS;
    }
}
