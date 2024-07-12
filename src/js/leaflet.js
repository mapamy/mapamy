// Import Leaflet's JavaScript and CSS
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L;

const mapamyMarker = L.icon({
    iconUrl: '/dist/leaflet-marker.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
});

// Set mapamyMarker as the default icon for all markers
L.Marker.prototype.options.icon = mapamyMarker;

// Ensure the subobject exists
window.leafletUtils = window.leafletUtils || {};

// Assign functions to the subobject
window.leafletUtils.addMarker = function(lat, lng, popupContent = '') {
    const marker = L.marker([lat, lng]).addTo(window.map);
    if (popupContent) {
        marker.bindPopup(popupContent);
    }
    return marker;
};

window.leafletUtils.setMapView = function(lat, lng, zoom) {
    window.map.setView([lat, lng], zoom);
};

window.leafletUtils.fitMapToMarkers = function(markerCoordinates) {
    const bounds = L.latLngBounds(markerCoordinates);
    window.map.fitBounds(bounds);
};

document.addEventListener('DOMContentLoaded', function() {
    // Set a map to the leaflet-map id div
    const map = L.map('leaflet-map').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Save it to the window object
    window.map = map;
});