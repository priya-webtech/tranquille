<style>
    a{
        text-decoration: none;
        color: black;
    }

    a:visited{
        color: black;
    }

    .box::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
        border-radius: 5px
    }

    .box::-webkit-scrollbar
    {
        width: 10px;
        background-color: #F5F5F5;
        border-radius: 5px
    }

    .box::-webkit-scrollbar-thumb
    {
        background-color: black;
        border: 2px solid black;
        border-radius: 5px
    }

    header{
        -moz-box-shadow: 10px 10px 23px 0px rgba(0,0,0,0.1);
        box-shadow: 10px 10px 23px 0px rgba(0,0,0,0.1);
        height: 110px;
        vertical-align: middle;
    }

    h1{
        float: left;
        padding: 10px 30px
    }

    body{
        margin: 0;
        padding: 0;
        font-family: 'Raleway', sans-serif;
    }

    .icons{
        display: inline;
        float: right
    }

    .notification{
        padding-top: 30px;
        position: relative;
        display: inline-block;
    }

    .number{
        height: 25px;
        width:  25px;
        background-color: #d63031;
        border-radius: 20px;
        color: white;
        text-align: center;
        position: absolute;
        top: 23px;
        left: 60px;
        padding: 3px;
        border-style: solid;
        border-width: 2px;
    }

    .number:empty {
        display: none;
    }

    .notBtn{
        transition: 0.5s;
        cursor: pointer
    }

    .fas{
        font-size: 25pt;
        padding-bottom: 10px;
        color: black;
        margin-right: 40px;
        margin-left: 40px;
    }

    .box{
        width: 400px;
        height: 0px;
        border-radius: 10px;
        transition: 0.5s;
        position: absolute;
        overflow-y: scroll;
        padding: 0px;
        left: -300px;
        margin-top: 5px;
        background-color: #F4F4F4;
        -webkit-box-shadow: 10px 10px 23px 0px rgba(0,0,0,0.2);
        -moz-box-shadow: 10px 10px 23px 0px rgba(0,0,0,0.1);
        box-shadow: 10px 10px 23px 0px rgba(0,0,0,0.1);
        cursor: context-menu;
    }

    .fas:hover {
        color: #d63031;
    }

    .notBtn:hover > .box{
        height: 30vh;
    }

    .content{
        padding: 20px;
        color: black;
        vertical-align: middle;
        text-align: left;
    }

    .gry{
        background-color: #F4F4F4;
    }

    .top{
        color: black;
        padding: 10px
    }

    .display{
        position: relative;
    }

    .cont{
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: #F4F4F4;
    }

    .cont:empty{
        display: none;
    }

    .stick{
        text-align: center;
        display: block;
        font-size: 50pt;
        padding-top: 70px;
        padding-left: 80px
    }

    .stick:hover{
        color: black;
    }

    .cent{
        text-align: center;
        display: block;
    }
    .sec{
        padding: 0px 10px;
        background-color: #F4F4F4;
        transition: 0.5s;
    }

    .profCont{
        padding-left: 15px;
    }

    .profile{
        -webkit-clip-path: circle(50% at 50% 50%);
        clip-path: circle(50% at 50% 50%);
        width: 75px;
        float: left;
    }

    .txt{
        vertical-align: top;
        font-size: 0.80rem;
        padding: 5px 10px 0px 115px;
    }

    .sub{
        font-size: 0.50rem;
        color: grey;
    }

    .new{
        border-style: none none solid none;
        border-color: red;
    }

    .sec:hover{
        background-color: #BFBFBF;
    }
    #notifications li{
        background: #e9a84cc2;
        color: darkblue;
        margin: 7px;
        border-radius: 0.2rem;

    }
</style>
<nav x-data="{ open: false }">
    <header class="pc-header ">
        <div class="header-wrapper">
            <div class="ms-auto">

                <ul class="list-unstyled">
{{--                    <div class="dropdown dropdown1">--}}
{{--                        <ul class="" aria-labelledby="notificationsMenu" id="notifications">--}}
{{--                            <li class="dropdown-header">No notifications</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                    <div class = "notification">
                        <a href = "#">
                            <div class = "notBtn" href = "#">
                                <!--Number supports double digets and automaticly hides itself when there is nothing between divs -->
                                <div class = "number">0</div>
                                <i class="fas fa-bell"></i>
                                <div class = "box">
                                    <div class = "display">
                                        <div class = "nothing">
                                            <i class="fas fa-child stick"></i>
                                            <div class = "cent">Looks Like your all caught up!</div>
                                        </div>
                                        <div class = "cont"  aria-labelledby="notificationsMenu" id="notifications"><!-- Fold this div and try deleting evrything inbetween -->
                                            <li class="dropdown-header">No notifications</li>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
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


