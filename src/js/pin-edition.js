document.addEventListener('DOMContentLoaded', function () {

    // Cache DOM element references
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const gpsDiv = document.querySelector('.image-autodetected-cooridnates');
    const setCoordinatesButton = document.getElementById('set-image-autodetected-coordinates');
    const ignoreCoordinatesButton = document.getElementById('ignore-image-autodetected-coordinates');

    // Cache map and utilities references
    const map = window.map;
    const leafletUtils = window.leafletUtils;

    // Function to update marker, map view, and input fields
    function updateMarkerAndView(lat, lng) {
        // Remove the existing marker
        if (newPinMarker) {
            map.removeLayer(newPinMarker);
        }

        // Add a new marker at the specified location
        newPinMarker = leafletUtils.addMarker(lat, lng);

        // Center the map view on the new marker
        leafletUtils.setMapView(lat, lng, 13); // Adjust zoom level as needed

        // Update the latitude and longitude input fields
        latitudeInput.value = lat.toFixed(6);
        longitudeInput.value = lng.toFixed(6);
    }

    // Map click event handler
    map.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        updateMarkerAndView(lat, lng);
    });

    // Set coordinates button event handler
    if (setCoordinatesButton) {
        setCoordinatesButton.addEventListener('click', function () {
            const lat = parseFloat(this.dataset.latitude);
            const lng = parseFloat(this.dataset.longitude);

            if (!isNaN(lat) && !isNaN(lng)) {
                updateMarkerAndView(lat, lng);

                // Hide the div containing the button
                if (gpsDiv) {
                    gpsDiv.style.display = 'none';
                }
            } else {
                console.error('Invalid GPS coordinates.');
            }
        });
    }

    // Ignore coordinates button event handler
    if (ignoreCoordinatesButton) {
        ignoreCoordinatesButton.addEventListener('click', function () {
            // Hide the div containing the button
            if (gpsDiv) {
                gpsDiv.style.display = 'none';
            }
        });
    }

    // Function to handle input changes
    function onInputChange() {
        // Replace comma with dot if necessary
        const latValue = latitudeInput.value.replace(',', '.');
        const lngValue = longitudeInput.value.replace(',', '.');

        const lat = parseFloat(latValue);
        const lng = parseFloat(lngValue);

        // Validate the numbers
        if (!isNaN(lat) && !isNaN(lng)) {
            if (lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                updateMarkerAndView(lat, lng);
            } else {
                console.error('Latitude must be between -90 and 90 and longitude between -180 and 180.');
            }
        } else {
            console.error('Invalid latitude or longitude value.');
        }
    }

    // Add event listeners to the input fields
    if (latitudeInput && longitudeInput) {
        latitudeInput.addEventListener('change', onInputChange);
        longitudeInput.addEventListener('change', onInputChange);
    }
});
