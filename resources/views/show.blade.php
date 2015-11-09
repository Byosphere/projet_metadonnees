@extends('master')

@section('meta')
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ url('/') }}">
<meta name="twitter:creator" content="{{$data["XMP"]['Creator']}}">
<meta name="twitter:title" content="{{$data["XMP"]['Title']}}">
<meta name="twitter:description" content="{{$data["XMP"]['Description']}}">
<meta name="twitter:image" content="{{$image['src']}}">
@endsection

@section('content')
<div class="container" itemscope itemtype="https://schema.org/Photograph">
    <div class="panorama">
        <figure>
            <div class="img">
                <img itemprop="image" src="{{$image['src']}}" alt="{{$image['name']}}"/>
            </div>
            <figcaption>
                <h2>{{$image['name']}}</h2>
                <p>by {{$data["XMP"]['Creator']}}</p>
            </figcaption>
        </figure>
        <a href="{{ $image['src'] }}" class="btn btn-primary" download>Télécharger l'image</a>
        <a href="{{ asset(explode(".", $image['src'])[0].".xmp") }}" class="btn btn-default" download>Télécharger le fichier XMP Sidecar</a>
    </div>
    <hr>
    <div class="resume">
        <h3>Résumé des données importantes de l'image</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Info</th>
                    <th>Valeur</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Nom de l'image</td>
                    <td itemprop="name">{{$data["XMP"]['Title']}}</td>
                </tr>
                <tr>
                    <td>Auteur</td>
                    <td itemprop="author">{{$data["XMP"]['Creator']}}</td>
                </tr>
                <tr>
                    <td>Source</td>
                    <td itemprop="isBasedOnUrl"><a href="{{$data["XMP"]['Source'] or $data["IPTC"]['Source']}}">{{$data["XMP"]['Source'] or $data["IPTC"]['Source']}}</a></td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td itemprop="contentLocation">{{$data["XMP"]['Country']}}</td>
                </tr>
                <tr>
                    <td>License</td>
                    <td itemprop="license">{{$data["XMP"]['UsageTerms']}}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td itemprop="description">{{$data["XMP"]['Description']}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modifier">
        <h3>Modifier les métadonnées de l'image</h3>
        <div>
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
                                    <label for="{{ $key.'_'.$k }}" class="col-sm-2 control-label">{{ $k }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="{{ $key.'_'.$k }}" placeholder="{{$v}}">
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="{{ 'tab_'.$k }}" class="col-sm-2 control-label">{{ $k }} <small>(séparer avec un espace)</small></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="{{ 'tab_'.$k }}" placeholder="{{implode(" ", $v)}}">
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
    </div>
</div>
@endsection
