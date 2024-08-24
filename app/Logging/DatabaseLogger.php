<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Illuminate\Support\Facades\DB;

class DatabaseLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger('database');

        $handler = new class extends AbstractProcessingHandler {
            protected function write($record): void
            {
                $exception = !empty($record['context']['ex'])     ? $record['context']['ex']      :  null;
                $request =  !empty($record['context']['request']) ? $record['context']['request'] :  null;
                $payload =  !empty($record['context']['payload']) ? $record['context']['payload'] :  null; // This is for Logs from Artisan commands or other tasks.

                  DB::table('exception_logs')->insert([
                    'user_id'        => !empty(auth()->check()) ? auth()->user()->id : null,
                    'exception_type' => !empty($exception) ? get_class($exception) : null,
                    'message'        => !empty($exception) ? $exception->getMessage() : null,
                    'code'           => !empty($exception) ? $exception->getCode() : null,
                    'file'           => !empty($exception) ?  $exception->getFile() : null,
                    'line'           => !empty($exception) ? $exception->getLine()  : null,
                    'stack_trace'    => !empty($exception) ? $exception->getTraceAsString() : null,
                    'url'            => !empty($request) ? $request->fullUrl() : null,
                    'method'         => !empty($request) ? $request->method() : null,
                    'ip'             => !empty($request) ? $request->ip() : null,
                    'request_data'   => !empty($request) ? json_encode($request->all()) : (!empty($payload) ? json_encode($payload) : null),
                    'headers'        => !empty($request) ? json_encode($request->headers->all()) : null,
                    'created_at'     => now(),
                    'updated_at'     =>now()
                ]);

            }
        };

        $logger->pushHandler($handler);

        return $logger;
    }
}
