@servers(['prod' => ['root@37.46.132.164']])

@task('deploy', ['on' => 'prod'])
    cd /var/www/PbxSchemeService
    git pull
    composer install
    php artisan migrate:refresh --seed
    php artisan migrate:refresh --env=testing
@endtask
