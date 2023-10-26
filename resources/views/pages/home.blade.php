@extends('layout.app')
@section('content')
    <main class="flex min-h-screen ">
        @include('component.sideImage')
        <section class="home w-2/3">
            <h3 class="text-3xl section-title p-8 pb-0">Home</h3>

            <div class="count-container flex justify-center text-center text-3xl mb-8">
                <div class="w-1/3 mt-auto">
                    <span>TME</span>
                    <p>9999</p>
                </div>

                <div class="w-1/3">
                    <span>Combo</span>
                    <p class="text-5xl">99</p>
                </div>
            </div>
            <div class="flex justify-center">
                <table class="calendar bg-gray-200 text-center ">
                    <tr class="bg-none bg-white text-lg">
                        <th class="px-4">Sun</th>
                        <th class="px-4">Mon</th>
                        <th class="px-4">Tue</th>
                        <th class="px-4">Wed</th>
                        <th class="px-4">Thu</th>
                        <th class="px-4">Fri</th>
                        <th class="px-4">Sat</th>
                    </tr>
                    <tr>
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @if (($day + $firstDay - 1) % 7 == 1 && $day != 1)
                    </tr>
                    <tr>
                        @endif
                        {{-- TEST ONLY --}}
                        @if ($day != 2)
                            <td class="px-4 pb-8 pt-2 text-2xl text-white bg-zinc-500">{{ $day }}
                                <p class="h-3 w-10 text-2xl"></p>
                            @else
                                {{-- Sample Highlight --}}
                            <td class="px-4 pb-8 pt-2 text-2xl text-white bg-black">{{ $day }}
                                <p class="h-3 w-10 text-2xl m-auto">250</p>
                        @endif
                        {{-- TEST END --}}
                        </td>
                        @endfor
                    </tr>
                </table>
            </div>
            @include('component.navButton')
        </section>
    </main>
@endsection
