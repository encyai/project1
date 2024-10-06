<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Admin;
use App\Models\Investment;
use App\Models\Transaction;
use Carbon\Carbon;

class CronController extends Controller
{

    public function cron()
    {
        try {
            $now = Carbon::now();
            $general = gs();
            $general->last_cron = $now;
            $general->save();

            $investments = Investment::where('status', Status::RUNNING)  // Status: 2=>Running, 1=>Completed
                ->where('next_return_date', '<=', $now)->with('plan', 'user')->get();

            foreach ($investments as $data) {
                $user = $data->user;
                $user->balance += $data->interest_amount;
                $user->save();

                $data->next_return_date = Carbon::now()->addDay();
                $data->total_paid += 1; //times increment

                if ($data->total_paid >= $data->total_return) {
                    $data->status = Status::COMPLETED; //1
                }
                $data->save();

                $transaction = new Transaction();
                $transaction->user_id      = $data->user_id;
                $transaction->amount       = $data->interest_amount;
                $transaction->charge       = 0;
                $transaction->post_balance = $user->balance;
                $transaction->trx_type     = '+';
                $transaction->remark       = 'interest';
                $transaction->trx          = getTrx();
                $transaction->details      = 'Get interest from ' . $data->plan->name;
                $transaction->save();
            }
        } catch (\Exception $ex) {

            $admin = Admin::first();
            notify($admin, 'DEFAULT', [
                'subject' => $ex->getMessage(),
                'message' => $ex->getMessage(),
            ], ['email'], false);

            \Log::error('CronController -> investment() line ' . __LINE__ . ': ' . $ex->getMessage() . "\n");
        }
    }
}
