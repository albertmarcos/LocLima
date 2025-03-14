@push('head')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

@endpush
<div>
    <div class="mb-3">
        <button wire:click="saveLocation" class="px-4 py-2 bg-blue-500 text-white rounded">Salvar Localização</button>
    </div>
    @dump($latitude, $longitude)
    <div id="map2" class="" style="height: 500px;" ></div>


    


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let map2 = L.map('map2').setView([{{ $latitude }}, {{ $longitude }}], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map2);

            let marker = L.marker([{{ $latitude }}, {{ $longitude }}], { draggable: true }).addTo(map2);

            marker.on('dragend', function(event) {
                let position = event.target.getLatLng();
                @this.set('latitude', position.lat);
                @this.set('longitude', position.lng);
            });
        });
    </script>
</div>
