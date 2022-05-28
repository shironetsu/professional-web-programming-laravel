『プロフェッショナルWebプログラミング　Laravel』を読みます。

[プロフェッショナルWebプログラミング　Laravel｜株式会社エムディエヌコーポレーション](https://books.mdn.co.jp/books/3221303041/)

# インストール
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-plarform-reqs
```

adminerのようなデータベース管理ツールは付属していないため別途用意。

参考：VSCode拡張の[MySQL \- Visual Studio Marketplace](https://marketplace.visualstudio.com/items?itemName=cweijan.vscode-mysql-client2)

# メモ
## p.36
MySQL8.0の `character_set_*` 系のシステム変数で `character_set_system` だけ `utfmb3` (`utf8`のエイリアス)になっているが、この値は固定値。

> The character set used by the server for storing identifiers. The value is always utf8.

[MySQL :: MySQL 8\.0 Reference Manual :: 5\.1\.8 Server System Variables](https://dev.mysql.com/doc/refman/8.0/en/server-system-variables.html#sysvar_character_set_system)

## p.46
Bladeのコメントは
```
{{-- ここはコメントアウト --}}
```
のように書ける。生成されるHTML上にも残らない。

[Blade Templates \- Laravel \- The PHP Framework For Web Artisans](https://laravel.com/docs/9.x/blade#comments)

## p.116
Middleware の書き方は
```diff
public function handle(Request $request, Closure $next, ...$guards)
{
    /** 前に処理をはさみたい場合ここに記述する **/
-    return $next($request);
+    $response = $next($request);
    /** 後に処理をはさみたい場合ここに記述する **/

+    return $response
}
```
が正しい。

[Middleware \- Laravel \- The PHP Framework For Web Artisans](https://laravel.com/docs/9.x/middleware#before-after-middleware)

## p.146
この後でも度々注意コメントがされているが、CSSは都度ビルドが必要。
ソースを書き換えてページの表示を見る前に
```
sail npm run development
```
で再ビルドするか、
```
sail npm run watch
```
で常駐させておくかする。忘れるとデザイン崩れに頭を悩ませるはめになる。

## p.214 
`@component` の前に空白を入れると崩れる。

## p.224
Fakerで画像が作られず、データベースに空のパスが入る。`storage/public/images` を見ても画像が入っていない。

ソースは `/vendor/fakerphp/faker/src/Faker/Provider/Image.php` にある。
[placeholder.com](https://via.placeholder.com)という、画像をランダムに提供してくれるサービスを使っていて、
curlで取得しようとして403エラーで弾かれている。User-Agentが空なのが良くないようで、適当に設定してやると通るようになる。

```diff
        // save file
        if (function_exists('curl_exec')) {
            // use cURL
            $fp = fopen($filepath, 'w');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FILE, $fp);

+            //cloudflareに弾かれるためUAを設定
+            curl_setopt($ch, CURLOPT_USERAGENT, 'curl');
            
            $success = curl_exec($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200;
            fclose($fp);
            curl_close($ch);

            if (!$success) {
                unlink($filepath);

                // could not contact the distant URL or HTTP error - fail silently.
                return false;
            }
        }
```

## p.239
resources/views/components/tweet/form/images.blade.phpで`<div x-data="inputFormHandler()" class="my-2">` のあとに続けて
`<script>`タグを書くように指示があるが、順序を逆にする必要がある。

## p.252
`Mockery::mock` が `string` 型を返すと判定されてVSCodeで警告が出る。

[Intelephense thinks Mockery::mock\(\) returns a string · Issue \#1784 · bmewburn/vscode\-intelephense](https://github.com/bmewburn/vscode-intelephense/issues/1784)

```php
         /** @var  Mockery\MockInterface $mock */
        $mock->shouldReceive('where->first')->andReturn((object)[
```

のように `@var` コメントを追加すると回避できる。

## p.261
**未解決**。`sail artisan dusk:install` が失敗する。

```
$ sail artisan dusk:install
Dusk scaffolding installed successfully.
Downloading ChromeDriver binaries...

   ErrorException 

  file_get_contents(): SSL operation failed with code 1. OpenSSL Error messages:
error:0A000126:SSL routines::unexpected eof while reading

  at vendor/laravel/dusk/src/Console/ChromeDriverCommand.php:217
    213▕         if ($this->option('proxy')) {
    214▕             $streamOptions['http'] = ['proxy' => $this->option('proxy'), 'request_fulluri' => true];
    215▕         }
    216▕ 
  ➜ 217▕         return trim(file_get_contents($this->latestVersionUrl, false, stream_context_create($streamOptions)));
    218▕     }
    219▕ 
    220▕     /**
    221▕      * Detect the installed Chrome / Chromium major version.

      +27 vendor frames 
  28  artisan:37
      Illuminate\Foundation\Console\Kernel::handle()
```

OpenSSL関連のバグ？ openssl.cnfを変更する方法を試すも改善せず。
- [I have problem with new ubuntu 22\.04 and openssl 3\.0\.2 \- Ask Ubuntu](https://askubuntu.com/questions/1405100/i-have-problem-with-new-ubuntu-22-04-and-openssl-3-0-2)
- [PHP :: Bug \#79589 :: error:14095126:SSL routines:ssl3\_read\_n:unexpected eof while reading](https://bugs.php.net/bug.php?id=79589)

## p.275
サブディレクトリ内にアプリを作っている場合、
```yml
defaults:
  run:
    working-directory: my-app
```
のように `env` と `jobs` の間で指定する。

[Workflow syntax for GitHub Actions \- GitHub Docs](https://docs.github.com/en/actions/using-workflows/workflow-syntax-for-github-actions#defaultsrun)

## p.286
原則はリポジトリのルートディレクトリにアプリ本体と `Procfile` を配置するが、
サブディレクトリでもデプロイは可能。ここ

[git \- Automated heroku deploy from subfolder \- Stack Overflow](https://stackoverflow.com/questions/39197334/automated-heroku-deploy-from-subfolder)

で解説されている方法に従って、

- Config Varに追加で`PROJECT_PATH`の値にそのサブディレクトリ名を指定
- Buildpackの1番目（PHPとNode.jsより先）に　‘https://github.com/timanovsky/subdir-heroku-buildpack.git` を指定

すると良い。

## p.296
Authorized Recipientsへの追加後にそのメールアドレスに確認用のリンクが届き、開いて認証することで初めて有効になる。
Mailgun無料版ではAuthorized Recipients宛てのメール送信しか正常終了しないため、それ以外のユーザーは登録時のリダイレクトでこける。