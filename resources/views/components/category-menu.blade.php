<nav id="sidebar">
    <div class="p-5 sidebar-header">
        <h3 class="px1">Paises</h3>
    </div>

    <ul class="list-unstyled components">
        @foreach ( $categories as $category )
            <li>
                <a class="px-7" href="{{ url('category/'.$category->Name) }}">{{ $category->Name }}</a>
            </li>
        @endforeach
    </ul>
</nav>
