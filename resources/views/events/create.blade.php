@extends('layouts.main')

@section('title', 'Criar novo evento')

@section('contet')
    <div class="col-md-6 offset-md-3 mt-4 mb-4" id="event-create-container">
        <h1>Crie o seu evento</h1>
        <form action="/events/create" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">Imagem do Evento:</label>
                <div class="upload-wrapper">
                    <input style="display: none" type="file" id="image" name="image">
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('image').click();">Enviar arquivo</button>
                    <img id="image-preview" src="https://media2.giphy.com/media/3zhxq2ttgN6rEw8SDx/200w.gif" alt="">
                </div>
            </div>
            <div class="form-group">
                <label for="title">Evento:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nome do Evento">
            </div>
            <div class="form-group">
                <label for="date">Data do evento:</label>
                <input type="date" class="form-control" id="date" name="date">
            </div>
            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Local do Evento">
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" class="form-control"
                    placeholder="O que vai acontecer no evento?"></textarea>
            </div>
            <div class="form-group">
                <label for="private">O Evento é privado?</label>
                <select name="private" class="form-control" id="private">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Adicione itens de infraestrutura</label>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cadeiras">Cadeiras
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Palco">Palco
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cerveja grátis">Cerveja grátis
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open food">Open food
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Brindes">Brindes
                </div>
            </div>
            <button class="btn btn-primary">Criar evento</button>
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
