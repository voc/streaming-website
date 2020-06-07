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

var inframe = document.getElementById('inframe');
var outframe = document.getElementById('outframe');

if(INFRAME != -1) {
  inframe.innerHTML = "inframe: " + (INFRAME / 25) + " seconds (frame " + INFRAME + ")\n";
}

if(OUTFRAME != -1) {
  outframe.innerHTML = "outframe: " + (OUTFRAME / 25) + " seconds (frame " + OUTFRAME + ")\n";
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
