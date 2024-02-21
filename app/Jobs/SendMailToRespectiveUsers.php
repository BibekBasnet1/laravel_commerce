<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToRespectiveUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userOrder;

    public function __construct($userOrder)
    {
        $this->userOrder = $userOrder;
    }

    public function handle()
    {
        Mail::to($this->userOrder->email)->send(new OrderShipped($this->userOrder));
    }
}

