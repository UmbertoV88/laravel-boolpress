@extends('layouts.public')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Errore 404: pagina non trovata</h1>
                <p>La pagina che stai cercando non esiste</p>
                <a class="btn btn-primary" href="{{route('public.home')}}"> Torna in HomePage</a>
            </div>
        </div>
    </div>
@endsection
