<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;

class DatabaseLogger extends AbstractProcessingHandler{
protected function write(array $record): void
 {
    DB::table('error_logs')->insert([
        'type' => $record['level_name'],
        'message' => $record['message'],
        'trace' => $record['context']['exception']->getTraceAsString() ?? null,
        'file' => $record['context']['exception']->getFile() ?? null,
        'line' => $record['context']['exception']->getLine() ?? null,
        'payload' => $record['context']['payload'] ? json_encode( $record['context']['payload']) : null,
        'created_at' => now(),
    ]);
  }
}


// try {
//     // Your code...
// } catch (\Exception $e) {
//     $payload = [
//         'key1' => 'value1',
//         'key2' => 'value2',
//         // Include other data as needed
//     ];

//     Log::channel('database')->error($e->getMessage(), [
//         'exception' => $e,
//         'payload' => $payload,
//     ]);
// }
// parent::report($exception);
