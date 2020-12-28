videojs.log.level('debug');


var player = videojs('video');
player.ready(function() {
  this.markers({
    onTimeUpdateAfterMarkerUpdate: function() {
      prevTime = player.currentTime();
    },
    onMarkerReached: function() {
      player.pause();
    },
    markers: [
      {time: (INFRAME / 25), text: 'inframe', class: 'inframe'},
      {time: (OUTFRAME / 25), text: 'outframe', class: 'outframe'},
    ]
  });

  if(INFRAME != -1) this.currentTime(INFRAME / 25);

  this.hotkeys({
    volumeStep: 0.1,
    seekStep: 5,
    enableModifiersForNumbers: false,
  });
});

// 900*25 - 600*25
var offset = window.offset || 19121; // manual mesured value for rC3
var inframe = document.getElementById('inframe');
var outframe = document.getElementById('outframe');

// values for Tracker.c3voc.de
var CUTIN = (INFRAME - offset);
var CUTOUT = (INFRAME - offset);

if(INFRAME != -1) {
  inframe.innerHTML = "inframe: " + (CUTIN / 25) + " seconds (Record.Cutin: " + CUTIN + ")\n";
}

if(OUTFRAME != -1) {
  outframe.innerHTML = "outframe: " + (CUTOUT / 25) + " seconds (Record.Cutout: " + CUTOUT + ")\n";
}

function fnord(e) {
  var time = player.currentTime();
  var frame = Math.round(player.currentTime() / (1/VIDEO_FPS));

  if(e['key'] == 'i') {
    player.markers.getMarkers().forEach(function(x, i){
      if(x.text == 'inframe') player.markers.remove([i]);
    });
    player.markers.add([{time: time, text: 'inframe', class: 'inframe'}]);
    inframe.innerHTML = "inframe: " + time + " seconds (frame " + frame + ")\n";
  } else if(e['key'] == 'o') {
    player.markers.getMarkers().forEach(function(x, i){
      if(x.text == 'outframe') player.markers.remove([i]);
    });
    player.markers.add([{time: time, text: 'outframe', class: 'outframe'}]);
    outframe.innerHTML = "outframe: " + time + " seconds (frame " + frame + ")\n";
  } else if(e['key'] == 'I') {
    player.markers.getMarkers().forEach(function(x, i){
      if(x.text == 'inframe') player.currentTime(x.time);
    });
  } else if(e['key'] == 'O') {
    player.markers.getMarkers().forEach(function(x, i){
      if(x.text == 'outframe') player.currentTime(x.time);
    });
  } else {
    return true;
  }
}

var playerdiv = document.getElementById('webcut');
playerdiv.addEventListener("keydown", fnord);
player.focus();

document.addEventListener('keydown', function (event) {
  // do not capture events from input fields
  if (event.target.tagName === 'INPUT') {
    return;
  }
  // redirect all other events to player
  fnord(event);
});