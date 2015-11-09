@extends('master')

@section('content')
<h1>{{ $image['name'] }}</h1>
<hr>
<div class="row">
    @if ( Session::has('message') )
        <div class="alert alert-info">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <figure>
                <img src="{{$image['src']}}" alt="{{$image['name']}}"/>
                <figcaption>
                    <h2>{{$image['name']}}</h2>
                </figcaption>
            </figure>
        </div>
        <div class="col-md-4">
            <p><strong>Auteur :</strong>
                {{$data["XMP"]['Creator']}}
            </p>
            <p><strong>Description :</strong>
                {{$data["XMP"]['Description']}}
            </p>
            <a href="{{ $image['src'] }}" class="btn btn-primary" download>Télécharger l'image</a>
            <a href="{{ explode(".", $image['src'])[0].".xmp" }}" class="btn btn-default" download>Télécharger le fichier XMP Sidecar</a>
        </div>
    </div>
</div>
<hr>
<h2>Modification des métadonnées :</h2>
<div class="row">
    <div class="col-mod-12">
        <form class="form-horizontal" action="{{url('/image/'.$image['slug'])}}" method="post">
            <input type="hidden" name="_method" value="PUT" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @foreach($data as $key => $val)
                <fieldset>
                    <legend>{{ $key }}</legend>
                    @foreach($val as $k => $v)
                        @if(!is_array($v))
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">{{ $k }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="{{ $key.'_'.$k }}" placeholder="{{$v}}">
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">{{ $k }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="{{ $key.'_'.$k }}" placeholder="{{implode(" ", $v)}}">
                            </div>
                        </div>
                        @endif
                    @endforeach
                </fieldset>
            @endforeach
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
