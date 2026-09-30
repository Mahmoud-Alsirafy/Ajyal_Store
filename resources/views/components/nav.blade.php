          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                  @foreach ($items as $item)
                  <li class="nav-item">
                      <a href="{{route($item['route'])}}" class="nav-link {{$item['route']== $active ? 'active': '' }}">
                        <i class="{{$item['icon']}}"></i>
                        <p> {{ __($item['title']) }} </p>
                      </a>
                    </li>
                  @endforeach
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
