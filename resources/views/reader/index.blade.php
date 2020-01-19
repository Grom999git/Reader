@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Самые популярные слова</div>

                <div class="card-body">
                    <div class="card-columns">
                        @foreach($array as $key => $value)
                            <div class="card bg-primary">
                                <div class="card-body text-center">
                                    <p class="card-text">{{$key}} {{$value}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">RSS лента</div>
                    
                <div class="card-body">    
                    <div class="card-group">
                        <div class="card bg-primary">
                            <div class="card-body text-center">
                                <a href="{{ $rss['link'] }}"><img src="{{ $rss['logo'] }}"></a>
                        </div>
                        </div>
                        <div class="card bg-primary">
                            <div class="card-body text-center">
                                <p class="card-text" style="font-size: x-large;">
                                    {{ $rss['title'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="container">
                    @foreach($news_array as $item)
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <a href="{{ $item['link'] }}" class="text-white" target="blank">{{$item['title']}}</a>
                                    </div>
                                    <div class="card-body">
                                        {!! $item['summary'] !!}
                                    </div>
                                </div>
                                <br>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection