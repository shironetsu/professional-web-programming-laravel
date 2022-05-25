<?php

namespace Tests\Unit\Services;

use App\Services\TweetService;
use Mockery;
use PHPUnit\Framework\TestCase;

class TweetServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function test_check_own_tweet() //スネークケースらしい
    {
        $tweetService = new TweetService();
        
        $mock = Mockery::mock('alias:App\Models\Tweet');
        //$mock = Mockery::mock(\App\Models\Tweet::class);

        /* 
         * [Intelephense thinks Mockery::mock\(\) returns a string · Issue \#1784 · bmewburn/vscode\-intelephense](https://github.com/bmewburn/vscode-intelephense/issues/1784)
         * mockオブジェクトがstring型で判定されてしまうバグがある。
         */
        $mock->shouldReceive('where->first')->andReturn((object)[
            'id' => 1,
            'user_id' => 1
        ]);

        $result = $tweetService->checkOwnTweet(1, 1);
        $this->assertTrue(true);

        $result = $tweetService->checkOwnTweet(2, 1);
        $this->assertFalse($result);
    }
}
