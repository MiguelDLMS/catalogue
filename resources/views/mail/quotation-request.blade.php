@component('mail::message')

    # Solicitud de cotización

    **{{ $requesterName }} {{ $requesterLastName }}** con e-mail **{{ $requesterMail }}**,ha solicitado una cotización sobre el producto **{{ $productName }}**.

    # Especificaciones de la solicitud

    {{ $requestSpecifications }}

    @component('mail::button', ['url' => "{{ url('/product/'.$productID) }}"])
        Ver  producto
    @endcomponent

    Excelente día,
    {{ config('app.name') }}

@endcomponent
