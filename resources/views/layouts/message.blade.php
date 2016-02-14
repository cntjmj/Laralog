      <section>
        <div class="alert alert-success alert-dismissable" ng-show="message.success==true">
          <button type="button" class="close" ng-click="message.clear()" ddata-dismiss="alert" aaria-hidden="true">
            ×
          </button>
          <h4>
            @{{message.title.length>0?message.title:'Success'}}
          </h4> <strong ng-show="message.strong!=''">@{{message.strong}}:</strong> <span ng-bind-html="message.body"></span> <a ng-show="message.linkurl!=''" href="@{{message.linkurl}}" class="alert-link">@{{message.linktext}}</a>
        </div>
        <div class="alert alert-dismissable alert-danger" ng-show="message.error==true">
          <button type="button" class="close" ng-click="message.clear()" ddata-dismiss="alert" aaria-hidden="true">
            ×
          </button>
          <h4>
            @{{message.title.length>0?message.title:'Error'}}
          </h4> <strong ng-show="message.strong!=''">@{{message.strong}}:</strong> <span ng-bind-html="message.body"></span> <a ng-show="message.linkurl!=''" href="@{{message.linkurl}}" class="alert-link">@{{message.linktext}}</a>
        </div>
      </section>