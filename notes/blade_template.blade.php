<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Blade Template' }}</title>
</head>
<body>
    {{-- Displaying Variables --}}
    <h1>{{ $title }}</h1>
    <p>Name: {{ $user_data['name'] }}</p>
    <p>Age: {{ $user_data['age'] }}</p>

    {{-- Loops --}}
    {{-- For Loop --}}
    <h2>For Loop:</h2>
    @for ($i = 0; $i < 10; $i++)
        <p>{{ $i }}</p>
    @endfor

    {{-- Foreach Loop --}}
    <h2>Foreach Loop:</h2>
    @foreach ($user_data as $key => $value)
        <p>{{ $key }} => {{ $value }}</p>
    @endforeach

    {{-- Forelse Loop --}}
    <h2>Forelse Loop:</h2>
    @forelse ($user_data as $key => $value)
        <p>{{ $key }} => {{ $value }}</p>
    @empty
        <p>No data found</p>
    @endforelse

    {{-- PHP Code --}}
    @php
        $data = ['name' => 'John Doe', 'age' => 30];
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    @endphp

    {{-- Conditionals --}}
    <h2>Conditionals:</h2>
    {{-- If-Else --}}
    @if ($user_data['age'] > 30)
        <p>Age is greater than 30</p>
    @elseif ($user_data['age'] < 30)
        <p>Age is less than 30</p>
    @else
        <p>Age is 30</p>
    @endif

    {{-- Unless --}}
    @unless ($user_data['age'] > 30)
        <p>Age is less than or equal to 30</p>
    @else
        <p>Age is greater than 30</p>
    @endunless

    {{-- Switch --}}
    <h2>Switch Statement:</h2>
    @switch($user_data['age'])
        @case(30)
            <p>Age is 30</p>
            @break
        @case(40)
            <p>Age is 40</p>
            @break
        @case(50)
            <p>Age is 50</p>
            @break
        @default
            <p>Age is not 30, 40, or 50</p>
    @endswitch

    {{-- isset --}}
    @isset($user_data['name'])
        <p>Name is set</p>
    @endisset

    {{-- empty --}}
    @empty($user_data['name'])
        <p>Name is empty</p>
    @endempty

    {{-- Authentication --}}
    {{-- Authenticated User --}}
    @auth
        <p>User is authenticated</p>
    @endauth

    {{-- Guest User --}}
    @guest
        <p>User is not authenticated</p>
    @endguest

    {{-- CSRF Token --}}
    <h2>CSRF Token:</h2>
    <form method="POST" action="/submit">
        @csrf
        <input type="text" name="name" placeholder="Enter Name">
        <button type="submit">Submit</button>
    </form>

    {{-- Validation Errors --}}
    <h2>Validation Errors:</h2>
    @error('name')
        <p>Name is required</p>
    @enderror

    {{-- Component Example --}}
    <h2>Component:</h2>
    <x-alert type="success" :message="'This is a success message'" />

    {{-- Comments --}}
    {{-- This is a Blade comment and won't be rendered in HTML --}}

    {{$test = }}

</body>
</html>
