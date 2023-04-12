<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md sticky-top bg-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('groups.index')?'active':''}}" aria-current="page" href="{{route('groups.index')}}">Группы</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('products.index')?'active':''}}" aria-current="page" href="{{route('products.index')}}">Товары</a>
                    </li>
                </ul>

                <!-- Authentication -->
                <form class="d-flex" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="btn btn-secondary" href="{{route('logout')}}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg></a>
                </form>
            </div>
        </div>
    </nav>
</header>

{{--href="{{route('catalog.groups')}}"--}}
{{--{{request()->routeIs('catalog.groups')?'active':''}}--}}
{{--Группы--}}

{{--href="{{route('catalog.products')}}"--}}
{{--{{request()->routeIs('catalog.products')?'active':''}}--}}
{{--Товары--}}

