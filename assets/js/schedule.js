const h = HtmlSanitizer.SanitizeHtml

let previousTitle = "";
let lastClose = new Date().getTime();

function dragElement(elmnt) {
	var pos1 = 0,
		pos2 = 0,
		pos3 = 0,
		pos4 = 0,
		header = document.getElementById("popover-header");
	if (header) {
		// if present, the header is where you move the DIV from:
		header.onmousedown = dragMouseDown;
		// TODO: header.ontouchmove = dragMouseDown;
	} else {
		// otherwise, move the DIV from anywhere inside the DIV:
		elmnt.onmousedown = dragMouseDown;
	}

	function dragMouseDown(e) {
		e = e || window.event;
		e.preventDefault();
		// get the mouse cursor position at startup:
		pos3 = e.clientX;
		pos4 = e.clientY;
		document.onmouseup = closeDragElement;
		// call a function whenever the cursor moves:
		document.onmousemove = elementDrag;
	}

	function elementDrag(e, data) {
		e = e || window.event;
		e.preventDefault();
		// calculate the new cursor position:
		pos1 = pos3 - e.clientX;
		pos2 = pos4 - e.clientY;
		pos3 = e.clientX;
		pos4 = e.clientY;
		// set the element's new position:
		elmnt.style.top = elmnt.offsetTop - pos2 + "px";
		elmnt.style.left = elmnt.offsetLeft - pos1 + "px";
	}

	function closeDragElement() {
		// stop moving when mouse button is released:
		document.onmouseup = null;
		document.onmousemove = null;
		previousTitle = "";
	}
}

function closeEventDetails(e) {
	document.getElementById("schedule-event-detail-popover").style.display =
		"none";
	window.scrollLock = false;
	lastClose = new Date().getTime();
}

const acronym = window.location.pathname.split("/")[1];

function showEventDetails(e, data, force = false) {
	if (!force && (data.type || previousTitle == data.title || lastClose > new Date().getTime() - 5000) ){
		return;
	}
	let popover = document.getElementById("schedule-event-detail-popover");
	if (e) {
		popover.style.left = e.pageX + "px";
		popover.style.top = e.pageY + "px";
	}

	document.getElementById("modal-title").innerHTML =
		h(data.title) +
		("subtitle" in data ? `<br/><small>${h(data.subtitle || "")}` : "");
	document.getElementById("modal-data").innerHTML = `
	<dt>Origin:</dt>
	<dd><a class="a" href="${encodeURI(
		data.url
	)}" alt="Details" target="_blank">${h(data.url)}</a></dd>
	
	<dt>Video:</dt>
	<dd>
		<a class="a" href="/${encodeURIComponent(acronym)}/relive/${encodeURIComponent(
		data.guid
	)}" title="relive" target="_blank">relive</a>
		<a class="a" href="https://media.ccc.de/v/${encodeURIComponent(
			data.guid
		)}" title="recording" target="_blank">recording</a>
	</dd>
	`;
	text = document.getElementById("modal-text");
	text.innerHTML = `
	<p>${h(data.abstract || "")}</p>
	<p>${h(data.description || "").replace("\n\n", "<br/><br/>")}</p>
	`;

	popover.style.display = "block";
	if (!previousTitle) {
		dragElement(popover);
	}
	window.scrollLock = true;
	previousTitle = data.title;
	// fetch additional data, currently disabled till we have a global config parameter
	if (false && !force) {
		fetchAdditionalData(data);
	}
}

function fetchAdditionalData(e) {
	let q = {
		query: `{event(guid:"${e.guid}"){guid,title,subtitle,abstract,description,url}}`,
		operation: "EventDetails",
		variables: JSON.stringify({ guid: e.guid }),
	};
	return fetch("https://data.c3voc.de/graphql?query=" + q.query, {
		method: "GET",
		headers: { Accept: "application/json" },
	}).then((r) =>
		r.json().then((r) => {
			let data = Object.assign(e, r.data?.event);
			showEventDetails(null, data, true);
		})
	);
}
