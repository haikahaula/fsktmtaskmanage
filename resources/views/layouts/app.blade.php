<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap for dropdown (optional if you already use another UI lib) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css?v=3.2.0">

</head>

<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <!-- Notifications -->
@auth
<div class="fixed top-4 right-4 z-[1001]">
    <button id="notificationToggle"
        class="relative inline-flex items-center justify-center w-10 h-10 bg-white rounded-full hover:bg-gray-100 focus:outline-none">
        🔔
        @if (auth()->user()->unreadNotifications->count())
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500"></span>
        @endif
    </button>
</div>

<!-- Moved outside so it's not cut off by container -->
<div id="notificationDropdown"
    class="hidden fixed top-16 right-4 w-80 max-w-[95vw] bg-white border border-gray-200 rounded-lg shadow-xl z-[1000]">
    <div class="p-3 border-b font-semibold text-gray-700">
        Notifications
        <button class="float-right text-sm text-blue-500 hover:underline" onclick="markAllRead()">Mark all as read</button>
    </div>
    <div class="max-h-96 overflow-y-auto">
        @forelse (auth()->user()->unreadNotifications as $notification)
            <div class="px-4 py-3 hover:bg-gray-100 border-b">
                <div class="text-sm font-semibold text-gray-800">{{ $notification->data['title'] }}</div>
                <div class="text-sm text-gray-600">{{ $notification->data['message'] }}</div>
                @if (isset($notification->data['task_id']))
                    <a href="{{ route('notifications.view-task', [
                        'task_id' => $notification->data['task_id'],
                        'notification_id' => $notification->id
                    ]) }}" class="text-blue-500 text-sm hover:underline">
                        View Task
                    </a>
                @endif
            </div>
        @empty
            <div class="px-4 py-3 text-gray-500 text-sm text-center">
                No new notifications
            </div>
        @endforelse
    </div>
</div>

<script>
    const toggleBtn = document.getElementById('notificationToggle');
    const dropdown = document.getElementById('notificationDropdown');

    toggleBtn.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });

    function markAllRead() {
        fetch("{{ route('notifications.markAllRead') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(() => {
            window.location.reload();
        });
    }
</script>
@endauth


    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Page Content -->
    <main class="mt-5">
        @yield('content')
    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (MESTI sebelum bootstrap-select) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Select JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.js?v=3.2.0"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.selectpicker').selectpicker();
        });
    </script>

</body>
</html>
