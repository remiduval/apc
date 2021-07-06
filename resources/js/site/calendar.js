var calendar;

document.addEventListener('DOMContentLoaded', function() {

	var calendarEl = document.getElementById('calendar');

	calendar = new FullCalendar.Calendar(calendarEl, {
		showNonCurrentDates:	false,
		contentHeight:          'auto',
		firstDay:				1,
		initialView:			getView(),
		timeZone:				'Europe/London',
		locale:					calendarEl.dataset.lang,
		googleCalendarApiKey:	calendarEl.dataset.apiKey,
		eventSources:			sources,

		windowResize: function(arg) {
			calendar.changeView(getView());
		},

		eventClick: function(info) {
			info.jsEvent.preventDefault();

			var subtitle = "";
			var description = "";
			var settings = 	{
				weekday: 'short', 
				day: 'numeric', 
				month: 'short', 
				timeZone: 'Europe/London'
			}

			if (info.event.extendedProps.description) {
				var description = "<p>" + info.event.extendedProps.description + "</p>";
			}

			if (info.event.allDay) {
				settings['isExclusive'] = true;
				var hackedEnd = convertTZ(info.event.end, "Europe/London"); // hack to fix bug: https://github.com/fullcalendar/fullcalendar/issues/5273#issuecomment-796529879
			} else {
				settings['isExclusive'] = false;
				settings['hour'] = '2-digit';
				settings['minute'] = '2-digit';
			}

			subtitle = 	calendar.formatRange(
				info.event.start,
				(hackedEnd ? hackedEnd : info.event.end),
				settings
			);

			var buttons = [
				google = {
					label: "Add to Google Calendar",
					icon: "icon/calendar",
					url: getPlatformLink(info.event, 'google')
				},
				apple = {
					label: "Add to Apple or Outlook",
					icon: "icon/calendar",
					url: getPlatformLink(info.event, 'apple')
				}
			];

			var args = {
				title: info.event.title,
				subtitle: subtitle,
				content: description,
				buttons: buttons
			};

			openLightbox(args);
		},
	});

	calendar.render();
});

function getView() {
	return (window.innerWidth < '768' ? 'listMonth' : 'dayGridMonth');
}

function convertTZ(date, tzString) {
	return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: tzString}));   
}

function toggleSource(source) {
	this.active = true;
	var eventSource = calendar.getEventSourceById(source);
	if (eventSource) {
		eventSource.remove();
	} else {
		calendar.addEventSource( sources.find( ({ id }) => id === source ) );
	}
}

function getPlatformLink(event, platform) {
	var startTime 	= event.start.toISOString().replace(/-|:|\.\d+/g, '');
	var endTime 	= event.end.toISOString().replace(/-|:|\.\d+/g, '');

	if (platform == "google") {
		return encodeURI([
			'https://www.google.com/calendar/render',
			'?action=TEMPLATE',
			'&text=' + (event.title || ''),
			'&dates=' + (startTime || ''),
			'/' + (endTime || ''),
			'&details=' + (event.description || ''),
			'&location=' + (event.location || ''),
			'&sprop=&sprop=name:'
		].join(''));
	}

	if (platform == "apple") {
		return encodeURI(
			'data:text/calendar;charset=utf8,' + [
			'BEGIN:VCALENDAR',
			'VERSION:2.0',
			'BEGIN:VEVENT',
			'URL:' + document.URL,
			'DTSTART:' + (startTime || ''),
			'DTEND:' + (endTime || ''),
			'SUMMARY:' + (event.title || ''),
			'DESCRIPTION:' + (event.description || ''),
			'LOCATION:' + (event.location || ''),
			'END:VEVENT',
			'END:VCALENDAR'].join('\n'));
	}
}