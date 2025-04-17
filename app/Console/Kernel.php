<?php

namespace App\Console;

use App\Console\Commands\AuctionEndCheckCommand;
use App\Console\Commands\BulkSMSCommand;
use App\Console\Commands\NewsLetterCommand;
use App\Console\Commands\ResetCartPriceForFlashDeal;
use App\Console\Commands\SellerSubscription;
use App\Console\Commands\PushNotificationCommamd;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Cart;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        NewsLetterCommand::class,
        BulkSMSCommand::class,
        ResetCartPriceForFlashDeal::class,
        SellerSubscription::class,
        PushNotificationCommamd::class,
        AuctionEndCheckCommand::class
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:newsletter')->everyMinute();
        $schedule->command('command:bulk_sms')->everyMinute();
        $schedule->command('command:reset_cart_price')->everyMinute();
        $schedule->command('command:reset_recent_viewed_product')->daily();
        $schedule->command('command:reset_recent_viewed_product')->daily();
        $schedule->command('command:sellerSubscription')->daily();
        $schedule->command('command:pushNotificatons')->everyMinute();
        $schedule->command('command:auctionendcheck')->everyMinute();

        $schedule->call(function () {
            Cart::where('product_type', 'product')
                ->whereDoesntHave('product')
                ->delete();
                
            Cart::where('product_type', 'gift_card')
                ->whereDoesntHave('giftCard')
                ->delete();
                
            Cart::where('product_type', 'box_design')
                ->whereDoesntHave('boxDesign')
                ->delete();
        })->daily();
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
