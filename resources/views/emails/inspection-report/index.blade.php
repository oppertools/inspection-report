<x-mail::message>
<h1>Votre état des lieux est disponible.</h1>

Bonjour {{ $representative }},


L'état des lieux pour le bien situé **{{ $property }}** est maintenant **prêt à être téléchargé**
<x-mail::button :url="$url" color="primary">
Télécharger mon état des lieux
</x-mail::button>

Retrouvez le récapitulatif de votre état des lieux :
- Locataires :
@foreach($tenants as $tenant)
    - {{ ltrim($tenant->firstName, '-') }} {{ rtrim($tenant->lastName, '-') }} @if($tenant->email)({{ $tenant->email }})@endif
@endforeach
</x-mail::message>
