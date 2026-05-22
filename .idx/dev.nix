{ pkgs, ... }: {
  channel = "stable-24.05";

  packages = [
    pkgs.php83
    pkgs.php83Extensions.pdo_sqlite
    pkgs.php83Extensions.sqlite3
    pkgs.php83Extensions.mbstring
    pkgs.php83Extensions.openssl
    pkgs.php83Extensions.tokenizer
    pkgs.php83Extensions.xml
    pkgs.php83Extensions.ctype
    pkgs.php83Extensions.curl
    pkgs.php83Extensions.fileinfo
    pkgs.php83Packages.composer
    pkgs.nodejs_20
    pkgs.sqlite
  ];

  env = {};

  idx = {
    extensions = [
      "bmewburn.vscode-intelephense-client"
    ];

    previews = {
      enable = true;
      previews = {
        web = {
          command = ["php" "artisan" "serve" "--port" "$PORT" "--host" "0.0.0.0"];
          manager = "web";
          env = {
            PORT = "$PORT";
          };
        };
      };
    };

    workspace = {
      onCreate = {
        install = "composer install --no-interaction --prefer-dist && cp .env.example .env && php artisan key:generate && touch database/database.sqlite && php artisan migrate:fresh --seed --force";
      };
      onStart = {
        migrate = "php artisan migrate --force";
      };
    };
  };
}
