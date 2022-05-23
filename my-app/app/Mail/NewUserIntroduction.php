<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
//use Illuminate\Support\Facades\Log;

class NewUserIntroduction extends Mailable implements ShouldQueue //空インターフェース
{
    use Queueable, SerializesModels;

    //このクラスのプロパティはbladeテンプレート中でそのまま使える。
    public $subject = '新しいユーザーが追加されました！';
    public User $toUser;
    public User $newUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $toUser, User $newUser)
    {
        $this->toUser = $toUser;
        $this->newUser = $newUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //Log::debug('NewUserIntroduction'); //出ない
        return $this->markdown('email.new_user_introduction');
    }
}
