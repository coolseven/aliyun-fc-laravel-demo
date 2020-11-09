<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{
    public function inspire(Request $request)
    {
        Log::info('loaded extensions: ',[
            'list' => get_loaded_extensions(),
        ]);


        // 一句名人名言
        $quote = Inspiring::quote();

        // 调用第三方的 api, 获取中文翻译
        try {
            $translation = app('translate')->translate($quote, 'en','zh-CHS');
            $quoteInChinese = ($translation['translation'][0]);
        } catch (\Throwable $exception) {
            Log::error('translate failed!',[
                'quote' => $quote,
                'exception' => $exception,
            ]);
            $quoteInChinese = '[Translation Error] '. $exception->getMessage();
        }


        // 访问 redis
        $inspiredVisitors = (int) Cache::get('cache:inspired-visitors');
        Cache::increment('cache:inspired-visitors');

        // 访问 log 系统
        Log::info('new request arrived.', [
                'request' => $request->__toString(),
                'quote' => $quote,
                'inspiredVisitors' => $inspiredVisitors,
            ]
        );

        if ($request->wantsJson()) {
            return new JsonResponse([
                'quote' => $quote,
                'quoteInChinese' => $quoteInChinese,
                'inspiredVisitors' => $inspiredVisitors,
            ]);
        }

        return view('inspire',[
            'quote' => $quote,
            'quoteInChinese' => $quoteInChinese,
            'inspiredVisitors' => $inspiredVisitors,
        ]);
    }

    public function helloWorld()
    {
        return 'Hello World ' . date('Y-m-d H:i:s');
    }
}
