<script src="{{ asset('app/js/vendor.js') }}"></script>
<script src="{{ asset('app/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('backend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('app/js/validation.js') }}"></script>
<script src="{{ asset('app/js/barrating.js') }}"></script>
@if(Route::is('kyc'))
	<script src="https://cdn.withpersona.com/dist/persona-v4.8.0.js"></script>
	<script src="{{ asset('app/js/user_kyc.js') }}"></script>
@endif
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDbX_JirTlqgj9BO002nMah8CQSD7f4ypI&signed_in=true&libraries=places"></script>
<script type="text/javascript">
	initMap(23.4241,53.8478);

    function initMap(latitude,longitude) {
        var myLatLng = {lat: latitude, lng: longitude};
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 18,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById("latitude").value = this.getPosition().lat();
            document.getElementById("longitude").value = this.getPosition().lng();
        });
    }
</script>