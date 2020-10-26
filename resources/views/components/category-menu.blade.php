<nav id="sidebar">
    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>

    <div class="p-3 sidebar-header">
        <h3 class="px1">Paises</h3>
    </div>

    <ul class="list-unstyled components">
        @foreach ( $categories as $category )
            <li>
                <a class="px-4" href="{{ url('category/'.$category->Name) }}">{{ $category->Name }}</a>
            </li>
        @endforeach
    </ul>
</nav>