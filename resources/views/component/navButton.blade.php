<div class="text-center mt-12 text-white font-bold text-xl select-none">
    <a
    @if(request()->route()->getName() != 'dashboard')
        href="{{route('dashboard')}}"
    @endif
    class="py-5 px-20 mx-6 shadow-lg bg-black hover:bg-zinc-500" type="submit">Home</a>
    <a
    @if(request()->route()->getName() != 'expense')
        href="{{route('expense')}}"
    @endif
    class="py-5 px-20 mx-6 shadow-lg bg-black hover:bg-zinc-500" type="submit">Expense</a>
</div>
