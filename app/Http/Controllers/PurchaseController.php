<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class PurchaseController extends Controller
{
    // 購入処理
    public function purchase($upload_id){
        // このユーザが購入済みなら何もしない
        $user_id = Auth::id();
        if(Purchase::where("upload_id", $upload_id)->where("user_id", $user_id)->exists()){
            return back();
        }

        // クレジットカードの決済処理
        \Stripe\Stripe::setApiKey(\Config::get('payment.stripe_secret'));

        $upload = Upload::findorFail($upload_id);

        try {

            $user = User::find(Auth::id());
            $chargeOject = [
                'amount'      => 100,
                'currency'    => 'jpy',
                // 半角英数字のみ？日本語は駄目？
                'description' => "$upload->file_nameの購入料金($user->name)",
                'customer'      => $user->stripe_id,
            ];

            $charge = \Stripe\Charge::create($chargeOject);

        } catch (\Stripe\Exception\CardException $e) {
            $body = $e->getJsonBody();
            $errors  = $body['error'];

            return redirect('/user')->with('errors', "決済に失敗しました。しばらく経ってから再度お試しください。");
        }

        // 購入履歴レコード作成
        $purchase = new Purchase();
        $purchase->upload_id = $upload_id;
        $purchase->user_id = $user_id;
        $purchase->save();

        return redirect('/user')->with('success', "$upload->file_nameの購入完了。ダウンロードして下さい");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
