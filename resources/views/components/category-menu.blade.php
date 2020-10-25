<div class="col-12" style="height:100%">
    <nav id="sidebar">
        <div class="p-3 sidebar-header">
            <h3 class="px1">Paises</h3>
        </div>

        <ul class="list-unstyled components px-4">
            @foreach ( $categories as $category )
                <li>
                    <a href="{{ url('category/'.$category->Name) }}">{{ $category->Name }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>