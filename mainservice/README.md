# Subscription-Service

how to run
-

- first run `php artisan serve --port=8000 --host=127.0.0.1`
- next run `php artisan migrate --seed`
- run this command scheduler `* * * * * cd /project-directory && php artisan schedule:run >> /dev/null 2>&1` or add `* * * * *` on `php artisan schedule:run` in cron tab
- run this command `php artisan queue:work`
- finally write few test because I don't have enough time, run `php artisan test`
