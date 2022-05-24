<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if (!Storage::exists('public/images')) {
            Storage::makeDirectory('public/images');
        }

        /**
         * 注
         * 画像は https://via.placeholder.com というwebサービスから取得する。
         * 例：https://via.placeholder.com/640x480.png/00aa11?text=aperiam
         * 
         * コードは /vendor/fakerphp/faker/src/Faker/Provider/Image.php に所在。
         * しかしcurlで叩くとcloudflareから403が返ってきてしまうため、適当に
         * ```php
         * curl_setopt($ch, CURLOPT_USERAGENT, 'Laravel');
         * ```
         * のようにUAを設定する回避策が必要。空でなければ何でもよさそう。
         */

        return [
            'name' => $this->faker->image(storage_path('app/public/images'), 640, 480, null, false)
        ];
    }
}
