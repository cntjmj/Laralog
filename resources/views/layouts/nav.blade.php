          <nav>
            <ul class="nav nav-tabs">
            @foreach ($navEntries as $navEntry)
              <li class="{!!$navEntry->get('class')!!}">
                <a href="{!!$navEntry->get('url')!!}">{{$navEntry->get('text')}}</a>
              </li>
            @endforeach
            </ul>
          </nav>