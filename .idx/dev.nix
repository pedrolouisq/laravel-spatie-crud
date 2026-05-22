# To learn more about how to use Nix to configure your environment
# see: https://developers.google.com/idx/guides/customize-idx-env
{ pkgs, ... }: {
  # Which channel to use.
  channel = "stable-23.11"; # or "unstable"

  # Use NixOS packages
  packages = [
    pkgs.php82
    pkgs.php82Packages.composer
    pkgs.nodejs_20
    pkgs.sqlite
  ];

  # Sets environment variables in the workspace
  env = {};

  idx = {
    # Search for the extensions you want on https://open-vsx.org/ and use "publisher.id"
    extensions = [
      "onecentlin.laravel-extension-pack"
      "bmewburn.vscode-intelephense-client"
      "amiralizadeh9480.laravel-extra-intellisense"
    ];

    # Enable previews and configure how they are run
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

    # Workspace lifecycle hooks
    workspace = {
      # Runs when a workspace is first created
      onCreate = ''
        composer install --no-interaction --prefer-dist
        npm install
        
        # Copy env file if not exists
        if [ ! -f .env ]; then
          cp .env.example .env
          php artisan key:generate
        fi

        # Setup SQLite database
        mkdir -p database
        touch database/database.sqlite
        php artisan migrate:fresh --seed --force
      '';
      
      # Runs when the workspace is started (subsequent boots)
      onStart = ''
        # Ensure dependencies and migrations are up to date
        php artisan migrate --force
      '';
    };
  };
}
