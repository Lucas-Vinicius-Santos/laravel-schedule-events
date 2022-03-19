@extends('layouts.main')

@section('title', 'Dashboard')

@section('contet')

    <div class="col-md-10 offset-md-1 dashboard-title-container mt-4 mb-4">
        <h1>Meus Eventos</h1>
    </div>
    <div class="col-md-10 offset-md-1 dashboard-events-container">
        @if (count($events) > 0)
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Evento</th>
                    <th>Participantes</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($events as $event )
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>
                                <a href="/events/{{$event->id}}">{{$event->title}}</a>
                            </td>
                            <td>{{count($event->users)}}</td>
                            <td>
                                <a href="/events/edit/{{$event->id}}" class="btn btn-info edit-btn">
                                    <ion-icon name="create-outline">Editar</ion-icon>
                                </a>
                                <form action="/events/{{$event->id}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn">
                                        <ion-icon name="trash-outline">Deletar</ion-icon>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>
                Você ainda não possui eventos, 
                <a href="/events/create">criar evento</a>
            </p>
        @endif

    </div>
    <div class="col-md-10 offset-md-1 dashboard-title-container mt-4 mb-4">
        <h1>Eventos que estou participando</h1>
    </div>

    <div class="col-md-10 offset-md-1 dashboard-events-container">
        @if (count($eventsAsParticipants) > 0)
        <table class="table">
            <thead>
                <th>#</th>
                <th>Evento</th>
                <th>Participantes</th>
                <th>Ações</th>
            </thead>
            <tbody>
                @foreach ($eventsAsParticipants as $event )
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>
                            <a href="/events/{{$event->id}}">{{$event->title}}</a>
                        </td>
                        <td>{{count($event->users)}}</td>
                        <td>
                            <form action="/events/leave/{{$event->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger delete-btn" type="submit" href="#" >
                                    <ion-icon name="trash-outline"></ion-icon>Sair do evento
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>
                Você ainda não esta participando de nenhum eventos, 
                <a href="/">ver todos os eventos</a>
            </p>
        @endif
    </div>

@endsection