@extends('layouts.master')

@section('content')
<br>
<div class="container">
    <h2 class="text-center">Détails de l'Entreprise</h2>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $entreprise->entreprise }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Ville / Quartier :</strong> {{ $entreprise->ville }}, {{ $entreprise->quatier }}</p>
                            <p><strong>Téléphone :</strong> {{ $entreprise->telephone }}</p>
                            <p><strong>Email :</strong> {{ $entreprise->user->email }}</p>
                            <p><strong>Représentant :</strong> {{ $entreprise->representant }}</p>

                        </div>
                        <div class="col-md-6">
                            <p><strong>Description :</strong></p>
                            <p>{{ $entreprise->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="{{ route('entreprise.liste') }}" class="btn btn-primary">Retour à la liste des entreprises</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
