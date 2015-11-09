@extends('master')

@section('content')
<div class="container">
    <h2>Ajustement des métadonnées :</h2>
    <div class="col-mod-12">
        <form class="form-horizontal" action="{{url('/image/'.$image['slug'])}}" method="post">
            <input type="hidden" name="_method" value="PUT" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="bloc">
                <h3>Données obligatoires</h3>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Nom de l'image</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{$data["XMP"]['Title'] or "" }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="auteur" class="col-sm-2 control-label">Auteur</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="auteur" value="{{$data["XMP"]['Creator'] or "" }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="source" class="col-sm-2 control-label">Source</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="source" value="{{$data["XMP"]['Source'] or "" }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ville" class="col-sm-2 control-label">Ville</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ville" value="{{$data["XMP"]['City'] or "" }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="pays" class="col-sm-2 control-label">Pays</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pays" value="{{$data["XMP"]['Country'] or "" }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="license" class="col-sm-2 control-label">License</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="license" value="{{$data["XMP"]['UsageTerms'] or "" }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="desc" value="{{$data["XMP"]['Description'] or "" }}">
                    </div>
                </div>
            </div>
            <div class="bloc">
                <h3>Données déjà présentes</h3>
                @foreach($data as $key => $val)
                    <fieldset>
                        <legend>{{ $key }}</legend>
                        @foreach($val as $k => $v)
                            @if(!is_array($v))
                            <div class="form-group">
                                <label for="{{ $key.'_'.$k }}" class="col-sm-2 control-label">{{ $k }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="{{ $key.'_'.$k }}" placeholder="{{$v}}">
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <label for="{{ $key.'_'.$k }}" class="col-sm-2 control-label">{{ $k }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="{{ $key.'_'.$k }}" placeholder="{{implode(" ", $v)}}">
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </fieldset>
                @endforeach
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Terminer l'enregistrement</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
