          <nav>
            <ul class="nav nav-tabs">
              <li {!! $category_id<0?"class=\"active\"":"" !!}>
                <a href={!!$category_id<0?"javascript:;":"/home"!!}>All</a>
              </li>
            @foreach ($categories as $category)
              <li {!! $category_id==$category->id?"class=\"active\"":"" !!}>
                <a href={!!$category_id==$category->id?"javascript:;":"/home/".$category->id!!}>{{ $category->name }}</a>
              </li>
            @endforeach
            </ul>
          </nav>