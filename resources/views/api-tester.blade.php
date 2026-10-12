<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Tester - Android TV Logger</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">🧪 Dummy Tester API Activity Logs</h1>
        <p class="text-gray-600 mb-6">Gunakan halaman ini untuk mensimulasikan pengiriman data log dari aplikasi Android
            TV ke endpoint Laravel.</p>

        <div class="mb-4 p-4 bg-gray-50 rounded border">
            <p class="text-sm font-semibold text-gray-700">Target Device UUID:</p>
            <p class="text-mono text-indigo-600 font-bold">{{ $device->device_uuid }}</p>
        </div>

        <form action="{{ route('test.api.send') }}" method="POST">
            @csrf
            <input type="hidden" name="device_uuid" value="{{ $device->device_uuid }}">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 font-medium">
                Kirim Dummy Logs (Simulasi TV)
            </button>
        </form>

        @if(session('status_code'))
            <div
                class="mt-6 p-4 rounded {{ session('status_code') == 201 ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }}">
                <h3 class="font-bold">Respon Server (Status: {{ session('status_code') }})</h3>
                <pre
                    class="mt-2 text-xs bg-white p-2 rounded border overflow-x-auto">{{ json_encode(session('response_body'), JSON_PRETTY_PRINT) }}</pre>
            </div>

            <div class="mt-4 p-4 rounded bg-gray-50 border border-gray-200 text-gray-800">
                <h3 class="font-bold text-sm">Payload yang Dikirim:</h3>
                <pre
                    class="mt-2 text-xs bg-white p-2 rounded border overflow-x-auto">{{ json_encode(session('payload_sent'), JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif
    </div>
</body>

</html>