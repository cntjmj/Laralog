@extends('layouts.framework')

@section('main')
      <main class="row">
        <div class="col-md-12">
          <div class="page-header">
            <h1>Topic: <small>{{$news->title}}</small></h1>
          </div>
          <!--img alt="Bootstrap Image Preview" src="{!!$news->banner_source!!}" class="img-thumbnail"-->
          <a href="{!!$news->source!!}" target="_blank">
            <div class="fixed-size-image-large img-thumbnail" style="background-image: url('{!!$news->banner_source!!}')"></div>
          </a>
          <p>{!!$news->content!!}</p>
          <div class="jumbotron well">
            <h2>Question:</h2>
            <p>{!!$news->question!!}</p>
            <p>
              <span><a ng-click="news.comment.loadForm('agree')" class="btn btn-primary btn-large" id="modal-701239-primary" href="#modal-container-701239" data-toggle="modal">Say Yes</a></span>
              <span><a ng-click="news.comment.loadForm('disagree')" class="btn btn-default btn-large" id="modal-701239-default" href="#modal-container-701239" data-toggle="modal">Say No!</a></span>
            </p>
          </div>
          <div class="modal fade @{{news.comment.type=='agree'?'alert-success':'alert-warning'}}" id="modal-container-701239" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
              @if (Auth::check())
                <form role="form" ng-submit="news.comment.submitForm()" name="commentForm" id="commentForm">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Why would you @{{news.comment.type}}?</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="commentContent">Comment: (@{{news.comment.content.length}}/1000)</label>
                      <textarea ng-model="news.comment.content" required class="form-control" name="commentContent" id="commentContent" rows=10></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                      Close
                    </button> 
                    <button type="submit" class="btn btn-primary">
                      Save changes
                    </button>
                  </div>
                </form>
              @else
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Authentication Required</h4>
                  </div>
                  <div class="modal-body">
                    <h3>Only logon users can participate in debate.</h3>
                    <br><br>
                    <h3>Please click login button to go on.</h3>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                      Close
                    </button> 
                    <a href="{!!url('/login')!!}" class="btn btn-primary">
                      Login
                    </a>
                  </div>
              @endif
              </div>
            </div>
          </div>
          <h3>@{{ news.yesPercent|number:0 }}% People Say Yes</h3>
          <div class="progress active">
            <div class="progress-bar progress-success" style="width:@{{ news.yesPercent }}%"></div>
          </div>
          <div ng-repeat="comment in news.comments" class="alert alert-dismissable @{{comment.type=='agree'?'alert-success':'alert-warning'}}">
            <h4>
                @{{comment.user.name}} @{{comment.type=='agree'?'agree:':'disagree:'}}
            </h4> <strong>@{{str2date(comment.created_at)|date:'dd-MM-yy hh:mm:ss'}}</strong> @{{comment.content}}
            <a ng-show="comment.user_id==news.currentUserID" ng-click="news.deleteComment(comment.id)" href="javascript:;" class="alert-link">delete</a>
          </div>
        </div>
      </main>
@endsection