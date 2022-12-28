function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById("popover-header")) {
    // if present, the header is where you move the DIV from:
    document.getElementById("popover-header").onmousedown = dragMouseDown;
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
    console.log(data);
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}

var previousTitle = '';
function showEventDetails(e, data) {
    if (data.type || previousTitle == data.title) {
        return;
    }
    const acronym = 'jev22';

    let popover = document.getElementById("schedule-event-detail-popover");
    console.log(data, e);
    // set the element's new position:
    popover.style.left = (e.pageX) + "px";
    popover.style.top = (e.pageY) + "px";

    document.getElementById("modal-title").textContent = data.title;
    document.getElementById("modal-data").innerHTML = `
    <dt>Start:</dt>
    <dd><time datetime="27. Dezember 2021 11:30">27. Dezember 2021 11:30</time></dd>

    <dt>Duration:</dt>
    <dd><time datetime="00:45:00">00:45</time></dd>

    <dt>Room:</dt>
    <dd>c-base</dd>    

    <dt>Language:</dt>
    <dd>de</dd>

    <dt>Speakers:</dt>
    <dd>Thomas Fricke</dd>

    <dt>Video:</dt>
    <dd>
        <a class="a" href="/${acronym}/relive/${data.guid}" title="relive" target="_blank">relive</a>
        <a class="a" href="https://media.ccc.de/v/${data.guid}" title="recording" target="_blank">recording</a>
    </dd>
    
    <dt>Origin:</dt>
    <dd width="100%"><a class="a" href="${data.url}" alt="Details" target="_blank">${data.url}</a></dd>
    `;
    popover.style.display = 'block';
    if (!previousTitle) { dragElement(popover); }
    previousTitle = data.title;
}