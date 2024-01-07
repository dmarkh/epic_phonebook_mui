<script>
	import L from 'leaflet';
	import { getContext } from "svelte";

	export let lat = 0;
	export let lng = 0;
	export let desc = '';

	let map = getContext('leafletMapInstance');
	let marker = L.marker([lat, lng]);

	marker.bindPopup( desc, {maxWidth: 500} ).openPopup();
	marker.addTo(map);
</script>
