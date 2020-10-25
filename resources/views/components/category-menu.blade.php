<div class="col-12" style="height:100%">
    <nav id="sidebar">
        <div class="my-3 sidebar-header">
            <h3 class="px1">Paises</h3>
        </div>

        <ul class="list-unstyled components">
            @foreach ( $categories as $category )
                <li>
                    <a class="px-2" href="{{ url('category/'.$category->Name) }}">{{ $category->Name }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>