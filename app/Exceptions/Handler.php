<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($request->ajax() || $request->wantsJson()){
            if($exception instanceof ModelNotFoundException){
                return response()->json(['error' => 'Item not found'], 404);
            }            

            if($exception instanceof MethodNotAllowedHttpException){
                return response()->json(['error' => 'Method not allowed'], 403);
            }            

            if($exception instanceof UnauthorizedHttpException){
                return response()->json(['error' => 'Unauthorized'], 400);
            }

        }

        if ($exception instanceof \Illuminate\Http\Exceptions\PostTooLargeException) 
        {
            if($request->ajax()) return response()->json(['error' => 'You are not allowed to post too large files'], 404);
            else return redirect()->back()->withErrors(__('You are not allowed to post too large files'));
        }

        if ($exception instanceof \Illuminate\Database\QueryException) {
            //dd($exception->getMessage());
            abort(429);
        } elseif ($exception instanceof \PDOException) {
           // dd($exception->getMessage());
            abort(429);
        }

        if($exception instanceof \League\Flysystem\FileNotFoundException){
            return redirect()->back()->withErrors(__('This file is no longer available'));
        }

        return parent::render($request, $exception);
    }
}
