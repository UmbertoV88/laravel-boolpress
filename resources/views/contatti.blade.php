@extends('layouts.public')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Contattaci</h1>
                <form  action="{{route('contatti.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label for="subject">Oggetto </label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Oggetto">
                    </div>

                    <div class="form-group">
                        <label for="content">Messaggio </label>
                        <textarea class="form-control" id="message" placeholder="Inizia a scrivere..." name="message" rows="8" ></textarea>
                    </div>


                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="invia messaggio">
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
