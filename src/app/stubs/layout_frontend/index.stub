@extends('master')
@section('title')
    Index
@stop
@section('breadcrumb')
@stop
@section('content')
        <div >
            @if (Route::has('login'))
                <div class=" center">
                    @auth
                        <a href="{{ url('/admin/dashboard') }}" class="" style="padding: 5px;font-weight: bold;text-decoration: underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="" style="padding: 5px">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="" style="padding: 5px">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    <section class="many">
        <nav class="nav1 nav2">
            <ul class="list">
                <h1>Aside Links</h1>
                <li class="link link1">
                    <a href="#">Link 1</a>
                </li>
                <li class="link link2">
                    <a href="#">Link 2</a>
                </li>
                <li class="link link3">
                    <a href="#">Link 3</a>
                </li>
                <li class="link link4">
                    <a href="#">Link 4</a>
                </li>
                <li class="link link5">
                    <a href="#">Link 5</a>
                </li>
            </ul>
        </nav>
        <div class="article nav2">
            <div class="upper">
                <h1 class="upperheader" >Article 1</h1>
            </div>
            <div class="lower">
                <h1 class="lowerheader">Article 2</h1>
            </div>
            <div class="upper">
                <h1 class="upperheader" >Article 3</h1>
            </div>
            <div class="lower">
                <h1 class="lowerheader">Article 4</h1>
                <h3 class="lfooter">Article footer</h3>
            </div>
        </div>
        <aside class="aside">
            <h1>Aside</h1>
            Hello my name is you , and you is a very good person;
            But you, know you do not know you;
            but i think you is me and you know you very well.
            So You are wrong.
        </aside>
        <aside class="aside">
            <h1></h1>
        </aside>
        <aside class="aside">
            <h1></h1>
        </aside>
    </section>
@stop



