<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userOrder;

    public function __construct($userOrder)
    {
        $this->userOrder = $userOrder;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $userOrder = $this->userOrder; 

        Mail::to('testreceiver@gmail.com')->send(new OrderShipped($userOrder));
    }

}


