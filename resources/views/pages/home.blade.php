@extends('layouts.framework')

@section('main')
      <main class="row">
        <div class="col-md-8">
          <div class="media well" ng-repeat="news in home.newsList">
            <a href="/news/@{{news.id}}" class="pull-left">
              <div class="fixed-size-image" style="background-image: url('//@{{news.banner_source}}')">
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

        </aside>
      </main>
@endsection