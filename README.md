# 実装方針

まずはゴリゴリ進めよう！

細かいところとデザインは後々やればOK！

## ディレクトリ構成

/

├ log/                  ログファイル

├ nginx/                nginxコンテナ設定ファイル群

├ pgsql/                pgsqlコンテナマウントポイント

├ php-fpm/              php-fpmコンテナ設定ファイル群

├ src/                  ソースコード

├ workspace/            workspaceコンテナdockerfile

├ .env/                 環境ファイル

├ docker-compose.yml/   

└ swagger.yaml          API仕様
