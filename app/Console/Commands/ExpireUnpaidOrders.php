<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire-unpaid {--dry-run : Run without actually updating orders}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark unpaid orders as expired if payment deadline has passed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = Carbon::now();
        $dryRun = $this->option('dry-run');

        $this->info("Starting order expiration check at {$now->toDateTimeString()}");

        if ($dryRun) {
            $this->warn('DRY RUN MODE: No orders will be updated');
        }

        // Find all orders that should be expired using scope
        $expiredOrders = Order::needsExpiration()->get();

        $count = $expiredOrders->count();

        if ($count === 0) {
            $this->info('No orders to expire.');
            return self::SUCCESS;
        }

        $this->info("Found {$count} orders to expire.");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($expiredOrders as $order) {
            if (!$dryRun) {
                $order->markAsExpired();

                Log::info('Order expired automatically', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'expired_at' => $order->expired_at,
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info("Successfully expired {$count} orders.");

        return self::SUCCESS;
    }
}
