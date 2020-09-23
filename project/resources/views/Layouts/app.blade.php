<!DOCTYPE html>
<html lang="en">
<style type="text/css">
        html, body{
            height:100%;
        }
        body{
            display: flex;
            flex-direction: column;
        }
        .content{
            flex: 1 0 auto;
        }
        
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{config('app.name', 'Application')}} - @yield('title')</title>
</head>
<body>
    @include('inc.navbar')
    <h2 style="background-color:  #003807; color:white;">{{$title ?? ''}}</h2>
    <div class="content">
        @yield('content')
    </div>   
    @include('inc.footer')
</body>
</html>