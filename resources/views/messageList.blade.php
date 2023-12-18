<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    </head>
    <body>
        <div>messages</div>
        <a href="{{ route('welcome') }}">Login</a>
        <table>
            <tr>
                <th>id</th>
                <th>direction</th>
                <th>parsed_result</th>
                <th>source</th>
            </tr>
            @foreach ($messages as $message)
                <tr>
                    <td style="border-right: 1px solid black">{{ $message->id }}</td>
                    <td style="border-right: 1px solid black">{{ $message->direction }}</td>
                    <td style="border-right: 1px solid black">{{ $message->parsed_result }}</td>
                    <td style="border-right: 1px solid black">{{ $message->reconstructSource() }}</td>
                </tr>
            @endforeach
    </body>
</html>
