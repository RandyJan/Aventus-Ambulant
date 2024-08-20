<?php

namespace App\Console\Commands;

use App\Mail\InvoiceWithAttachmentMail;
use App\Mail\SendInvoiceMail;
use App\Models\OfficialReceipt;
use App\Services\OfficialReceiptInformationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AmbulantInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ambulant:invoice {or_number} {--app=laravel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send invoice to customer ';

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
        Log::debug( "command ambulant:invoice is running..." );

        $or_number = $this->argument('or_number');
        $app = $this->option('app');

        $service = new OfficialReceiptInformationService;
        $result = $service->handle($or_number);

        if(!$result['success']){
            $this->error('1|'.$result['message']);
            return Command::FAILURE;
        }

        // Log::debug( $result['data'] );

        if($result['data']['header']['account'] != null){
            if($result['data']['header']['account']['email'] != null){

                if($app == 'clarion'){

                    Mail::to(
                        $result['data']['header']['account']['email']
                    )
                    ->queue( new InvoiceWithAttachmentMail($result['data']));

                }else{
                    Mail::to(
                        $result['data']['header']['account']['email']
                    )
                    ->queue( new SendInvoiceMail($result['data']));
                }


            }
        }

        $this->info('2|'.'An email will be sent to the customer.');
        return Command::SUCCESS;
    }
}
