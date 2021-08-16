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
                    {{-- post先はname指定。resourceで自動生成される。php artisan route:listで確認 --}}
                    <form method="POST" action="{{route('upload.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="title" value="{{old('title')}}" placeholder="タイトル">
                        <input type="text" name="detail" value="{{old('detail')}}" placeholder="詳細">
                        <input type="file" name="file">
                        <input type="submit" value="アップロード">
                    </form>

                    <table class="table-auto">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">タイトル</th>
                            <th class="px-4 py-2">詳細</th>
                            <th class="px-4 py-2">ファイル名</th>
                            <th class="px-4 py-2">作成日</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($uploads as $upload)
                            <tr>
                                <td class="border px-4 py-2">{{$upload->title}}</td>
                                <td class="border px-4 py-2">{{$upload->detail}}</td>
                                <td class="border px-4 py-2">{{$upload->file_name}}</td>
                                <td class="border px-4 py-2">{{$upload->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            ユーザー一覧
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">名前</th>
                            <th class="px-4 py-2">メールアドレス</th>
                            <th class="px-4 py-2">登録日</th>
                            <th class="px-4 py-2">クレカ登録</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="border px-4 py-2">{{$user->name}}</td>
                                <td class="border px-4 py-2">{{$user->email}}</td>
                                <td class="border px-4 py-2">{{$user->created_at}}</td>
                                <td class="border px-4 py-2">
                                    @if(!empty($user->stripe_id))
                                        登録済
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
