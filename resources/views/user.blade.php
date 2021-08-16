<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            ファイル一覧
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(empty(Auth::User()->stripe_id))
                        <div class="mt-3 list-disc list-inside text-sm text-red-600">
                            購入するにはクレジットカードの登録が必要です</br>
                        </div>
                        <a href="{{url('user/payment')}}">登録画面へ</a>
                    @endif
                    @if (session('success'))
                        <div class="mt-3 list-disc list-inside text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('errors'))
                        <div class="mt-3 list-disc list-inside text-sm text-red-600">
                            {{ session('errors') }}
                        </div>
                    @endif

                    <table class="table-auto">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">タイトル</th>
                            <th class="px-4 py-2">詳細</th>
                            <th class="px-4 py-2">ファイル名</th>
                            <th class="px-4 py-2">公開日</th>
                            <th class="px-4 py-2">購入</th>
                            <th class="px-4 py-2">価格</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($uploads as $upload)
                            <tr>
                                <td class="border px-4 py-2">{{$upload->title}}</td>
                                <td class="border px-4 py-2">{{$upload->detail}}</td>
                                <td class="border px-4 py-2">{{$upload->file_name}}</td>
                                <td class="border px-4 py-2">{{$upload->created_at}}</td>
                                <td class="border px-4 py-2">
                                    @if($upload->purchase->isEmpty())
                                        <a href={{url("user/purchase/$upload->id")}}>
                                            購入する
                                        </a>
                                    @else
                                        <a href={{url("user/download/$upload->id")}}>
                                            ダウンロード
                                        </a>
                                    @endif
                                </td>
                                <td class="border px-4 py-2">税込100円</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
