@extends('layouts.main')

@section('title', 'Editando' . $event->title)

@section('contet')
    <div class="col-md-6 offset-md-3 mt-4 mb-4" id="event-create-container">
        <h1>Editando: {{ $event->title }}</h1>
        <form action="/events/update/{{$event->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="image">Imagem do Evento:</label>
                <div class="upload-wrapper">
                  <input style="display: none" type="file" id="image" name="image">
                  <button type="button" class="btn btn-primary" onclick="document.getElementById('image').click();">Enviar arquivo</button>
                  <img id="image-preview" src="/img/events/{{$event->image}}" alt="{{$event->title}}">
              </div>
            </div>
            <div class="form-group">
                <label for="title">Evento:</label>
                <input class="form-control" id="title" value="{{$event->title}}" name="title" placeholder="Nome do Evento">
            </div>
            <div class="form-group">
                <label for="date">Data do evento:</label>
                <input class="form-control" id="date" value="{{$event->date->format('Y-m-d')}}" type="date"  name="date">
            </div>
            <div class="form-group">
                <label for="city">Cidade:</label>
                <input  class="form-control" id="city" value="{{$event->city}}"  name="city" placeholder="Local do Evento">
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea id="description" class="form-control" name="description" 
                    placeholder="O que vai acontecer no evento?">{{$event->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="private">O Evento é privado?</label>
                <select  class="form-control" id="private"  name="private">
                    <option value="0">Não</option>
                    <option value="1" {{$event->private == 1 ? "selected='selected'" : ""}}>Sim</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Adicione itens de infraestrutura</label>
                <div class="form-group">
                    <input 
                        type="checkbox" 
                        name="items[]" 
                        value="Cadeiras" 
                        @php
                            if(in_array("Cadeiras", $event->items)) {
                                echo "checked";
                            } 
                        @endphp 
                    >Cadeiras
                </div>
                <div class="form-group">
                    <input 
                        type="checkbox" 
                        name="items[]" 
                        value="Palco"
                        @php
                            if(in_array("Palco", $event->items)) {
                                echo "checked";
                            } 
                        @endphp 
                    >Palco
                </div>
                <div class="form-group">
                    <input 
                        type="checkbox" 
                        name="items[]" 
                        value="Cerveja grátis"
                        @php
                            if(in_array("Cerveja grátis", $event->items)) {
                                echo "checked";
                            } 
                        @endphp 
                    >Cerveja grátis
                </div>
                <div class="form-group">
                    <input 
                        type="checkbox" 
                        name="items[]" 
                        value="Open food"
                        @php
                            if(in_array("Open food", $event->items)) {
                                echo "checked";
                            } 
                        @endphp 
                    >Open food
                </div>
                <div class="form-group">
                    <input 
                        type="checkbox" 
                        name="items[]" 
                        value="Brindes"
                        @php
                            if(in_array("Brindes", $event->items)) {
                                echo "checked";
                            } 
                        @endphp 
                    >Brindes
                </div>
            </div>
            <button class="btn btn-primary">Editar evento</button>
        </form>
    </div>

    <script type="text/javascript">
      
      var img = document.getElementById('image')
      var imgPreview = document.getElementById('image-preview')

      img.addEventListener('change', (event) => {
            if (!event.target.files) return;
            var file = event.target.files[0];
            
            let reader = new FileReader();
            reader.readAsDataURL(file); 

            reader.onload = (e) => { 
                imgPreview.setAttribute('src', e.target.result);
            }
      })
  </script>
@endsection
