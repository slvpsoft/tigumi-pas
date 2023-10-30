@extends('layout.app')
@section('content')
    <main class="flex min-h-screen ">
        @include('component.sideImage')
        <section class="w-2/3">
            <h3 class="text-3xl section-title p-8">Login</h3>
                <form action="{{route('auth.login')}}" method="POST"
                class="main-container flex" >
                    <div class="flex flex-col w-72 m-auto">
                        @csrf
                        <input class=" bg-gray-200 my-6 p-4 text-xl font-bold text-gray-800 placeholder-gray-700" type="text" name="username" id="username" placeholder="Username">
                        <input class="bg-gray-200 my-6 p-4 text-xl font-bold text-gray-800 placeholder-gray-700" type="password" name="passwd" id="passwd" placeholder="Password">
                        <button class="my-6 p-3 text-xl shadow-lg text-white font-bold bg-black" type="submit">Login</button>
                    </div>
                </form>
        </section>
    </main>
@endsection
