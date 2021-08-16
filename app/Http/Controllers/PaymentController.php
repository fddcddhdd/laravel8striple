<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payment.form');
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
        /**
         * フロントエンドから送信されてきたtokenを取得
         * これがないと一切のカード登録が不可
         **/
        $token = $request->stripeToken;
        $user = \Auth::user(); //要するにUser情報を取得したい
        $ret = null;

        /**
         * 当該ユーザーがtokenもっていない場合Stripe上でCustomer（顧客）を作る必要がある
         * これがないと一切のカード登録が不可
         **/
        if ($token) {

            /**
             *  Stripe上にCustomer（顧客）が存在しているかどうかによって処理内容が変わる。
             *
             * 「初めての登録」の場合は、Stripe上に「Customer（顧客」と呼ばれる単位の登録をして、その後に
             * クレジットカードの登録が必要なので、一連の処理を内包しているPaymentモデル内のsetCustomer関数を実行
             *
             * 「2回目以降」の登録（別のカードを登録など）の場合は、「Customer（顧客」を新しく登録してしまうと二重顧客登録になるため、
             *  既存のカード情報を取得→削除→新しいカード情報の登録という流れに。
             *
             **/

            if (!$user->stripe_id) {
                $result = Payment::setCustomer($token, $user);

                /* card error */
                if(!$result){
                    $errors = "カード登録に失敗しました。入力いただいた内容に相違がないかを確認いただき、問題ない場合は別のカードで登録を行ってみてください。";
                    return redirect('/user/payment/form')->with('errors', $errors);
                }

            } else {
                $defaultCard = Payment::getDefaultcard($user);
                if (isset($defaultCard['id'])) {
                    Payment::deleteCard($user);
                }

                $result = Payment::updateCustomer($token, $user);

                /* card error */
                if(!$result){
                    $errors = "カード登録に失敗しました。入力いただいた内容に相違がないかを確認いただき、問題ない場合は別のカードで登録を行ってみてください。";
                    return redirect('/user/payment/form')->with('errors', $errors);
                }

            }
        } else {
            return redirect('/user/payment')->with('errors', '申し訳ありません、通信状況の良い場所で再度ご登録をしていただくか、しばらく立ってから再度登録を行ってみてください。');
        }


        return redirect('/user/payment')->with("success", "カード情報の登録が完了しました。");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
