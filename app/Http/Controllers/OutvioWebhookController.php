<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class OutvioWebhookController extends Controller
{
    protected $saveLog;
    protected $readLog;

    public function __construct()
    {
        // $this->middleware('auth'); // Middleware para autenticación
        $this->middleware('auth')->except(['orders', 'shipping', 'tracking']);
        $this->saveLog = storage_path('app/public/logs/');
        $this->readLog = public_path('storage/logs/');
    }

    public function orders(Request $request)
    {
        $this->saveLog($request, 'Orders');
        return $this->response($request, 'orders');
    }

    public function shipping(Request $request)
    {
        $this->saveLog($request, 'Shipping');
        return $this->response($request, 'shipping');
    }

    public function tracking(Request $request)
    {
        $this->saveLog($request, 'Tracking');
        return $this->response($request, 'tracking');
    }

    public function readLog($type)
    {
        $logFile = $this->readLog . $type . '.log';

        if (File::exists($logFile)) {
            $logs = file_get_contents($logFile);
            $logData = array_map('json_decode', explode(PHP_EOL, $logs));

            return view('logs.index', compact('logData', 'type'));
        } else {
            return abort(404);
        }
    }

    protected function saveLog(Request $request, $type)
    {
        $logData = [
            'type' => $type,
            'data' => $request->all(),
        ];

        Log::info("$type Webhook Received", $logData);

        $logFile = $this->saveLog . $type . '.log';
        file_put_contents($logFile, json_encode($logData) . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    protected function response(Request $request, $type)
    {
        $jsonData = json_encode(['message' => 'Webhook received'], JSON_PRETTY_PRINT);

        return response()->json($jsonData)->header('Content-Type', 'application/json');
    }
}
