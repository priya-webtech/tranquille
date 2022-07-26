<x-guest-layout>
    <div class="auth-content">
        <div class="text-center"><img src="{{ url('/').'/'.asset('assets/image/logoFull.svg') }}" alt="" class="img-fluid mb-4"></div>
        <div class="card">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <h3 class="mb-3 text-center">Login</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <p class="text-left">  <label>Email</label></p>
                            <div class="input-group mb-3">
                                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
                            </div>
                            <p class="text-left">  <label>Password</label></p>
                            <div class="input-group mb-4">
                                <x-input id="password" class="form-control"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                            </div>
                            <div class="form-group  mt-2 d-flex justify-content-between">
                                <div class="form-check ">
                                    <input id="remember_me" type="checkbox" class="form-check-input input-warning" name="remember">
                                    <label class="custom-control-label" for="basic_checkbox_1">Remember my preference</label>
                                </div>
                                <!-- <div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="f-w-400 color_t">
                                            {{ __('Forgot password?') }}
                                        </a>
                                    @endif
                                </div> -->
                            </div>
                            <button class="w-100 btn btn-block bg_button mb-3">Signin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
