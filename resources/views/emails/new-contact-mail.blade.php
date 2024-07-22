@extends('layouts.app')

@section('content')
    <h1>Ciao Admin</h1>
    <p>Hai ricevuto una nuova richiesta di contatto</p>
    <dl>
        
        <dt>Da</dt>
        <dd>{{ $lead->name }} {{ $lead->lastname }}</dd>

        <dt>Email</dt>
        <dd>{{ $lead->mail }}</dd>

        <dt>Da</dt>
        <dd>{{ $lead->message }}</dd>
    </dl>
@endsection