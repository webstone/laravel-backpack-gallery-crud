@extends('layouts.default')


@section('content')
<div class="light-wrapper start">

    <div class="container inner">
        <div class="row topspace">
            <div class="col-sm-8 col-sm-offset-2">
                <article class="post">
                    <header class="entry-header">
                        <h1 class="entry-title">{{ $title }}</h1>
                    </header>
                </article>
            </div>
        </div>

@if(count($galleries) > 0)
<div class="row topspace">
    <div class="col-sm-8 col-sm-offset-2">

        @foreach ($galleries as $gallery)
        <article class="post">
            <header class="entry-header">
                <h1 class="entry-title"><a href="{{ url('/gallery/'.$gallery->slug) }}" rel="bookmark">{{ $gallery->title }}</a></h1>
            </header>
            <div class="entry-content">
                <p>{{ strip_tags(Str::limit($gallery->body, 300)) }}</p>
            </div>
        </article>
        @endforeach
    </div>
</div>
@endif
    </div>
</div>
@stop
