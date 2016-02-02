      <header class="row">
        <div class="col-md-12">
          <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="javascript:;">LARALOG</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <form class="navbar-form navbar-left" role="search">
                {{ csrf_field() }}
                <div class="form-group">
                  <input type="text" class="form-control">
                </div> 
                <button type="submit" class="btn btn-default">
                  Search
                </button>
              </form>
              <ul class="nav navbar-nav navbar-right">
              @if (Auth::check())
                <li>
                  <a href="javascript:;">Hi {{Auth::User()->name}}</a>
                </li>
                <li>
                  <a href="javascript:;"><span class="badge pull-right">42</span></a>
                </li>
              @endif
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<strong class="caret"></strong></a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="javascript:;">About Us</a>
                    </li>
                    <li>
                      <a href="javascript:;">Contact</a>
                    </li>
                    <li class="divider">
                    </li>
                    @if (Auth::guest())
                    <li>
                      <a href="/login">Login</a>
                    </li>
                    <li>
                      <a href="/register">Register</a>
                    </li>
                    @else
                    <li>
                      <a href="/logout">Logout</a>
                    </li>
                    @endif
                  </ul>
                </li>
              </ul>
            </div>
          </nav>

          @if (isset($categories) && count($categories) > 0)
            @include('layouts.nav')
          @endif

        </div>
      </header>