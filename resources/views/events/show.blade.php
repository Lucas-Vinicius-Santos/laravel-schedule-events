@extends('layouts.main')

@section('title', $event->title)

@section('contet')
    <div class="col-md-10 offset-md-1 mt-4 mb-4">
        <div class="row">
            <div class="col-md-6" id="image-container">
                <img class="img-fluid"
                    src=" {{ $event->image ? '/img/events/' . $event->image : '/img/event_placeholder.jpg' }}"
                    alt="{{ $event->title }}">
            </div>
            <div class="col-md-6" id="info-container">
                <h1>{{ $event->title }}</h1>
                <p class="event-city">
                    <ion-icon name="location-outline"></ion-icon>
                    {{ $event->city }}
                </p>
                <p class="events-participants">
                    <ion-icon name="people-outline"></ion-icon>
                    @if (count($event->users) < 1)
                        Seja o primeiro a confirmar presença!
                    @elseif (count($event->users) == 1)
                        {{count($event->users)}} Participante
                    @else
                        {{count($event->users)}} Participantes
                    @endif
                </>

  

                <p class="event-owner">
                    <ion-icon name="star-outline"></ion-icon>
                    {{ $eventOwner['name'] }}
                </p>
                @if (!$hasUserParticipant)
                    <form action="/events/join/{{$event->id}}" method="post">
                        @csrf
                        <a 
                            class="btn btn-primary" 
                            id="event-submit" 
                            href="/events/join/{{$event->id}}"
                            onclick="event.preventDefault(); this.closest('form').submit()"
                        >Confirmar presença</a>
                    </form>
                @else
                    <form action="/events/leave/{{$event->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger delete-btn" type="submit">
                            <ion-icon name="trash-outline"></ion-icon>
                            Sair do evento
                        </button>
                    </form>
                @endif

                <h3>O evento conta com:</h3>
                    <ul id="items-list">
                    @foreach($event->items as $item)
                        <li><ion-icon name="play-outline"></ion-icon> <span>{{ $item }}</span></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12" id="description-container">
                <h3>Sobre o evento:</h3>
                <p class="event-description">{{ $event->description }}</p>
            </div>
        </div>
    </div>
@endsection
