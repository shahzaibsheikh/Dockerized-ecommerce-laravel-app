<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;
// use Illuminate\Support\Facades\Log;

class LogException extends Model
{
    use HasFactory;

    protected $fillable=[
     'user_id',
     'exception_type',
     'message',
     'code',
     'file',
     'line',
     'stack_trace',
     'url',
     'method',
     'ip',
     'request_data',
     'headers'
    ];

    protected $casts=[
        'request_data'=>'array',
        'headers'=>'array'
    ];


    public static function  logError(?Request $request=null, Throwable $exception, ?array $payload=null){

        return self::create([
            'user_id'=> auth()->check() ? auth()->user()->id : null,
            'exception_type'=>get_class($exception),
            'message'=> $exception->getMessage(),
            'code'=> $exception->getCode(),
            'file'=> $exception->getFile(),
            'line'=> $exception->getLine(),
            'stack_trace'=>$exception->getTraceAsString(),
            'url'=> $request ? $request->fullUrl() : null,
            'method'=> $request ? $request->method() : null,
            'ip'=> $request ? $request->ip() : null,
            'request_data'=> $request ? json_encode($request->all()) : json_encode($payload),
            'headers'=> $request ? json_encode($request->headers->all()) : null,
            'created_at' => now()
        ]);
    }


    // try {
    //     // Your code...
    // } catch (Throwable $e) {
    //     $payload = [
    //         'some_key' => 'some_value',
    //         'another_key' => 'another_value',
    //     ];

    //     LogException::logError(null, $e, $payload);
    // }

}
