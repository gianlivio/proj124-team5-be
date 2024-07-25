@extends('layouts.admin')

@section('content')
  <h1>Lista di richieste di contatti</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
        <th scope="col">Data</th>
        <th scope="col">Status</th>
        <th scope="col">Azioni</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($leads as $lead)
        <tr>
          <th scope="row">{{ $lead->id }}</th>
          <td>{{ $lead->name }} {{ $lead->lastname }}</td>
          <td>{{ $lead->email }}</td>
          <td>{{ $lead->created_at }}</td>
          <td>
            <form action="{{ route('admin.leads.update', ['lead' => $lead->id]) }}" method="POST">
              @csrf
              @method('PATCH')
              <select name="status" aria-label="Seleziona lo status">
                <option @selected($lead->status === 'pending') value="pending">In attesa</option>
                <option @selected($lead->status === 'closed') value="closed">Risposto</option>
              </select>
              <button type="submit">Salva</button>
            </form>
          </td>
          <td>
            <a href="{{ route('admin.leads.show', ['lead' => $lead->id]) }}">Dettagli</a>

          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div>
    {{ $leads->links() }}
  </div>
@endsection
