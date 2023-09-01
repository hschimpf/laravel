<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

final class AppDatabaseLoggerServiceProvider extends ServiceProvider {

    public function boot(): void {
        if (config('app.debug')) {
            $log_date = date('Y-m-d');
            $start_time = microtime(true);
            $pid = substr(md5(getmypid().$start_time.random_bytes(10)), 10, 10);

            DB::listen(static function ($query) use ($log_date, $start_time, $pid) {
                // add params to query
                while (count($query->bindings)) if (($pos = strpos($query->sql, '?')) !== false)
                    // replace query param with binding
                    $query->sql = substr_replace($query->sql, (string) (is_string($value = array_shift($query->bindings))
                        // convert encoding if string
                        ? "'".mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1')."'" : $value
                    ), $pos, 1);
                // format process elapsed time
                $elapsed = str_pad(number_format(microtime(true) - $start_time, 2), 7, ' ', STR_PAD_LEFT);
                // format query time
                $query_time = str_pad(number_format($query->time, 2), 7, ' ', STR_PAD_LEFT);
                // put query string into log
                file_put_contents(
                    filename: storage_path(sprintf("logs/%s-%s.log", $query->connectionName, $log_date)),
                    data: sprintf("[%s] <%s> %ss %sms => %s\n", date('Y-m-d H:i:s'), $pid, $elapsed, $query_time, $query->sql),
                    flags: FILE_APPEND);
            });
        }
    }

}
