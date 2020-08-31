@extends('layouts.app')
@section('title', __('lang_v1.contact_locations'))

@section('content')
    @php
        $api_key = env('GOOGLE_MAP_API_KEY');
    @endphp
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> @lang('lang_v1.contact_locations')
    </h1>
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-solid'])
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{$api_key}}"></script>
        <div id="map" style="height: 450px;"></div>
    @endcomponent

</section>
<!-- /.content -->
@stop
@section('javascript')
    @if(!empty($api_key))
    <script type="text/javascript">
        $(document).ready( function(){
            initMap();
        });

        var map
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: {lat: -33.9, lng: 151.2}
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    map.setCenter(initialLocation);
                });
            }

            setMarkers(map);
        }

        function setMarkers(map) {
            var contacts = [
                @foreach($contacts as $contact)
                    @php
                        $contact_type = $contact->type != 'both' ? __('contact.' . $contact->type) : __('lang_v1.both_customer_and_supplier');
                    @endphp
                    [
                        "{{$contact->name}} ({{$contact->contact_id}}) \n {{$contact_type}}", 
                        {{$contact->position}}
                    ],
                @endforeach
            ];

            for (var i = 0; i < contacts.length; i++) {
                var contact = contacts[i];
                var marker = new google.maps.Marker({
                    position: {lat: contact[1], lng: contact[2]},
                    map: map,
                    title: contact[0]      
                });
            }
        };
    </script>
    @endif
@endsection
