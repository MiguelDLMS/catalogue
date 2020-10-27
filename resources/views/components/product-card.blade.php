<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
<a href="{{ url('/product/'.$productID) }}"><img class="card-img-top" src="{{ asset('images/products/'.$imageName) }}" style="height: 25vh;object-fit: cover;" alt=""></a>
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ url('/product/'.$productID) }}">{{ $productName }}</a>
            </h4>
            <p class="card-text">{{ $productDescription }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ url('/product/'.$productID) }}" class="btn btn-success float-right">Ver</a>
        </div>
    </div>
</div>