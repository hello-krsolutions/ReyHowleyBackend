<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Error 500 | Rey Howley</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .error-box {
            background: white;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 80px;
            margin: 0;
            color: #333;
        }

        p {
            color: #666;
            font-size: 18px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #00aa96;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .debug-info {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
            text-align: left;
            max-width: 800px;
            overflow-x: auto;
        }

        .debug-info h3 {
            color: #856404;
            margin-top: 0;
        }

        .debug-info pre {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 12px;
        }

        .debug-info .error-message {
            color: #721c24;
            font-weight: bold;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-box">
            <h1>500</h1>
            <p>Server Error</p>
            <a class="btn" href="{{ url('/') }}">Go Home</a>
            <a class="btn" href="{{ url()->current() }}">Reload</a>
        </div>

        @if(config('app.debug') === true && isset($exception))
            <div class="debug-info">
                <h3>🔧 Debug Information (APP_DEBUG is enabled)</h3>
                <p class="error-message">{{ $exception->getMessage() }}</p>
                <p><strong>File:</strong> {{ $exception->getFile() }}</p>
                <p><strong>Line:</strong> {{ $exception->getLine() }}</p>
                <h4>Stack Trace:</h4>
                <pre>{{ $exception->getTraceAsString() }}</pre>
            </div>
        @endif

        @if(config('app.debug') === true && !isset($exception))
            <div class="debug-info">
                <h3>🔧 Debug Mode Enabled</h3>
                <p>APP_DEBUG is true, but no exception details were passed to this view.</p>
                <p>Check <code>storage/logs/laravel.log</code> for error details.</p>
                <p><strong>Tip:</strong> The error might be happening before the exception handler runs.</p>
            </div>
        @endif
    </div>
</body>

</html>