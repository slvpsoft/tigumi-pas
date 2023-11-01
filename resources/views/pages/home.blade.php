@extends('layout.app')
@section('content')
    <main class="flex min-h-screen ">
        @include('component.sideImage')
        <section class="home w-2/3">
            <h3 class="text-3xl section-title p-8 pb-0">Home</h3>

            <div class="count-container flex justify-center text-center text-3xl mb-2">
                <div class="w-1/3 mt-auto">
                    {{-- Total Montly Expenses --}}
                    <span>TME</span>
                    <p class="expenses select-none">{{ $totalMonthExp }}</p>
                </div>

                <div class="w-1/3">
                    <span>Combo</span>
                    <p class="text-5xl select-none">{{ $combo }}</p>
                </div>
            </div>

            <p id="monthName" class="calendar text-3xl w-fit m-auto cursor-pointer">{{ $monthName }}</p>
            <div class="flex justify-center">
                <table class="calendar bg-gray-200 text-center">
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
                            {{-- On First Day, Add empty days --}}
                                @if($day == 1)
                                    @for($emptyDay = 1; $emptyDay < $firstDay; $emptyDay++)
                                        <td class="px-4 pb-6 pt-2">
                                            <div class="h-3">
                                            </div>
                                        </td>
                                    @endfor
                                @endif

                                {{-- Check for logged expenses on calendar day --}}
                                @if (in_array($day, $expKeys))
                                    <td class="px-4 pb-6 pt-2 text-2xl text-white bg-black select-none">{{ $day }}
                                        <div class="h-3">
                                            <p class="expenses w-10 text-2xl m-auto">{{ $expList[$day] }}</p>
                                        </div>
                                    </td>
                                @else
                                    <td class="px-4 pb-6 pt-2 text-2xl text-white bg-zinc-500 select-none">{{ $day }}
                                        <p class="h-3 w-10 text-2xl"></p>
                                    </td>
                                @endif
                        @endfor
                    </tr>
                </table>
            </div>
            @include('component.navButton')
        </section>
    </main>
@endsection

@section('scripts')
    @vite('resources/js/pages/home.js')
@endsection
