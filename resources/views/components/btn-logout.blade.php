<form method="POST" action="{{ route('logout') }}" x-data>
    @csrf
    <a href="{{ route('logout') }}" @click.prevent="$root.submit();">
        <div class="p-3 bg-white rounded-lg shadow-xl hover:bg-gray-300">
            <div class="flex justify-center">
                <img src="/img/7.png" class="object-cover w-40" alt="">
            </div>
            <div>
                <h1 class="text-xl font-semibold leading-tight text-center text-gray-800">
                    Salir
                </h1>
            </div>
        </div>
    </a>
</form>
