@if ($errors->any())
<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
            <li> {{ $error }}</li>
        @endforeach
    </ul>
</div>

@endif