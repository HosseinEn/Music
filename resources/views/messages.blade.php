@if ($errors->any())
    @foreach ($errors->all() as $error)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $error }}</strong>
        </span>
    @endforeach
@endif

@if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
@endif
