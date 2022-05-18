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