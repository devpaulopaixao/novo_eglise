<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PostbackController extends Controller
{
    public function postback(Request $request)
    {
        DB::table('postbacks')->insert([
            'postback' => json_encode($request->all())
        ]);

        $transaction_code = $request->all()['transaction']['id'];

        $transaction = Transaction::where('transaction_code', $transaction_code)->first();

        if (!is_null($transaction)) {
            $transaction->status = $request->all()['transaction']['status'];
            $transaction->save();
        }

        return;
    }

}
