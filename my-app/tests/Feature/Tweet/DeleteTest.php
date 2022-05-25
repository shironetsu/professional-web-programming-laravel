<?php

namespace Tests\Feature\Tweet;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_delete_succeeded()
    {
        /**
         * [【Laravel】PHPUnitでテストコードを書くときのTipsやサンプルコード \- Qiita](https://qiita.com/shimotaroo/items/934e05d3d7335b545429#actingas%E3%82%92%E4%BD%BF%E3%81%A3%E3%81%9F%E6%99%82%E3%81%AB%E5%87%BA%E3%82%8B%E8%AD%A6%E5%91%8A%E3%81%B8%E3%81%AE%E5%AF%BE%E5%BF%9C)
         * > actingAsを使った時に出る警告への対応
         */
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete('/tweet/delete/' . $tweet->id);

        $response->assertRedirect('/tweet');
    }
}
