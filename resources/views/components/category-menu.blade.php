<div class="col-12">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Menú</h3>
        </div>

        <ul class="list-unstyled components">
            <p>Paises</p>
            @foreach ( $categories as $category )
                <li>
                    <a href="{{ url('category/'.$category->Name) }}" class="list-group-item">{{ $category->Name }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>