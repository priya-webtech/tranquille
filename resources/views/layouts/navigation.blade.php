<nav x-data="{ open: false }">
    <header class="pc-header ">
        <div class="header-wrapper">
            <div class="ms-auto">
                <ul class="list-unstyled">

                    {{-- <li class="pc-h-item">
                        <a class="pc-head-link me-0" href="#" data-bs-toggle="modal" data-bs-target="#notification-modal">
                            <i class="fas fa-bell text-dark"></i>
                            <span class="bg-danger pc-h-badge dots"><span class="sr-only"></span></span>
                        </a>
                    </li> --}}
                     @auth
                     <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ url('/').'/'.asset(isset(Auth::user()->image) ? Auth::user()->image : 'assets/image/dummy.png' ) }}" alt="user-image" class="user-avtar">
                            <span>
                                <span class="user-name">{{ Auth::user()->firstname .' '. Auth::user()->lastname }}</span>
                                <span class="user-desc">{{ Auth::user()->type }}</span>
                            </span>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            <a href="{{ route('changePasswordGet') }}" class="dropdown-item">
                                <span>Change Password</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-button :href="route('logout')" class="dropdown-item v_l"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {!!  __('Log Out') !!}
                            </x-button>
                            </form>
                        </div>
                    </li>
                    @endauth
                </ul>
            </div>

        </div>
    </header>
</nav>
