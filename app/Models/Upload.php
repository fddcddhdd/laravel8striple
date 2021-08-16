<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    public function purchase()
    {
        // アップロードファイルIDとログインしているユーザIDの組み合わせがあれば、購入済と判断する
        return $this->hasMany(Purchase::class)->where('user_id', \Auth::id());
    }
}
