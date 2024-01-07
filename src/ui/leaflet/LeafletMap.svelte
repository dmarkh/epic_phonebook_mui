<script>

	import L from 'leaflet';
	import { setContext, getContext, onMount } from "svelte";
	import "../../../node_modules/leaflet/dist/leaflet.css";
	import "../../vendor/leaflet-bigimage/Leaflet.BigImage.min.css";
	import "../../vendor/leaflet-bigimage/Leaflet.BigImage.min.js";

	L.Icon.Default.imagePath = 'images/';

	let mapContainer;
	let map;

	map = L.map(L.DomUtil.create('div'), {
			center: new L.LatLng(36.7528852,3.0245384),
			zoom: 2
		});
	setContext('leafletMapInstance', map);


                var Esri_NatGeoWorldMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
                    maxZoom: 16
                });

        map.addLayer(Esri_NatGeoWorldMap);

                var Esri_WorldImagery = new L.TileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
                });
                var Esri_WorldStreetMap = new L.TileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
                });
                var OpenTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                    maxZoom: 17,
                    attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors,<a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
                });

                var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {minZoom: 1, maxZoom: 20, attribution: 'Map data  <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'});

        map.addControl(new L.Control.Layers( {
                    "Geo World Map": Esri_NatGeoWorldMap,
                    "World Street Map": Esri_WorldStreetMap,
                    "Topographical Map": OpenTopoMap,
                    "Satellite Map": Esri_WorldImagery,
                    'Bi-color Map': osm,
                }, {}));

	L.control.bigImage({position: 'bottomright'}).addTo( map );

	onMount(() => {
		mapContainer.appendChild(map.getContainer());
		map.getContainer().style.width = '100%';
		map.getContainer().style.height = '100%';
		map.invalidateSize();
	});
</script>
<style>
    .map {
        height: 100%;
        width:  100%;
    }
</style>
<div class='map' bind:this={mapContainer}>
  <slot></slot>
</div>
