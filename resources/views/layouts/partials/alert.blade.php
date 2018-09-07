@if (session()->has('mesaj'))
    <div class="container" style="width:100%;">
        <div class="alert alert-{{ session('mesaj_tur') }}">
            {{ session('mesaj') }}
        </div>
    </div>
@endif
