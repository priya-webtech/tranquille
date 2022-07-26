<x-guest-layout>
    <div class="auth-content">
        <div class="text-center"><img src="{{ url('/').'/'.asset('assets/images/login.svg') }}" alt="" class="img-fluid mb-4"></div>
        <div class="card">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <h3 class="mb-3 text-center">Only Admin can Access</h3>
                        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" class="btn d-flex justify-content-center companion_bg" 
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>