@section('leftsidebar')
<section class="left-panel">
    <div class="vws-title"><h2>VWS</h2></div>
    <div class="wrapper">
<<<<<<< HEAD:src/resources/views/participantPortal/leftsidebar.blade.php
        <ul class="nav nav-pills nav-fill flex-column w-100" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <li class="nav-item">
              <a class="nav-link active" role="tablist" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Wellness Activity</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" role="tablist" href="#">Survey</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link disabled" href="#">Forums</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#">Messages</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">{{ auth()->user()->name }}</a>
              </li>
=======
        <ul class="list-group" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <li class="list-group-item active" aria-current="true"><a>Dashboard</a></li>
            <li class="list-group-item"><a>Wellness Activity</a></li>
            <li class="list-group-item"><a>Survey</a></li>
            <li class="list-group-item"><a>Forums</a></li>
            <li class="list-group-item"><a>Messages</a></li>
            <li class="list-group-item"><a href ="/userProfilePage/{{ auth()->user()->id }}">Profile Page</a></li>
            @auth
>>>>>>> a783f937458b17b813c16b0e86bbd711dd646eab:src/resources/views/layouts/sidebars/participantleftsidebar.blade.php

              <li class="nav-item">
                <form action="{{ route('logout') }}" method="post" class="form-inline" style="width:100%">
                    @csrf
                        <button class="btn btn-outline-success" type="submit">Logout</button>
                    </form>
              </li>
              @endauth

              @guest
              <li class="nav-item">
                <a class="nav-link" href="#">Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Register</a>
              </li>
              @endguest

          </ul>
    </div>
    <div class="upei-logo"><img src="{{URL::to('/images/UPEI_Logo.png')}}" style="height: 54px; width: 134px;"></img></div>
</section>
@endsection('leftsidebar')
