if (typeof lightbox_loaded == 'undefined') {
	var lightbox_loaded = true;

	var lightboxes = document.querySelectorAll('.lightbox');
	Array.prototype.forEach.call(lightboxes, function(el, i){
		new SimpleLightbox({
			elements: el.children
		});
	});
	
	function openLightbox(args) {
		var strContent = "<div class='lightbox box'>";
		
		$focus = "";
		if (args.focus) {
			$focus = "style='object-position: " + args.focus + "'";
		}
		
		if (args.image) {
			strContent += "<div class='box__image'><picture class='picture picture--fit'><img src='" + args.image + "' alt='" + args.title + "' width='250' height='280' loading='lazy' onload='this.parentNode.classList.add(\"picture--loaded\")' " + $focus + " /></picture></div>";
		}
	
		strContent += "<div class='box__content prose prose--sm'><div class='titles'>";
	
		if (args.subtitle) {
			strContent += "<div class='subtitle'>" + args.subtitle + "</div>";
		}
	
		strContent += "<div class='title'>" + args.title + "</div></div>"
	
		if (args.content) {
			strContent += args.content;
		}

		if (args.buttons.length) {
			strContent += "<div class='set cta'><div class='buttons'>";
	
			for (var button in args.buttons) {
				strContent += "<a href='" + args.buttons[button].url + "' class='link link--button'><span class='label'>" + args.buttons[button].label + "</span></a>";
			}
	
			strContent += "</div></div>";
		}
	
		strContent += "</div></div>";
	
		SimpleLightbox.open({
			content: strContent,
			elementClass: 'slbContentEl'
		});
	}

	
	function openPerson(event) {
		var buttons = [];

		if (event.currentTarget.dataset.phone) {
			phone = {
				label: "Phone",
				url: "tel:" + event.currentTarget.dataset.phone
			}
			buttons.push(phone);
		}

		if (event.currentTarget.dataset.email) {
			email = {
				label: "Email",
				url: "mailto:" + event.currentTarget.dataset.email
			}
			buttons.push(email);
		}

		var args = {
			title:		event.currentTarget.dataset.name,
			subtitle:	event.currentTarget.dataset.position,
			image:		event.currentTarget.dataset.image,
			content:	event.currentTarget.dataset.biography,
			buttons:	buttons,
			focus:		event.currentTarget.dataset.focus
		};

		openLightbox(args);
	}
}