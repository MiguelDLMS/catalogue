<div class="col-12">
    <h1 class="my-4">Menú</h1>
    <div class="list-group">
        @foreach ( $categories as $category )
            <a href="{{ url('category/'.$category->Name) }}" class="list-group-item">{{ $category->Name }}</a>
        @endforeach
    </div>
</div>
