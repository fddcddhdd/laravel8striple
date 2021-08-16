<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クレジットカード登録
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mt-3 list-disc list-inside text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @else
                        @if(!empty(Auth::User()->stripe_id))
                            <b>
                                すでにクレジットカードは登録されています。</br>
                                上書きしたい場合のみ再登録して下さい。</br>
                            </b>
                        @endif
                    @endif
                    @if (count($errors) > 0)
                        <div>
                            <div class="font-medium text-red-600">
                                {{ __('Whoops! Something went wrong.') }}
                            </div>

                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{route('payment.store')}}" class="card-form" id="form_payment" method="POST">
                        @csrf

                            <label for="name">カード番号</label>
                            <div id="cardNumber"></div>

                        <div class="form-group">
                            <label for="name">セキュリティコード</label>
                            <div id="securityCode"></div>
                        </div>

                        <div class="form-group">
                            <label for="name">有効期限</label>
                            <div id="expiration"></div>
                        </div>

                        <div class="form-group">
                            <label for="name">カード名義</label>
                            <input type="text" name="cardName" id="cardName" class="form-control" value="" placeholder="カード名義を入力">
                        </div>
                        <div class="form-group">
                            <input type="submit" id="create_token" value="カードを登録する"></input>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe_key = '{{ config('payment.stripe_key') }}';
</script>
<script src="{{asset('js/payment.js')}}"></script>
