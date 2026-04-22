<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH-ATTENDANCE-MANAGEMENT</title>
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    <link rel="stylesheet" href="{{asset('css/reset.css')}}">
    @yield('css')
</head>
<body>
    <div class="app">
        <header class="header">
            <h1>
                <img src="{{asset('images/COACHTECHヘッダーロゴ.png')}}" alt="">
            </h1>
            @yield('link')
        </header>
        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>