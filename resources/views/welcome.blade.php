@extends('layouts.app')
@section('content')

<div class="jumbotron p-5 mb-4 bg-light rounded-3">
    <div class="container py-5">
        <div class="logo_laravel d-inline">
            <img class="w-25" src="{{url('boolbnb_logo.png')}}" alt="">
        </div>
        <h1 class="display-5 fw-bold">
            Benvenuto su BoolBnB
        </h1>

        <p class="col-md-8 fs-4">La Dashboard che ti permette di gestire i tuoi appartamenti in giro per il mondo.</p>
    </div>
    <div class="container-nav fixed-bottom">
        <footer class="fsSmall footer mt-auto">
            <div class="links d-flex justify-content-between border-bottom">
                <ul class="nav justify-content-center">
                    <li class="nav-item"><a href="https://youtu.be/dQw4w9WgXcQ?si=EfCJJohZbHcWNRAC" class="nav-link px-2">Termini</a></li>
                    <li class="nav-item"><a href="https://youtu.be/dQw4w9WgXcQ?si=EfCJJohZbHcWNRAC" class="nav-link px-2">Privacy</a></li>
                    <li class="nav-item"><a href="https://youtu.be/dQw4w9WgXcQ?si=EfCJJohZbHcWNRAC" class="nav-link px-2">FAQs</a></li>
                    <li class="nav-item"><a href="https://youtu.be/dQw4w9WgXcQ?si=EfCJJohZbHcWNRAC" class="nav-link px-2">About</a></li>
                </ul>
    
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a href="https://youtu.be/dQw4w9WgXcQ?si=EfCJJohZbHcWNRAC" class="nav-link px-2"><i class="fa-brands fa-instagram"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="https://youtu.be/dQw4w9WgXcQ?si=EfCJJohZbHcWNRAC" class="nav-link px-2"><i class="fa-brands fa-facebook"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="https://youtu.be/dQw4w9WgXcQ?si=EfCJJohZbHcWNRAC" class="nav-link px-2"><i class="fa-brands fa-x-twitter"></i></a>
                    </li>
                </ul>
            </div>
            <p class="text-center py-2 ">© 2024 BoolBnB, Inc</p>
        </footer>
    </div>
</div>
@endsection
