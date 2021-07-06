if (typeof map_loaded == 'undefined') {
	var map_loaded = true;


	var maps = document.querySelectorAll('.map');
	Array.prototype.forEach.call(maps, function(el, i){

		map = map_create(
			'map_'+el.dataset.index, 
			el.dataset.latitude,
			el.dataset.longitude, 
			el.dataset.zoom,
			el.dataset.mapboxToken,
			el.dataset.mapboxTileset
		);

		const markers = window['markers_' + el.dataset.index];

		for (const marker in markers) {
			map_marker(
				map, 
				markers[marker].latitude,
				markers[marker].longitude,
				markers[marker].name,
				markers[marker].paragraph,
				markers[marker].open
			);

		}
	});

	function map_create(
		map_id, 
		latitude, 
		longitude,
		zoom = 12, 
		mapboxToken,
		mapboxTileset
	) {


		var mapOptions = {
			center: [latitude, longitude],
			zoom: zoom,
			dragging: !L.Browser.mobile,
			scrollWheelZoom: false,
		}

		var map = new L.map(map_id, mapOptions);

		var layer = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + mapboxToken, {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>, ' +
				'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: mapboxTileset,
			tileSize: 512,
			zoomOffset: -1,
			detectRetina: true
		});

		map.addLayer(layer);
		return map;
	}


	function map_marker(
		map, 
		latitude,
		longitude,
		heading			= null, 
		description		= null, 
		open			= false,
		iconName		= 'marker', 
		iconSize		= [38, 38], 
		iconAnchor		= null, 
		popupAnchor		= [0, -19]
	) {

		var icon = L.icon({
			iconUrl: '/svg/' + iconName + '.svg',
			iconSize: iconSize,
			iconAnchor: iconAnchor,
			popupAnchor: popupAnchor
		});

		var marker = L.marker([latitude, longitude], { icon: icon });

		if (heading || description) {
			var popup = "";
			if (heading) {
				popup += "<div class='marker__heading'>" + heading + "</div>";
			}
			if (description) {
				popup += "<div class='marker__description prose'>" + description + "</div>";
			}
			marker.bindPopup(popup);
		}

		marker.addTo(map);

		if (open) {
			marker.openPopup();
		}
	}

}