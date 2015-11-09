@extends('master')

@section('content')
<div class="grid-items" >
    @foreach($tabImages as $image)
    <figure itemscope itemtype="https://schema.org/Photograph">
        <img itemprop="image" src="{{$image['src']}}" alt="{{$image['name']}}"/>
        <figcaption>
            <div class="head">
                <h2 itemprop="name">{{$image['name']}}</h2>
                <span itemprop="author">{{$image['auteur']}}</span>
            </div>
            <a href="{{url('/image/'.$image['slug'])}}">View more</a>
        </figcaption>
    </figure>
    @endforeach
</div>
@endsection
