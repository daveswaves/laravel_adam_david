<!-- resources/views/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Auction DB</title>

<link rel="stylesheet" href="/style.css">

</head>
<body>

<div class="container">
    <ul class="navbar fixed nav-full-width">
        <!-- The URL Helper users the Application URL value in the config/app.php file -->
        <li><a href="{{ url('') }}" class="{{ request()->is('/') || request()->is('sellers*') ? 'active' : '' }}">Sellers</a></li>
        <li><a href="{{ url('lots') }}" class="{{ request()->is('lots*') ? 'active' : '' }}">Lots</a></li>
        <li><a href="{{ url('new') }}" class="{{ request()->is('new') ? 'active' : '' }}">New Auction</a></li>
        <li><a href="{{ url('commission') }}" class="{{ request()->is('commission') ? 'active' : '' }}">Commission</a></li>
        <li><a href="{{ url('print') }}" class="{{ request()->is('print') ? 'active' : '' }}">Print</a></li>
        <li><a href="{{ url('search') }}" class="{{ request()->is('search') ? 'active' : '' }}">Search</a></li>
        
        <!-- Dropdown (YEARS) -->
        {!! $dd_years !!}
        
        <!-- Dropdown (DATES) -->
        {!! $dd_year_dates !!}
    </ul>
    <div class="h-60px"></div>
    <!-- Can also use blade components as an alternative -->
    @yield('content')
</div>

</body>
</html>