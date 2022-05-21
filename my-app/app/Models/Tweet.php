<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    //デフォルトの命名規則に従っているため不要：
    //protected $table = 'tweets';
    //protected $promaryKey = 'id';

    //主キーがauto incrementの整数値でないとき（uuid等）以下を指定：
    //public $incrementing = false;

    //主キーが整数でないとき：
    //protected $keyType = 'string';

    //マイグレーションで指定する `$table->timestamps()` が不要なとき：
    //public $timestamps = false;

    //タイムスタンプ用カラムの名前がデフォルトと異なるとき：
    //const CREATED_AT = 'created_at';
    //const UPDATED_AT = 'updated_at';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
