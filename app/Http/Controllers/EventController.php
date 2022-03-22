<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class EventController extends Controller
{
    public function index()
    {

        $search = request('search');

        if (!$search) {
            $events = Event::all();
        } else {
            $events = Event::where(
                'title', 'like', '%' . $search . '%'
            )->get();
        }

        return view('welcome', [
            'events' => $events,
            'search' => $search,
        ]);
    }

    public function show($id)
    {
        $user = auth()->user();

        $event = Event::findOrFail($id);

        $hasUserParticipant = false;

        if ($user) {
            $userEvents = $user->eventsAsParticipant;

            foreach ($userEvents as $userEvent) {
                if ($userEvent['id'] == $id) {
                    $hasUserParticipant = true;
                }
            }

            if ($event->user_id === $user->id) {
                $eventOwner = $user;
            } else {
                $eventOwner = User::where('id', '=', $event->user_id)->first();
            }
        } else {
            $eventOwner = User::where('id', '=', $event->user_id)->first();
        }

        return view('events.show', [
            'event' => $event,
            'eventOwner' => $eventOwner,
            'hasUserParticipant' => $hasUserParticipant,
        ]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $newEvent = new Event;

        $user = auth()->user();

        $newEvent->user_id = $user->id;
        $newEvent->title = $request->title;
        $newEvent->date = $request->date;
        $newEvent->city = $request->city;
        $newEvent->description = $request->description;
        $newEvent->private = $request->private;
        $newEvent->items = $request->items;

        //Upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extensionImage = $requestImage->extension();
            $nameImage = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extensionImage;

            $requestImage->move(public_path('img/events'), $nameImage);

            $newEvent->image = $nameImage;
        }

        $newEvent->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function destroy($id)
    {
        $events = auth()->user()->events;
        foreach ($events as $event) {
            if ($event->id == $id) {
                Event::findOrFail($id)->delete();
                FacadesFile::delete(public_path('img\\events\\') . $event->image);
                return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
            }
        }

        return redirect('/dashboard')->with('msg', 'Sem permissão para exclusão desse evento!');
    }

    public function edit($id)
    {
        $user = auth()->user();

        $event = Event::findOrFail($id);

        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $userEvents = auth()->user()->events;

        foreach ($userEvents as $userEvent) {
            if ($userEvent->id == $request->id) {

                //Upload
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    //FLUXO: Deletar imagem antiga; upload nova imagem; armazenar nova imagem; update imagem nome.
                    FacadesFile::delete(public_path('img\\events\\') . $data['image']->getClientOriginalName());

                    $requestImage = $request->image;
                    $extensionImage = $requestImage->extension();
                    $nameImage = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extensionImage;

                    $requestImage->move(public_path('img/events'), $nameImage);

                    $data['image'] = $nameImage;
                }

                Event::findOrFail($request->id)->update($data);
                return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
            }
        }
        return redirect('/dashboard')->with('msg', 'Sem permissão para editar esse evento!');
    }

    public function dashboard()
    {

        $eventOwner = auth()->user();
        $events = $eventOwner->events;
        $eventsAsParticipants = $eventOwner->eventsAsParticipant;

        return view('events.dashboard', [
            'events' => $events,
            'eventsAsParticipants' => $eventsAsParticipants,
        ]);
    }

    public function joinEvent($id)
    {
        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        return back()->with('msg', 'Presença confirmada!');

    }

    public function leaveEvent($id)
    {
        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        return back()->with('msg', 'Presença cancelada!');
    }

}
