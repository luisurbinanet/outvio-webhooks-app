@extends('layouts.app')

@section('content')
    <h1>{{ ucfirst($type) }} Logs</h1>

    @if (!empty($logData))
        @foreach ($logData as $log)
            @if ($log)
                <pre>{{ json_encode($log, JSON_PRETTY_PRINT) }}</pre>
                <hr>
            @endif
        @endforeach
    @else
        <p>No hay datos disponibles</p>
    @endif
@endsection
