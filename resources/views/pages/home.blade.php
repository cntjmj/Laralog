@extends('layouts.framework')

@section('main')
      <main class="row" infinite-scroll='home.loadmore()' infinite-scroll-disabled='!home.ready2scroll'>
        <div class="col-md-8">
          <div class="media well" ng-repeat="news in home.newsList">
            <a href="/news/@{{news.id}}" class="pull-left">
              <div class="fixed-size-image" style="background-image: url('@{{news.banner_source}}')">
              </div>
            </a>
            <div class="media-body">
              <h4 class="media-heading" ng-bind-html="news.title"></h4>
              <br/><p ng-bind-html="news.content"></p>
              <h4><br/>@{{news.question}}</h4>
            </div>
          </div>
        </div>
        <aside class="col-md-4">
        @if (isset($hotNews) && count($hotNews) > 0)
          <div class="row">
            <h3>Hot News</h3>
          </div>
          <div class="carousel slide" id="carousel-18432">
            <ol class="carousel-indicators">
            @for ($i=0;$i<count($hotNews);$i++)
              <li class="{{$i==0?"active":""}}" data-slide-to="0" data-target="#carousel-18432"></li>
            @endfor
            </ol>
            <div class="carousel-inner">
            @for ($i=0;$i<count($hotNews);$i++)
              <div class="{{$i==0?"item active":"item"}}">
                <a href="/news/{{$hotNews[$i]['id']}}">
                  <img alt="Carousel Bootstrap First" src="{!!$hotNews[$i]['banner_source']!!}">
                </a>
                <!--div class="fixed_size_image" style="background-image: url('{!!$hotNews[$i]['banner_source']!!}')"-->
                <div class="carousel-caption">
                  <h4>{{$hotNews[$i]['title']}}</h4>
                  <p>{{$hotNews[$i]['question']}}</p>
                </div>
              </div>
            @endfor
            </div>
            <a class="left carousel-control" href="#carousel-18432" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-18432" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
          </div>
        @endif
        @if (isset($trendingNews) && count($trendingNews) > 0)
          <div class="row">
            <h3>Trending News</h3>
          </div>
          @foreach ($trendingNews as $trend)
          <div class="row">
            <div class="thumbnail">
              <a href="/news/{{$trend['id']}}">
                <img alt="Bootstrap Thumbnail First" src="{!!$trend['banner_source']!!}">
                <div class="caption">
                  <h3>{{$trend['title']}}</h3>
                  <p>{{$trend['content']}}</p>
                </div>
              </a>
            </div>
          </div>
          @endforeach
        @endif
        </aside>
      </main>
@endsection