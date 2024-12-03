let map;
        let service;

        async function initMap() {
            const { Map, InfoWindow } = await google.maps.importLibrary("maps");
            const center = new google.maps.LatLng(40.7710, -73.9851); // Default: New York City

            map = new Map(document.getElementById("map"), {
                center: center,
                zoom: 14,
            });

            service = new google.maps.places.PlacesService(map);  // PlacesService initialized

            console.log("Map initialized, ready for search.");
        }

        async function searchStores() {
            const locationInput = document.getElementById('location-input').value.trim();
            let searchLocation = locationInput ? locationInput : "New York City"; // Default to New York City if input is empty

            // Get geocode for location entered by user
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: searchLocation }, (results, status) => {
                if (status === google.maps.GeocoderStatus.OK) {
                    const userLocation = results[0].geometry.location;
                    console.log(`User location found: ${userLocation}`);
                    map.setCenter(userLocation);
                    nearbySearch(userLocation);  // Call to nearbySearch
                } else {
                    alert('Error geocoding location: ' + status);
                    console.error(`Geocoding error: ${status}`);
                }
            });
        }

        async function nearbySearch(center) {
            const request = {
                location: center, // User's location
                radius: 1500, // Search radius in meters 
                keyword: 'thrift store', // Start with "thrift store"
            };

            console.log("Making Nearby Search request:", request);

            // Call to nearbySearch method
            service.nearbySearch(request, callback);
        }

        // Callback to process search results
        function callback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                const bounds = new google.maps.LatLngBounds();

                results.forEach((place) => {
                    console.log(`Found place: ${place.name}, Address: ${place.vicinity}`);

                    const marker = new google.maps.Marker({
                        map: map,
                        position: place.geometry.location,
                        title: place.name,
                    });

                    bounds.extend(place.geometry.location);

                    // Adding infoWindow on marker click
                    marker.addListener('click', () => {
                        const infoWindow = new google.maps.InfoWindow({
                            content: `<strong>${place.name}</strong><br>${place.vicinity}`,
                        });
                        infoWindow.open(map, marker);
                    });
                });

                map.fitBounds(bounds); // Adjust the map to show all markers
            } else {
                alert("No stores found nearby.");
                console.log("Status: ", status); // Log status for debugging
            }
        }