<?php

namespace App\Listeners;

use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Throwable;

class LogRegisteredUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        try {
            DB::beginTransaction();

            $user = $event->user;
            $customer = Customer::with('relatedUser')->create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_phone' => $user->phone,
            ]);
            $customer->relatedUser->assignRole(['customer']);

            DB::commit();
        } catch (Throwable $e) {
            dd($e);
            DB::rollBack();

            report($e);
        }
    }
}
