<div class="col-12 float-md-left" style="height:100%">
    <nav id="sidebar">
        <div class="p-3 sidebar-header">
            <h3 class="px1">Paises</h3>
        </div>

        <ul>
            @foreach ( $categories as $category )
                <li>
                    <a class="px-4" href="{{ url('category/'.$category->Name) }}">{{ $category->Name }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>