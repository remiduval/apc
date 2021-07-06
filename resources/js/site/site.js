// Global cookie functions (used by cookie banner).
window.setCookie = function(name, value, days) {
	let expires = ''
	if (days) {
		const date = new Date()
		date.setTime(date.getTime() + (days*24*60*60*1000))
		expires = '; expires=' + date.toUTCString()
	}
	document.cookie = name + '=' + (value || '')  + expires + '; path=/'
}

window.eraseCookie = function(name) {
	document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'
}

window.getCookie = function(name) {
	const value = `; ${document.cookie}`;
	const parts = value.split(`; ${name}=`);
	if (parts.length === 2) return parts.pop().split(';').shift();
}

// Emulating masonry on mobile menu by placing the long 'Our school' item in second place
var mobile_menu_items = document.querySelectorAll(".modal .menu > ul > li");
mobile_menu_items[0].parentNode.insertBefore(mobile_menu_items[2], mobile_menu_items[1]);

function doesntSupportFlexboxGap() {
	// create flex container with row-gap set
	var flex = document.createElement("div");
	flex.style.display = "flex";
	flex.style.flexDirection = "column";
	flex.style.rowGap = "1px";
  
	// create two, elements inside it
	flex.appendChild(document.createElement("div"));
	flex.appendChild(document.createElement("div"));
  
	// append to the DOM (needed to obtain scrollHeight)
	document.body.appendChild(flex);
	var isSupported = flex.scrollHeight === 1; // flex container should be 1px high from the row-gap
	flex.parentNode.removeChild(flex);

	return !isSupported;
}
document.addEventListener('DOMContentLoaded', function() {
	if ( doesntSupportFlexboxGap() ) {
		document.body.classList.add("no-flexbox-gap");
	}
});