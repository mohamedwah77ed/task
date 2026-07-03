<?php

namespace App\Listeners;

use App\Events\LowStockAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
class SendLowStockAlert
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowStockAlert $event): void
{
    Log::warning(
        "Low stock alert: {$event->product->name} (SKU: {$event->product->sku}) has only {$event->product->stock_quantity} items remaining."
    );
}
}
