<?php

namespace App\Http\Controllers\Tweet\Update;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $tweetId = (int) $request->route('tweetId');
        // $tweet = Tweet::where('id', $tweetId)->first();
        // if(is_null($tweet)){ //Eloquentは存在しない場合nullを返す
        //     throw new NotFoundHttpException('存在しないつぶやきです');
        // }
        $tweet = Tweet::where('id', $tweetId)->firstOrFail(); //補完効かない
        return view('tweet.update')->with('tweet', $tweet);
    }
}
