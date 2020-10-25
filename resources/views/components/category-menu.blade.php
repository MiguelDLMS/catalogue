<div class="col-12">
    <nav id="sidebar">
        <div class="my-3 sidebar-header">
            <h3>Paises</h3>
        </div>

        <ul class="list-unstyled components">
            @foreach ( $categories as $category )
                <li>
                    <a href="{{ url('category/'.$category->Name) }}">{{ $category->Name }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>