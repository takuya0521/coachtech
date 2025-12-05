<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FashionablyLate</title>

    @vite('resources/css/app.css')
</head>
<body class="bg-[#f8f5f2] min-h-screen">

    <header class="w-full border-b bg-white py-4">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-serif text-gray-700">FashionablyLate</h1>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="text-sm border px-4 py-1 rounded bg-white hover:bg-gray-50">
                        logout
                    </button>
                </form>
            @endauth

            @guest
                <div class="flex gap-3">
                    @if (request()->routeIs('login'))
                        <a href="{{ route('register') }}"
                           class="text-sm border px-3 py-1 rounded bg-white hover:bg-gray-50">
                            register
                        </a>
                    @elseif (request()->routeIs('register'))
                        <a href="{{ route('login') }}"
                           class="text-sm border px-3 py-1 rounded bg-white hover:bg-gray-50">
                            login
                        </a>
                    @endif
                </div>
            @endguest
        </div>
    </header>

    <main class="max-w-5xl mx-auto mt-10">
        @yield('content')
    </main>

</body>
</html>
