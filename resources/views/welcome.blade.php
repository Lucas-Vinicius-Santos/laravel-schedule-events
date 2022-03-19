@extends('layouts.main')

@section('title', 'Dashboard')

@section('contet')

  <div id="search-container" class="col-md-12">
    
      <h1>Busque um evento</h1>

    <form action="/" method="GET">
      <input  class="form-control" id="search" value="{{$search}}" name="search" placeholder="search">
    </form>
  </div>

  <div class="col-md-12" id="events-container">
    @if ($search)
      <h2>Eventos relacionados a: {{ $search }}</h2>
    @else
      <h2>Próximos eventos</h2>
    @endif
    <p class="subtitle">Veja os eventos dos próximos dias</p>
    <div id="cards-container">
      @foreach ($events as $event)
        <div class="card">
          <img 
            src=" {{ $event->image ? '/img/events/'.$event->image : '/img/event_placeholder.jpg'  }}"
            alt="{{ $event->title }}"
          >
          <div class="card-body">
            <p class="card-date">{{ date('d/m/Y', strtotime($event->date)) }}</p>
            <h5 class="card-title">{{ $event->title }}</h5>
            <p class="card-participants">X Participantes</p>
            <a href="events/{{$event->id}}" class="btn btn-primary">Saber mais</a>
          </div>
        </div>
      @endforeach
    </div>
    @if(count($events) == 0) 
      @if ($search)
        <p>
          Nenhum evento relacionado a '{{ $search }}' encontrado.
          <a href="/">Ver todos os eventos</a>
        </p>
      @else
        <p>Não há eventos disponíveis no momento</p>
      @endif
    @endif
  </div>

@endsection
