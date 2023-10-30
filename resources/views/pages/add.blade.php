@extends('layout.app')
@section('content')
    <main class="flex min-h-screen ">
        @include('component.sideImage')
        <section class="w-2/3">
            <h3 class="text-3xl section-title p-8">Expense</h3>
            <form action="{{route('storeExp')}}" method="POST"
            class="flex">
                @csrf
                <div class="flex flex-col w-72 m-auto">
                    <input class=" bg-gray-200 my-6 p-4 text-xl font-bold text-gray-800 placeholder-gray-700" type="text" name="label" id="label" placeholder="Label">
                    <input class=" bg-gray-200 my-6 p-4 text-xl font-bold text-gray-800 placeholder-gray-700" type="text" name="category" id="category" placeholder="Category">
                    <input class=" bg-gray-200 my-6 p-4 text-xl font-bold text-gray-800 placeholder-gray-700" type="number" name="amount" id="amount" placeholder="Amount">
                    <button class="my-6 px-3 py-4 text-xl shadow-lg text-white font-bold bg-black hover:bg-zinc-500" type="submit">Submit</button>
                </div>
            </form>
        @include('component.navButton')
        </section>
    </main>
@endsection
