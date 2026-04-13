<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\MailHelper;
use Illuminate\Support\Facades\Log;

class SendOtherInvestorsOpportunityMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $invoices;
    public $investors;

    public function __construct($invoices, $investors)
    {
        $this->invoices = $invoices;
        $this->investors = $investors;
    }

    public function handle()
    {
        foreach ($this->investors as $investor) {
            try {
                $response = MailHelper::send(
                                $investor->email,
                                'Opportunity Missed - '. count($invoices) . ' Invoice(s) are Already Funded',
                                'mail-template.investor-missed-opportunity',
                                $data = [
                                    'invoices' => $this->invoices,
                                ]
                            );

                if (!$response['status']) {
                    Log::error("Missed opportunity mail failed for {$investor->email}({$this->invoices}): " . $response['message']);
                }

            } catch (\Exception $e) {
                Log::error('Missed Opportunity Mail failed to investor {$investor->email}: ' . $e->getMessage());
            }
        }
    }
}
