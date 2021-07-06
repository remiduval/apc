function set_iframe_dimensions(iframe) {
	iframe.parentNode.style.setProperty('--iframe-width', iframe.offsetWidth);
	iframe.parentNode.style.setProperty('--iframe-height', iframe.offsetHeight);
	iframe.parentNode.className += " iframe--mesured";
}