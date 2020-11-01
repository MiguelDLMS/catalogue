@component('mail::message')

    <h2>Solicitud de cotización</h2>

    <strong> {{ $requesterName }} {{ $requesterLastName }} </strong> con e-mail <strong> {{ $requesterMail }} </strong>,ha solicitado una cotización sobre el producto <strong> {{ $productName }} </strong>.

    <h2>Especificaciones de la solicitud</h2>

    {{ $requestSpecifications }}

    @component('mail::button', ['url' => "{{ url('/product/'.$productID) }}"])
        Ver  producto
    @endcomponent

    Excelente día,<br>
    {{ config('app.name') }}

@endcomponent
