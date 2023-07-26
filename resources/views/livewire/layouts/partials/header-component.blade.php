<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>
            <div class="search-bar flex-grow-1 d-none">
                <div class="position-relative search-bar-box">
                    <input type="text" class="form-control search-control" placeholder="Type to search..."> <span
                        class="position-absolute top-50 search-show translate-middle-y"><i
                            class='bx bx-search'></i></span>
                    <span class="position-absolute top-50 search-close translate-middle-y"><i
                            class='bx bx-x'></i></span>
                </div>
            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    {{-- <li class="nav-item mobile-search-icon">
                        <a class="nav-link" href="#"> <i class='bx bx-search'></i>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <div class="btn-group">
                            <a  href="#" class="nav-link active dropdown-toggle" aria-current="page"
                                data-bs-toggle="dropdown"><i class='bx bx-world me-1 fs-5'>{{ Config::get('languages')[App::getLocale()] }}</i></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                <a class="dropdown-item" href="{{ route('lang', 'en') }}">English</a>
                                <a class="dropdown-item" href="{{ route('lang', 'ar') }}">Arabic</a>
                                <a class="dropdown-item" href="{{ route('lang', 'fr') }}">French</a>
                                <a class="dropdown-item" href="{{ route('lang', 'es') }}">Spanish</a>
                                <a class="dropdown-item" href="{{ route('lang', 'sw') }}">Swahili</a>
                                <a class="dropdown-item" href="{{ route('lang', 'pt') }}">Portuguese</a>
                            </div>
                        </div>
                    </li>
                    {{-- Header Notification list Goes here--}}
                </ul>
            </div>
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/user.png') }}"
                        class="user-img" alt="User-avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('user.account') }}"><i
                                class="bx bx-user"></i><span>{{ __('public.profile') }}</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('home') }}"><i
                        class="bx bx-left-arrow-alt"></i><span>{{ __('Check-out') }}</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item"
                                onclick="event.preventDefault(); this.closest('form').submit();"><i
                                    class='bx bx-log-out-circle'></i>{{ __('public.logout') }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
