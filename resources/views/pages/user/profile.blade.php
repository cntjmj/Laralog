@extends('layouts.framework')

@section('main')
@include('layouts.message')
      <main class="row">
        <div class="col-md-12">
          <form role="form" method="post" action="{!!url('/user/profile/'.$user->id)!!}" name="profileForm" id="profileForm" enctype="multipart/form-data">
            <div class="form-group">
              <label for="name">
                User Name
              </label>
              <input type="text" required class="form-control" id="name" name="name" ng-model="profile.name" ng-disabled="!profile.editing">
            </div>
            <div class="form-group">
              <label for="avatar">
                User Icon
              </label>
              <div class="fixed-size-image-small" style="background-image: url('/@{{profile.avatar==''?'avatar/avatar.png':profile.avatar}}')">
              </div>
              <input type="file" id="uploadAvatar" name="uploadAvatar" ng-show="profile.editing">
              <p class="help-block" ng-show="profile.editing">
                only jpg or png image accepted
              </p>
            </div>
            {!!csrf_field()!!}
            {!!method_field('PUT')!!}
            <!--div class="checkbox">
              <label>
                <input type="checkbox"> Check me out
              </label>
            </div--> 
            <button type="submit" class="btn btn-default" ng-show="profile.editing" ng-disabled="profile.submitting">
              Submit
            </button>
            <a class="btn btn-default" id="cancelEditing" href="javascript:;" ng-show="profile.editing" ng-click="profile.cancelEditing()" ng-disabled="profile.submitting">
              Cancel
            </a>
          </form>
          <button class="btn btn-default" ng-hide="profile.editing" ng-click="profile.beginEditing()">
            Edit Profile
          </button>
        </div>
      </main>
      <script>
          var user = {!!$user->toJson()!!};
          @if (session('scopeMessage'))
          var scopeMessage = {!!json_encode(session('scopeMessage'))!!};
          @endif
      </script>
@endsection