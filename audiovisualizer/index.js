/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/. */

// JavaScript Document
// ON LOAD

var loadUI = function() {
    document.getElementById('loading').style.display = "none";
    document.getElementById('AudioVisualizer').style.display = "block";

	try { soundsArray[36][0].removeEventListener('canplaythrough', loadUI, false); }
	catch(e) {}
	
	// lazy-load notation selector UI and images
	setTimeout(function() {
		ahah('systemSelector.html', 'selector');
		preload_images();
	}, 100)
}

// create an array of audio objects
var soundsArray = [];

function loadSounds(ext) {
	soundsArray[36] = [];
	soundsArray[36][0] = new Audio();
	
    for (var a = 0; a < 37; a++) {
		soundsArray[a] = [];
        soundsArray[a][0] = new Audio('audio-piano/' + (a + 33) + ext);
        soundsArray[a][0].load();
        soundsArray[a][0].volume = .8;
    }
	soundsArray[36][0].addEventListener('canplaythrough', loadUI, false );

}
	
// Check for audio support
var elem = document.createElement('audio');
var audioSupport = false;
try {
    if (audioSupport = !! elem.canPlayType) {
        audioSupport = new Boolean(audioSupport);
        audioSupport.ogg = elem.canPlayType('audio/ogg; codecs="vorbis"');
        audioSupport.mp3 = elem.canPlayType('audio/mpeg;');
    }
} catch (e) {}

if (audioSupport == false) {
    document.getElementById('no_HTML5_audio').style.display ="inline";
} else if (audioSupport.ogg == "probably" || audioSupport.ogg == "maybe") {
    loadSounds('.ogg')
} else if (audioSupport.mp3 == "probably" || audioSupport.mp3 == "maybe") {
    loadSounds('.mp3')
} else {
    document.getElementById('no_HTML5_audio').style.display ="inline";
}

// for lazy loading of the notation selector overlay and its thumbnail images
function ahah(url, target, delay) {
  var req;
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (req != undefined) {
    req.onreadystatechange = function() { ahahDone(req, url, target, delay); };
    req.open("GET", url, true);
    req.send("");
  }
}  

function ahahDone(req, url, target, delay) {
	if (req.readyState == 4) { // only if req is "loaded"
    if (req.status == 200) { // only if "OK"
      document.getElementById(target).innerHTML = req.responseText;
    } else {
      document.getElementById(target).innerHTML="ahah error:\n"+req.statusText;
    }
    if (delay != undefined) {
       setTimeout("ahah(url,target,delay)", delay); // resubmit after delay
	    //server should ALSO delay before responding
    }
  }
}

function arrayMultiplier(inputArray, multiply_by, add_some) {
    len = inputArray.length;
    for (i = 0; i < len; i++) {
        inputArray[i] += add_some;
        inputArray[i] *= multiply_by;
    }
    return inputArray
}

// Note Positions (vertical)
/* var standardNotePositions = [	
	133, 126, 119, 112, 105, 98, 91,
	84, 
	77, 70, 63, 56, 49, 42, 35, 28, 21, 14,  7, 
	0, 
	-7, -14, -21, -28, -36, -42, -49, -56, -63, -70, -77,
	-84,
	-91, -98, -105, -112, -119
];
*/
var standardNotePositions = [
36, 35, 34, 33, 32, 31, 30, 29, 28, 27, 26, 25, 24, 23, 22, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0];
var expressNotePositions = standardNotePositions.slice(); // express stave positions are same as standard, just with a different multiplier
arrayMultiplier(expressNotePositions, 4, -17);
arrayMultiplier(standardNotePositions, 7, -17);

var twinNoteNotePositions = [
26, 26, 25, 25, 24, 24, 23, 23, 22, 22, 21, 21, 20, 20, 19, 19, 18, 18, 17, 17, 16, 16, 15, 15, 14, 14, 13, 13, 12, 12, 11, 11, 10, 10, 9, 9, 8];
arrayMultiplier(twinNoteNotePositions, 7, -17);

var twinLineNotePositions = [
26, 26, 26, 25, 24, 24, 24, 23, 22, 22, 22, 21, 20, 20, 20, 19, 18, 18, 18, 17, 16, 16, 16, 15, 14, 14, 14, 13, 12, 12, 12, 11, 10, 10, 10, 9, 8];
arrayMultiplier(twinLineNotePositions, 7, -17);


// Note Patterns (horizontal background)
var solidNotes = [
0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var hollowNotes = [-250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250, -250];
var sixSixNotesSC = [-250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250];
var sixSixNotesHC = [
0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0, -250, 0];
var sevenFiveNotesHC = [ // C is hollow (-250)
-
250, 0, -250, 0, -250, 0, -250, -250, 0, -250, 0, -250, -250, 0, -250, 0, -250, 0, -250, -250, 0, -250, 0, -250, -250, 0, -250, 0, -250, 0, -250, -250, 0, -250, 0, -250, -250];
var sevenFiveNotesSC = [ // C is solid (0)
0, -250, 0, -250, 0, -250, 0, 0, -250, 0, -250, 0, 0, -250, 0, -250, 0, -250, 0, 0, -250, 0, -250, 0, 0, -250, 0, -250, 0, -250, 0, 0, -250, 0, -250, 0, 0];

// Horizontal adjustments to add get the right Twinline and TwinNote note shapes
var twinNoteNotes = [-700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700, -1200, -700];
var twinLineNotes = [-1700, 0, -2200, 0, -1700, 0, -2200, 0, -1700, 0, -2200, 0, -1700, 0, -2200, 0, -1700, 0, -2200, 0, -1700, 0, -2200, 0, -1700, 0, -2200, 0, -1700, 0, -2200, 0, -1700, 0, -2200, 0, -1700];



// Ledger Line Patterns
var noLedgerPattern = [
17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17, 17];
arrayMultiplier(noLedgerPattern, 7, -17);

var fiveLineLedgerPattern = [-300, -300, -250, -250, -200, -200, -150, -150, -100, -100, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -100, -100, -150, -150, -200, -200, -250, -250, -300, -300, -350, -350, -400, -400];
var fiveLineLedgerPositions = [
29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 28, 27, 26, 25, 24, 23, 22, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 7, 5, 5, 3, 3, 1, 1, -1, -1, -3, -3, -5, -5, -7, -7];
arrayMultiplier(fiveLineLedgerPositions, 7, -17);

var fourLineLedgerPattern = [-350, -350, -300, -300, -250, -250, -200, -200, -150, -150, -150, -150, 0, 0, 0, 0, 0, 0, 0, 0, 0, -100, -100, -100, 0, 0, 0, 0, 0, 0, 0, 0, 0, -100, -100, -100, -100, -150, -150, -200, -200, -250, -250, -300, -300, -350, -350, -400, -400, -450, -450, -500];
var fourLineLedgerPositions = [
27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 26, 25, 24, 23, 22, 21, 20, 19, 18, 17, 17, 17, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 5, 5, 5, 3, 3, 1, 1, -1, -1, -3, -3, -5, -5, -7, -7, -9];
arrayMultiplier(fourLineLedgerPositions, 7, -17);

var daLedgerPattern = [-300, -300, -250, -250, -200, -200, -150, -150, -100, -100, -50, -50, 0, 0, 0, 0, // DA 
0, 0, 0, 0, 0, 0, 0, 0, // DA
0, 0, 0, 0, // DA
0, 0, 0, 0, 0, 0, 0, 0, // DA
0, 0, 0, -50, -50, -100, -100, -150, -150, -200, -200, -250, -250, -300, -300, -350];
var daLedgerPositions = [
29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 28, 27, 26, 25, 24, 23, 22, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 5, 3, 3, 1, 1, -1, -1, -3, -3, -5, -5, -7, -7, -9];
arrayMultiplier(daLedgerPositions, 7, -17);

var minThirdsLedgerPattern = [-850, -850, -850, -800, -800, -800, -750, -750, -750, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, -750, -750, -750, -800, -800, -800, -850, -850, -850, -900, -900, -900, -950, -950];
var minThirdsLedgerPositions = [
30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 26, 25, 24, 23, 22, 21, 20, 19, 17, 18, 18, 18, 14, 13, 12, 11, 10, 9, 8, 7, 5, 6, 6, 6, 3, 3, 3, 0, 0, 0, -3, -3, -3, -6, -6, -6, -9, -9];
arrayMultiplier(minThirdsLedgerPositions, 7, -17);

var majThirdsThreeLedgerPattern = [-600, -600, -600, -550, -550, -550, -550, -50, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, -50, -550, -550, -550, -550, -600, -600];
var majThirdsThreeLedgerPositions = [
31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 29, 28, 27, 26, 25, 24, 23, 22, 21, 20, 19, 17, 17, 17, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 0, 0, 0, 0, -1, -1, -1, -1, -5, -5, -5, -5, -9, -9];
arrayMultiplier(majThirdsThreeLedgerPositions, 7, -17);

var majThirdsTwoLedgerPattern = [-600, -600, -600, -550, -550, -550, -550, -50, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, -50, -550, -550, -550, -550, -600, -600, -600, -600, -650, -650, -650, -650, -700, -700];
var majThirdsTwoLedgerPositions = [
31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 27, 26, 25, 24, 23, 22, 21, 20, 19, 19, 19, 19, 15, 14, 13, 12, 11, 10, 9, 8, 7, 7, 7, 7, 7, 3, 3, 3, 3, -1, -1, -1, -1, -5, -5, -5, -5, -9, -9];
arrayMultiplier(majThirdsTwoLedgerPositions, 7, -17);

var tritonesLedgerPattern = [-300, -300, -250, -250, -200, -200, -150, -150, -100, -100, -50, -50,

0, 0, 0, -50, -100, -50, 0, 0, 0, -50, -100, -50, 0, 0, 0, -50, -100, -50, 0, 0, 0, -50, -100, -50, 0, 0, 0,

-50, -50, -100, -100, -150, -150, -200, -200, -250, -250, -300];
var tritonesLedgerPositions = [
29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29,

28, 27, 26, 25, 23, 23, 22, 21, 20, 19, 17, 17, 16, 15, 14, 13, 11, 11, 10, 9, 8, 7, 5, 5, 4, 3, 2,

1, 1, -1, -1, -3, -3, -5, -5, -7, -7, -9];
arrayMultiplier(tritonesLedgerPositions, 7, -17);

var expressLedgerPattern = [-1250, -1250, -1250, -1250, -1250, -1250, -1250, -50, -50, -50, -50, -50, -50, 0, 0, 0, 0, 0, -50, 0, 0, 0, 0, 0, -50, 0, 0, 0, 0, 0, -50, -50, -50, -50, -50, -50, -50];
var expressLedgerPositions = [
27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 24, 23, 22, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 16, 9, 8, 7, 6, 3, 3, 3, 3, 3, 3];
arrayMultiplier(expressLedgerPositions, 4, -17);


var twinNoteLedgerPattern = [-150, -150, -150, -100, -100, -100, -100, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, -50, -100, -100, -100, -100, -150, -150, -150, -150, -200, -200, -200, -200, -250, -250, -250, -250];
var twinNoteLedgerPositions = [
29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 22, 22, 21, 20, 20, 20, 19, 18, 23, 23, 23, 23, 16, 16, 15, 14, 14, 14, -4, 12, 17, 17, 17, 17, 15, 15, 15, 15, 13, 13, 13, 13, 11, 11, 11, 11, 9, 9, 9, 9];
arrayMultiplier(twinNoteLedgerPositions, 7, -17);

var twinLineLedgerPattern = [-150, -150, -150, -100, -100, -100, -100, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, 0, 0, 0, 0, 0, 0, 0, 0, 0, -50, -50, -50, -50, -100, -100, -100, -100, -150, -150, -150, -150, -200, -200, -200, -200, -250, -250, -250, -250];
var twinLineLedgerPositions = [
29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 29, 22, 22, 21, 20, 20, 20, 19, 18, 23, 23, 23, 23, 16, 16, 15, 14, 14, 14, -4, 12, 0, 17, 17, 17, 17, 15, 15, 15, 15, 13, 13, 13, 13, 11, 11, 11, 11, 9];
arrayMultiplier(twinLineLedgerPositions, 7, -17);

var klavarLedgerPattern = [-1450, -1450, -1450, -1450, -1450, -150, -150, -150, -150, -150, -150, -150, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, -100, -100, -100, -100, -100, -1450, -1450, -1450, -1450, -1450, -1450, -1450, -1500];
var klavarLedgerPositions = [
30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 28, 27, 26, 25, 24, 23, 22, 21, 20, 19, 18, 17, 16, -2, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 1, 1, 1, 1, 1, -6, -6, -6, -6, -6, -6, -6, -11];
arrayMultiplier(klavarLedgerPositions, 7, -17);

var currentNotePositions = [];
var currentNotePattern = [];
var currentStaffPosition; 
var currentLedgerPatternBank = [];
var currentLedgerPattern = [];
var currentLedgerPositionsBank = [];
var currentLedgerPositions = [];
var currentBothStemSidesInterval; 

var captions = ["F<br>&nbsp;", "F#<br>Gb", "G<br>&nbsp;", "G#<br>Ab", "A<br>&nbsp;", "A#<br>Bb", "B<br>&nbsp;", "C<br>&nbsp;", "C#<br>Db", "D<br>&nbsp;", "D#<br>Eb", "E<br>&nbsp;", "F<br>&nbsp;", "F#<br>Gb", "G<br>&nbsp;", "G#<br>Ab", "A<br>&nbsp;", "A#<br>Bb", "B<br>&nbsp;", "C<br>&nbsp;", "C#<br>Db", "D<br>&nbsp;", "D#<br>Eb", "E<br>&nbsp;", "F<br>&nbsp;", "F#<br>Gb", "G<br>&nbsp;", "G#<br>Ab", "A<br>&nbsp;", "A#<br>Bb", "B<br>&nbsp;", "C<br>&nbsp;", "C#<br>Db", "D<br>&nbsp;", "D#<br>Eb", "E<br>&nbsp;", "F<br>&nbsp;"];

var noteBank = [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]; // default is chromatic scale
var i = 0;
var whatNoteMargin = null;
var noteMargins = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // default for initial chromatic scale
var currentNoteCaptions = captions.slice();
var stemFlip; // the middle position on the current staff where stems switch from up to down.

function drawNote(n, t, mrgn) { // n is the note, t is the interval, mrgn is the margin
    //draw first note
    var liTag = document.createElement("li");
    liTag.style.padding = 0;
    var s; // what note to draw
    if (t == 0 && n > stemFlip) { // single note, top half of staff, stems down.
        s = (currentNotePattern[n] - 50);
    } else if (t > 7) { // large interval, long stem
        s = (currentNotePattern[n] - 100);
    } else { // single note bottom of staff, or small interval, basic stems up
        s = currentNotePattern[n];
    }
    liTag.style.backgroundPosition = (s + "px " + currentNotePositions[n] + "px");
    document.getElementById('note_series').appendChild(liTag);

    //draw ledger lines
    var ledSpan = document.createElement("span");
    ledSpan.style.backgroundPosition = (currentLedgerPattern[n] + "px " + currentLedgerPositions[n] + "px");
    if (t == 0) {
        ledSpan.innerHTML = currentNoteCaptions[n];
    } else {
        ledSpan.style.padding = 0;
    }
    document.getElementById('note_series').lastChild.appendChild(ledSpan);

    //draw 2nd note if needed
    if (t > 0) {
        var spanTag = document.createElement("span");
        var nt = n + t;
        spanTag.style.padding = 0;
        if (t < currentBothStemSidesInterval) { // opposite stem side for small intervals
            s = (currentNotePattern[nt] - 150);
            spanTag.style.marginLeft = "15px";
        } else {
            s = currentNotePattern[nt];
        }
        spanTag.style.backgroundPosition = (s + "px " + currentNotePositions[nt] + "px");
        document.getElementById('note_series').lastChild.lastChild.appendChild(spanTag);

        // Draw 2nd note ledger lines
        var ledSpanTwo = document.createElement("span");
        ledSpanTwo.style.backgroundPosition = (currentLedgerPattern[nt] + "px " + currentLedgerPositions[nt] + "px");
        switch (t) {
        case 1:
            ledSpanTwo.innerHTML = 'Minor<br>2nd';
            break;
        case 2:
            ledSpanTwo.innerHTML = 'Major<br>2nd';
            break;
        case 3:
            ledSpanTwo.innerHTML = 'Minor<br>3rd';
            break;
        case 4:
            ledSpanTwo.innerHTML = 'Major<br>3rd';
            break;
        case 5:
            ledSpanTwo.innerHTML = 'Perfect<br>4th';
            break;
        case 6:
            ledSpanTwo.innerHTML = 'Tritone<br>&nbsp;';
            break;
        case 7:
            ledSpanTwo.innerHTML = 'Perfect<br>5th';
            break;
        case 8:
            ledSpanTwo.innerHTML = 'Minor<br>6th';
            break;
        case 9:
            ledSpanTwo.innerHTML = 'Major<br>6th';
            break;
        case 10:
            ledSpanTwo.innerHTML = 'Minor<br>7th';
            break;
        case 11:
            ledSpanTwo.innerHTML = 'Major<br>7th';
            break;
        case 12:
            ledSpanTwo.innerHTML = 'Octave<br>&nbsp;';
            break;
        }
        document.getElementById('note_series').lastChild.lastChild.lastChild.appendChild(ledSpanTwo);
    }
}

function clearStaff() {
    document.getElementById('note_series').innerHTML = "";
}

var captionsFlats = ["F<br>&nbsp;", "Gb<br>&nbsp;", "G<br>&nbsp;", "Ab<br>&nbsp;", "A<br>&nbsp;", "Bb<br>&nbsp;", "B<br>&nbsp;", "C<br>&nbsp;", "Db<br>&nbsp;", "D<br>&nbsp;", "Eb<br>&nbsp;", "E<br>&nbsp;", "F<br>&nbsp;", "Gb<br>&nbsp;", "G<br>&nbsp;", "Ab<br>&nbsp;", "A<br>&nbsp;", "Bb<br>&nbsp;", "B<br>&nbsp;", "C<br>&nbsp;", "Db<br>&nbsp;", "D<br>&nbsp;", "Eb<br>&nbsp;", "E<br>&nbsp;", "F<br>&nbsp;", "Gb<br>&nbsp;", "G<br>&nbsp;", "Ab<br>&nbsp;", "A<br>&nbsp;", "Bb<br>&nbsp;", "B<br>&nbsp;", "C<br>&nbsp;", "Db<br>&nbsp;", "D<br>&nbsp;", "Eb<br>&nbsp;", "E<br>&nbsp;", "F<br>&nbsp;"];

var captionsSharps = ["F<br>&nbsp;", "F#<br>&nbsp;", "G<br>&nbsp;", "G#<br>&nbsp;", "A<br>&nbsp;", "A#<br>&nbsp;", "B<br>&nbsp;", "C<br>&nbsp;", "C#<br>&nbsp;", "D<br>&nbsp;", "D#<br>&nbsp;", "E<br>&nbsp;", "F<br>&nbsp;", "F#<br>&nbsp;", "G<br>&nbsp;", "G#<br>&nbsp;", "A<br>&nbsp;", "A#<br>&nbsp;", "B<br>&nbsp;", "C<br>&nbsp;", "C#<br>&nbsp;", "D<br>&nbsp;", "D#<br>&nbsp;", "E<br>&nbsp;", "F<br>&nbsp;", "F#<br>&nbsp;", "G<br>&nbsp;", "G#<br>&nbsp;", "A<br>&nbsp;", "A#<br>&nbsp;", "B<br>&nbsp;", "C<br>&nbsp;", "C#<br>&nbsp;", "D<br>&nbsp;", "D#<br>&nbsp;", "E<br>&nbsp;", "F<br>&nbsp;"];

var chromaticScale = [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19];
var wholeToneScale = [7, 9, 11, 13, 15, 17, 8, 10, 12, 14, 16, 18];

var cMajorScale = [7, 9, 11, 12, 14, 16, 18, 19];
var cMinorScale = [7, 9, 10, 12, 14, 15, 17, 19];
var cBluesScale = [7, 10, 12, 13, 14, 17, 19];
// var cBluesScaleAlt = [0,2,3,5,6,9,10,12]; 

var halfSeconds = [500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 500];
var fullSeconds = [1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000];

var somewhereNotes = [18, 30, 29, 25, 27, 29, 30, 18, 27, 25, 15, 23, 22, 18, 20, 22, 23, 20, 17, 18, 20, 22, 18]; // in B
var somewhereDelays = [0, 1009, 1096, 543, 400, 352, 640, 721, 1119, 1048, 1784, 1225, 1080, 552, 391, 400, 697, 927, 785, 447, 377, 712, 760];

// Amazing Grace in A
var amazingNotes = [
4, 9, 9, 13, 11, 9, 13, 11, 9, 6, 4, 4, 9, 9, 13, 11, 9, 13, 11, 16, 16, 13, 16, 16, 13, 11, 9, 13, 11, 9, 6, 4, 4, 9, 9, 13, 11, 9, 13, 11, 9];

var amazingDelays = [0, 450, 350, 1450, 250, 250, 300, 1450, 550, 1450, 550, 1450, 450, 350, 1450, 250, 250, 300, 1450, 450, 450, 1350, 450, 400, 1400, 250, 250, 300, 1450, 550, 1450, 550, 1450, 450, 350, 1450, 250, 250, 300, 1450, 600, 1400];

var doremiNotes = [7, 9, 11, 7, 11, 7, 11, 9, 11, 12, 12, 11, 9, 12, 11, 12, 14, 11, 14, 11, 14, 12, 14, 16, 16, 14, 12, 16, 14, 7, 9, 11, 12, 14, 16, 16, 9, 11, 13, 14, 16, 18, 18, 11, 13, 15, 16, 18, 19, 18, 17, 16, 12, 18, 14, 19, 14, 11, 9, 7, 7, 9, 11, 12, 14, 16, 18, 19, 7];

var doremiDelays = [0, 750, 250, 750, 250, 500, 500, 1000, 750, 250, 250, 250, 250, 250, 2000, 750, 250, 750, 250, 500, 500, 1000, 750, 250, 250, 250, 250, 250, 2000, 750, 250, 250, 250, 250, 250, 2000, 750, 250, 250, 250, 250, 250, 2000, 750, 250, 250, 250, 250, 250, 1500, 250, 250, 500, 500, 500, 500, 500, 500, 500, 500, 1000, 250, 250, 250, 250, 250, 250, 250, 1000, 1000]; 

// Entertainer
var entertainerNotes = [
33, 35, 31, 28, 30, 26, 21, 23, 19, 16, 18, 14, 9, 11, 7, 4, 6, 4, 3, 2, 26, 9, 10, 11, 19, 11, 19, 11, 19, 31, 33, 34, 35, 31, 33, 35, 30, 33, 31, 9, 10, 11, 19, 11, 19, 11, 19, 28, 26, 25, 28, 31, 35, 33, 31, 28, 33, 9, 10, 11, 19, 11, 19, 11, 19, 31, 33, 34, 35, 31, 33, 35, 30, 33, 31];

var entertainerDelays = [0, 350, 350, 350, 700, 350, 700, 350, 350, 350, 700, 350, 700, 350, 350, 350, 700, 350, 350, 350, 1300, 1500, 350, 350, 400, 600, 400, 600, 400, 750, 350, 350, 350, 350, 350, 350, 700, 350, 600, 800, 350, 350, 400, 600, 400, 600, 400, 750, 350, 350, 350, 350, 350, 700, 350, 350, 400, 1000, 350, 350, 400, 600, 400, 600, 400, 750, 350, 350, 350, 350, 350, 350, 700, 350, 800, 800];

var swingingNotes = [23, 25, 26, 23, 21, 18, 14, 16, 18, 19, 16, 18, 14, 16, 14, 11, 14, 9, 14, 18, 21, 26, 26, 25, 26, 28, 26, 25, 21, 23, 25, 26, 23, 21, 18, 14, 16, 18, 19, 16, 18, 14, 16, 14, 11, 14, 19, 16, 18, 14, 16, 14, 11, 14, 9, 14, 14, 13, 14, 23, 25, 26, 25, 26, 28, 30, 28, 26, 25, 26, 25, 23, 21, 23, 21, 19, 18, 11, 16, 18, 19, 18, 16, 14, 11, 14, 16, 18, 19, 21, 23, 25, 26, 25, 26, 28, 30, 28, 26, 25, 26, 25, 23, 21, 23, 21, 19, 18, 19, 16, 18, 14, 16, 14, 11, 14, 9, 14, 14, 13, 14]; // in G
var swingingDelays = [0, 300, 300, 300, 300, 300, 300, 600, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 600, 600, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 600, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 600, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 600, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 600];

// Fur Elise
var eliseNotes = [23, 22, 23, 22, 23, 18, 21, 19, 16, 7, 11, 16, 18, 11, 15, 18, 19, 11, 23, 22, 23, 22, 23, 18, 21, 19, 16, 7, 11, 16, 18, 11, 19, 18, 16]

var eliseDelays = [0, 500, 500, 500, 500, 500, 500, 500, 500, 1500, 500, 500, 500, 1500, 500, 500, 500, 1500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 1500, 500, 500, 500, 1500, 500, 500, 500, 1500, 500, 500, 500, 500, ]

var currentInterval = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var sfri = false;

var delayBank = [500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 500, 500]; // default half seconds
var thisTimestamp = new Number();
var lastTimestamp = new Number();
var noteCount = 0;
var needsReset = true; // does the staff need to be cleared first or not?
var t // for playLoop timer
var playBackOn = true;
var noNotesToPlay = false;


// non-onload stuff below 
function notePlayed(n) { // when a note is played add it to noteBank and send it to draw
    thisTimestamp = Number(new Date()); // gets current time as number
    if (needsReset == true) // clears staff if playback happened since the last note was entered, otherwise LONG duration between notes
    {
        clearStaff();
        document.getElementById('notes_title').innerHTML = "Notes Played on Keyboard";
        currentNoteCaptions = captions.slice();
        drawNote(n, 0, 22);
        noteBank.length = 0;
        delayBank.length = 0;
        noteCount = 0;
        currentInterval.length = 0;
        currentInterval[0] = 0;
        noteMargins.length = 0;
        needsReset = false;
        togglePlayButton(0); // stop the playback if it is on, and reset the play button
    } else {
        drawNote(n, 0, 22);
    }
    document.getElementById('note_series').scrollLeft = 1000000;
    noteBank[noteCount] = n;
    delayBank[noteCount] = (thisTimestamp - lastTimestamp);
    currentInterval[noteCount] = 0;
    noteCount += 1;
    lastTimestamp = thisTimestamp;
}


function loadNoteSeries(whatNoteSeries, whatOffset, whatCaptions, whatTitle, whatInterval) {

    togglePlayButton(0); // stop any playback, and reset the play button
    clearStaff();

    // Defaults, may be reversed below
    currentInterval = Array(0);
    noteMargins.length = 0;
    whatNoteMargin = null;
    document.getElementById('notes_title').innerHTML = whatTitle;

    switch (whatCaptions) {
    case 0:
        currentNoteCaptions = captionsFlats.slice();
        break; // flats
    case 1:
        currentNoteCaptions = captionsSharps.slice();
        break; // sharps
    case 2:
        currentNoteCaptions = captions.slice(); // both
    }

    switch (whatNoteSeries) {

    case 0:
        // chromatic scale
        noteBank = chromaticScale.slice();
        delayBank = halfSeconds.slice();
        whatNoteMargin = 0;
        break;

    case 1:
        // whole tone scales
        noteBank = wholeToneScale.slice();
        delayBank = halfSeconds.slice();
        whatNoteMargin = 0;
        break;

    case 2:
        // major scale
        noteBank = cMajorScale.slice();
        delayBank = halfSeconds.slice();
        whatNoteMargin = 35;
        break;

    case 3:
        // minor scale
        noteBank = cMinorScale.slice();
        delayBank = halfSeconds.slice();
        whatNoteMargin = 35;
        break;

    case 4:
        // blues scale
        noteBank = cBluesScale.slice();
        delayBank = halfSeconds.slice();
        whatNoteMargin = 35;
        break;

    case 5:
        // somewhere over the rainbow
        noteBank = somewhereNotes.slice();
        delayBank = somewhereDelays.slice();
        break;

    case 6:
        // do re mi 
        noteBank = doremiNotes.slice();
        delayBank = doremiDelays.slice();
        break;

    case 7:
        // swingin on a gate
        noteBank = swingingNotes.slice();
        delayBank = swingingDelays.slice();
        break;

    case 8:
        // the entertainer
        noteBank = entertainerNotes.slice();
        delayBank = entertainerDelays.slice();
        break;

    case 9:
        // fur elise
        noteBank = eliseNotes.slice();
        delayBank = eliseDelays.slice();
        break;

    case 10:
        // amazing grace
        noteBank = amazingNotes.slice();
        delayBank = amazingDelays.slice();
        break;
    };

    var len = noteBank.length;

    if (whatOffset > 0) { // for changing the key of the scale
        for (i = 0; i < len; i++) {
            noteBank[i] = (noteBank[i] + whatOffset);
        }
    }

    if (whatInterval > 0) { // set delay for all intervals
        delayBank = fullSeconds.slice();
    }

    if (whatInterval < 13) { // for no interval (0) or whole tone scale intervals
        for (i = 0; i < len; i++) {
            currentInterval[i] = whatInterval;
        }
    } else { // diatonic intervals
        switch (whatInterval) {
        case 20:
            currentInterval = Array(2, 2, 1, 2, 2, 2, 1, 2, 2, 1, 2, 2, 2, 1);
            break;
        case 30:
            currentInterval = Array(4, 3, 3, 4, 4, 3, 3, 4, 3, 3, 4, 4, 3, 3);
            break;
        case 40:
            currentInterval = Array(5, 5, 5, 6, 5, 5, 5, 5, 5, 5, 6, 5, 5, 5);
            break;
        case 50:
            currentInterval = Array(7, 7, 7, 7, 7, 7, 6, 7, 7, 7, 7, 7, 7, 6);
            break;
        case 60:
            currentInterval = Array(9, 9, 8, 9, 9, 8, 8, 9, 9, 8, 9, 9, 8, 8);
            break;
        case 70:
            currentInterval = Array(11, 10, 10, 11, 10, 10, 10, 11, 10, 10, 11, 10, 10, 10);
            break;
        case 80:
            currentInterval = Array(12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12);
            break;
        }

        if (whatNoteSeries == 3) { // minor scale, so shift diatonic pattern 5 positions left 
            for (i = 0; i < len; i++) {
                currentInterval[i] = currentInterval[i + 5]
            };
        }
    }

    if (whatNoteMargin !== null) { // set margins
        for (i = 0; i < len; i++) {
            noteMargins[i] = whatNoteMargin;
        }
    }

    if (sfri == false) {
        drawNoteSeries()
    } else {
        t = setTimeout('drawNoteSeries()', 1)
    } // if Safari tiny delay to fix visual glitches
}

function drawNoteSeries() {
    needsReset = true;
    len = noteBank.length;
    for (i = 0; i < len; i++) {
        drawNote(noteBank[i], currentInterval[i], noteMargins[i]);
    }
    i = 0;
    document.getElementById('note_series').scrollLeft = 0;
    // alert(document.getElementById('note_series').innerHTML);  // use this to get the HTML for initial page load.
}


function playback() { // clears the staff before playing back
    // alert(noteBank); // for constructing melodies
    if (noteBank.length > 0) // then there are notes to play
    {
        togglePlayButton(1); // allows playback, and toggles the play button to "stop playback"
        i = 0;
        needsReset = true;
        clearStaff();
        if (currentInterval[i] == 0) {
            playLoop();
        } else {
            playLoopIntervals();
        }
    } else if (noNotesToPlay == true) {
        alert("There are no notes to play.  Enter some notes and try again.");
    } else {
        noNotesToPlay = true
    }
}

function playLoop() { // using if statement & recursion
    if (playBackOn == true) // quits the loop if this variable is made false by another script
    {
        playSound(noteBank[i]);
        drawNote(noteBank[i], currentInterval[i], noteMargins[i]);
        document.getElementById('note_series').scrollLeft = 1000000;
        i++;
        if (i < noteBank.length) { // is there another note to play? then delay and repeat the playLoop function
            t = setTimeout('playLoop()', delayBank[i]);
        } else { // reached the end of the series so reset
            i = 0;
            togglePlayButton(0); // stop any playback, and reset the play button
        }
    }
}


function playLoopIntervals() { // using if statement & recursion...
    if (playBackOn == true) // quits the loop if this variable is made false by another script
    {
        playSound(noteBank[i]);
        playSound(noteBank[i] + currentInterval[i]);
        drawNote(noteBank[i], currentInterval[i], noteMargins[i]);
        document.getElementById('note_series').scrollLeft = 1000000;
        i++;
        if (i < noteBank.length) { // is there another note to play? then delay and repeat the playLoop function
            t = setTimeout('playLoopIntervals()', delayBank[i]);
        } else { // reached the end of the series so reset
            i = 0;
            togglePlayButton(0); // stop any playback, and reset the play button
        }
    }
}


// IE8 chokes on the audio tag functions, and doesn't process the rest of this <script> tag, so moved to end so that it will execute onload functions 

function stopPlayback() {
    togglePlayButton(0); // stops any playback, and resets the play button
    clearStaff();
    drawNoteSeries(); // re-load the notes on the staff
}

function togglePlayButton(pl) {
    switch (pl) {
    case 0:
        playBackOn = false;
        document.getElementById('playButton').innerHTML = "<a href=\"javascript:\" onclick=\"playback()\" class=\"controlbutton\">Play Audio</a>";
        break;
    case 1:
        playBackOn = true;
        document.getElementById('playButton').innerHTML = "<a href=\"javascript:\" onclick=\"stopPlayback()\" class=\"controlbutton\">Stop Audio</a>";
        break;
    }
}


// OTHER UI 
function resetAll() {
    clearStaff();
    noteBank = [];
    delayBank = [];
    noteCount = 0;
    togglePlayButton(0); // stop the playback if it is on, and reset the play button
    document.getElementById('notes_title').innerHTML = "&nbsp;";
}

function uiToggler(t, k) {
    document.getElementById('scalesbuttons').style.display = "none";
    document.getElementById('intervalsbuttons').style.display = "none";
    document.getElementById('keyboard_div').style.display = "none";
    document.getElementById('melodiesbuttons').style.display = "none";
    switch (t) {
    case "scales":
        document.getElementById('scalesbuttons').style.display = "block";
        break;
    case "intervals":
        document.getElementById('intervalsbuttons').style.display = "block";
        break;
    case "melodies":
        document.getElementById('melodiesbuttons').style.display = "block";
        break;
    case "keyboards":
        document.getElementById('keyboard_div').style.display = "block";
        instrument_toggle(k);
        break;
    }
}


function instrument_toggle (whatKeys) {
	switch(whatKeys)
	{
	case 0: // Instrument layouts...
		document.getElementById('about66').style.display = 'none';	
		break;
	case 1: // Piano
		document.getElementById('keys_1row').style.display = 'none';
		document.getElementById('keys_sixsix').style.display = 'none';
		document.getElementById('keys_piano').style.display = 'block';	
		break;
	case 2: // String
		document.getElementById('keys_sixsix').style.display = 'none';
		document.getElementById('keys_piano').style.display = 'none';	
		document.getElementById('keys_1row').style.display = 'block';
		break;
	case 3: // 6-6
		document.getElementById('keys_1row').style.display = 'none';
		document.getElementById('keys_piano').style.display = 'none';	
		document.getElementById('keys_sixsix').style.display = 'block';	
		break;
	}
}

// for JS drop-down menus
var timeout = 250;
var closetimer = 0;
var ddmenuitem = 0;

// open hidden layer
function mopen(id) {
    // cancel close timer
    mcancelclosetime();

    // close old layer
    if (ddmenuitem) ddmenuitem.style.visibility = 'hidden';

    // get new layer and show it
    ddmenuitem = document.getElementById(id);
    ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose() {
    if (ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime() {
    closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime() {
    if (closetimer) {
        window.clearTimeout(closetimer);
        closetimer = null;
    }
}

// close layer when click-out
<!-- document.onclick = mclose; -->



// Notation controls
var currentNoteShape = "oval"
var twinAdjust = 0;
var lineName = new Array('F', 'F# / Gb', 'G', 'G# / Ab', 'A', 'A# / Bb', 'B', 'C', 'C# / Db', 'D', 'D# / Eb', 'E', 'F');
var inverter = new Array(0, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1);
var currentStaffLevel = new Number(9);


function setNotation(staffPattern, notePattern, staffPosition) {

    if (staffPosition != 'x') {
        staffPosition *= 1; // multiplying by one converts URL query string to a number
        currentStaffLevel = staffPosition;
    }

    switch (staffPattern) { // set staff pattern, numbers are [# of lines] . [semitones between them] (largest semitones used in description)
    case 'x':
        // for just changing note pattern
        break;
    case '5.2':
        // 5-line
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-fiveline.png)";
        currentLedgerPatternBank = fiveLineLedgerPattern.slice();
        currentLedgerPositionsBank = fiveLineLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval";
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "5 Lines per Octave, a Whole Step Apart";
        break;
    case '4.2':
        // 4-line Ailler   (Untitled by Johann Ailler)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-fourline.png)";
        currentLedgerPatternBank = fourLineLedgerPattern.slice();
        currentLedgerPositionsBank = fourLineLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval";
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "4 Lines per Octave, a Whole Step Apart";
        break;
    case '6.2':
        // six lines  (Untitled by Klaus Lieber)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-lieber.png)";
        currentLedgerPatternBank = fiveLineLedgerPattern.slice();
        currentLedgerPositionsBank = fiveLineLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval";
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "6 Lines per Octave, a Whole Step Apart";
        break;
    case '4.4':
        // DA Rich Reed	  (DA Notation by Rich Reed)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-da.png)";
        currentLedgerPatternBank = daLedgerPattern.slice();
        currentLedgerPositionsBank = daLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval";
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "4 Lines per Octave, a Whole Step and Major 3rd Apart";
        break;
    case '3.3':
        // Numbered notes    (Numbered Notes, Notes-Only Version by Jason MacCoy)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-maccoy.png)";
        currentLedgerPatternBank = minThirdsLedgerPattern.slice();
        currentLedgerPositionsBank = minThirdsLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval";
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "3 Lines per Octave, a Minor 3rd Apart";
        break;
    case '3.4':
        // Pot & Schoenberg style    (6-6 Klavar by Cornelis Pot)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-pot.png)";
        document.getElementById('notecontainer').style.backgroundPosition = '0px -56px';
        currentLedgerPatternBank = majThirdsThreeLedgerPattern.slice();
        currentLedgerPositionsBank = majThirdsThreeLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval";
        stemFlip = 19;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "3 Lines per Octave, a Major 3rd Apart";
        break;
    case '2.4.0':
        // Beyreuther Untitled  (Untitled by Johannes Beyreuther)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-majthirds2lines.png)";
        currentLedgerPatternBank = majThirdsTwoLedgerPattern.slice();
        currentLedgerPositionsBank = majThirdsTwoLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval";
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "2 Lines per Octave, a Major 3rd Apart";
        break;
    case '2.4.1':
        // TwinLine   (Twinline by Thomas Reed)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-twin.png)";
        //document.getElementById('notecontainer').style.backgroundPosition = '0px -105px';
        twinAdjust = 70;
        currentLedgerPatternBank = twinLineLedgerPattern.slice();
        currentLedgerPositionsBank = twinLineLedgerPositions.slice();
        currentNotePositions = twinLineNotePositions;
        currentNoteShape = "twinline";
        stemFlip = 18;
        currentBothStemSidesInterval = 4;
        document.getElementById('system_title').innerHTML = "2 Lines per Octave, a Major Third Apart, Compact Staff";
        break;
    case '2.4.2':
        // TwinNote   (TwinNote by Paul Morris)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-twin.png)";
        twinAdjust = 63;
        currentLedgerPatternBank = twinNoteLedgerPattern.slice();
        currentLedgerPositionsBank = twinNoteLedgerPositions.slice();
        currentNotePositions = twinNoteNotePositions;
        currentNoteShape = "twinnote";
        stemFlip = 18;
        currentBothStemSidesInterval = 4;
        document.getElementById('system_title').innerHTML = "2 Lines per Octave, a Major Third Apart, Compact Staff";
        break;
    case '2.6':
        // MUTO   (MUTO by MUTO Music Method Foundation)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-muto.png)";
        currentLedgerPatternBank = tritonesLedgerPattern.slice();
        currentLedgerPositionsBank = tritonesLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval";
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "2 Lines per Octave, a Tritone Apart";
        break;
    case '2.6.1':
        // Express Stave 4px spacing
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-express.png)";
        currentLedgerPatternBank = expressLedgerPattern.slice();
        currentLedgerPositionsBank = expressLedgerPositions.slice();
        currentNotePositions = expressNotePositions;
        currentNoteShape = "oval"
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "2 Lines per Octave, a Tritone Apart, Compact Staff";
        break;
    case '5.3':
        // Klavar  (Klavar, Mirck Version by Jean de Buur)
        document.getElementById('notecontainer').style.backgroundImage = "url(images/staff-klavar.png)";
        currentLedgerPatternBank = klavarLedgerPattern.slice();
        currentLedgerPositionsBank = klavarLedgerPositions.slice();
        currentNotePositions = standardNotePositions;
        currentNoteShape = "oval"
        stemFlip = 18;
        currentBothStemSidesInterval = 2;
        document.getElementById('system_title').innerHTML = "7-5 Line Pattern";
        break;
    }

    if (notePattern != 'x') {
        switch (notePattern) { // set note pattern
            //case 'x':  break;
        case '0':
            currentNotePattern = hollowNotes.slice();
            document.getElementById('notehead_title').innerHTML = "All Hollow Noteheads";
            break;
        case '1':
            currentNotePattern = solidNotes.slice();
            document.getElementById('notehead_title').innerHTML = "All Solid Noteheads";
            break;
        case '66.0':
            currentNotePattern = sixSixNotesHC.slice();
            document.getElementById('notehead_title').innerHTML = "6-6 Noteheads (C is Hollow)";
            break;
        case '66.1':
            currentNotePattern = sixSixNotesSC.slice();
            document.getElementById('notehead_title').innerHTML = "6-6 Noteheads (C is Solid)";
            break;
        case '75.0':
            currentNotePattern = sevenFiveNotesHC.slice();
            document.getElementById('notehead_title').innerHTML = "7-5 Noteheads (C is Hollow)";
            break;
        case '75.1':
            currentNotePattern = sevenFiveNotesSC.slice();
            document.getElementById('notehead_title').innerHTML = "7-5 Noteheads (C is Solid)";
            break;
        }

        switch (currentNoteShape) { // For Twinline and TwinNote, change the note shape
        case "oval":
            break;
        case "twinnote":
            for (i = 0; i < 37; i++) {
                currentNotePattern[i] = (currentNotePattern[i] + twinNoteNotes[i]);
            }
            break;
        case "twinline":
            for (i = 0; i < 37; i++) {
                currentNotePattern[i] = (currentNotePattern[i] + twinLineNotes[i]);
            }
            break;
        }
    }

    if (staffPosition != 'x') {
        //move staff:
        currentStaffPosition = currentNotePositions[staffPosition + 19]; // converts 0-11 into a vertical pixel number, was: currentStaffPosition = staffPosition * -7;
        if (currentNoteShape == "twinnote" || currentNoteShape == "twinline") { // twin staves need extra
            currentStaffPosition -= twinAdjust;
        }
        document.getElementById('notecontainer').style.backgroundPosition = ('0 ' + currentStaffPosition + 'px');

        //get the relevant 3 octaves of ledgers out of 4 defined:
        currentLedgerPattern = currentLedgerPatternBank.slice(inverter[staffPosition]);
        currentLedgerPositions = currentLedgerPositionsBank.slice(inverter[staffPosition]);

        //shift those ledger positions to match staff:
        len = currentLedgerPositions.length;
        adj = currentStaffPosition + 63;
        for (i = 0; i < len; i++) { 
            currentLedgerPositions[i] += adj;
        }
    }


    if (overlayon == true) {
        clicker();
    }
    togglePlayButton(0); // stop any playback, and reset the play button
    clearStaff();
    drawNoteSeries();
}


function shiftStaff(howMuch) {
    if (currentNoteShape == "twinnote") {
        howMuch *= 2
    };
    if (currentNoteShape == "twinline") {
        howMuch *= 4
    };
    currentStaffLevel += howMuch;
    if (currentStaffLevel > 12) {
        currentStaffLevel -= howMuch;
    } else if (currentStaffLevel < 1) {
        currentStaffLevel -= howMuch;
    }
    else {
        stemFlip += howMuch;
        setNotation('x', 'x', currentStaffLevel);
    }
}
var overlayon = false;

function clicker() { // for lightbox notation selector overlay
    var thediv = document.getElementById('displaybox');
    var innerdiv = document.getElementById('selector');
    if (overlayon == false) {
        overlayon = true;
        thediv.style.display = "block";
        innerdiv.style.display = "block";
        document.body.style.overflowY = 'hidden';
    } else {
        overlayon = false;
        thediv.style.display = "none";
        innerdiv.style.display = "none";
        document.body.style.overflowY = 'visible';
    }
    return false;
}


// Playing the audio
var ch = 0; // which audio "channel" -- 0, 1, or 2.
var prevNote = null; // stores the last note played (its array number)

function playSound(s) {
	if (audioSupport == true) { // for IE8
	    if (s != prevNote) { 
			ch = 0;
			prevNote = s;
		}
	
		try { soundsArray[s][ch].currentTime = 0; }  // for IE9
		catch(e){
			ch = 0; 
			soundsArray[s][ch].currentTime = 0;
		}
	
		soundsArray[s][ch].play(); 
			
		ch++;
		if (ch >= 3) {
			ch = 0;
		}
		if (soundsArray[s][ch] == null ) {
			soundsArray[s][ch] = soundsArray[s][0].cloneNode(true);
			soundsArray[s][ch].load();
			soundsArray[s][ch].volume = .8;
		}
	}
}

// loads a random notation system
function setRandomNotation() {
    var r = Math.floor(Math.random() * 23)
    switch (r) {
    case 0:
        setNotation('5.2', '0', 9);
        break;
    case 1:
        setNotation('4.2', '0', 11);
        break;
    case 2:
        setNotation('6.2', '0', 7);
        break;
    case 3:
        setNotation('4.4', '66.1', 9);
        break;
    case 4:
        setNotation('3.3', '0', 11);
        break;
    case 5:
        setNotation('3.4', '66.0', 8);
        break;
    case 6:
        setNotation('2.4.0', '66.1', 11);
        break;
    case 7:
        setNotation('2.4.1', '0', 11);
        break;
    case 8:
        setNotation('2.4.2', '66.0', 11);
        break;
    case 9:
        setNotation('2.6', '0', 7);
        break;
    case 10:
        setNotation('5.3', '75.0', 8);
        break;
    case 11:
        setNotation('5.2', '0', 11);
        break;
    case 12:
        setNotation('4.2', '0', 12);
        break;
    case 13:
        setNotation('4.2', '0', 1);
        break;
    case 14:
        setNotation('6.2', '0', 4);
        break;
    case 15:
        setNotation('4.4', '66.1', 7);
        break;
    case 16:
        setNotation('2.4.0', '1', 11);
        break;
    case 17:
        setNotation('2.4.0', '66.1', 11);
        break;
    case 18:
        setNotation('2.4.0', '66.0', 11);
        break;
    case 19:
        setNotation('2.4.1', '66.0', 11);
        break;
    case 20:
        setNotation('2.4.1', '66.1', 11);
        break;
    case 21:
        setNotation('2.4.1', '66.1', 11);
        break;
    case 22:
        setNotation('2.4.2', '0', 11);
        break;
    }
}
setRandomNotation();
loadNoteSeries(0, 0, 2, 'Chromatic Scale', 0);


function preload_images() {
    if (document.images) // Preload staff background images
    {
        var preload_image = [];
        var img_path = [];
        img_path[0] = "images/notes6.png";
        img_path[1] = "images/staff-fiveline.png";
        img_path[2] = "images/staff-fourline.png";
        img_path[3] = "images/staff-lieber.png";
        img_path[4] = "images/staff-da.png";
        img_path[5] = "images/staff-maccoy.png";
        img_path[6] = "images/staff-pot.png";
        img_path[7] = "images/staff-majthirds2lines.png";
        img_path[8] = "images/staff-twin.png";
        img_path[9] = "images/staff-muto.png";
        img_path[10] = "images/staff-klavar.png";
        img_path_length = img_path.length - 1;

        for (var i = 0; i <= img_path_length; i++) {
            preload_image[i] = new Image();
            preload_image[i].src = img_path[i];
        }
    }
}

if (audioSupport == false) {
    loadUI();
}

// IE8 chokes on this, so putting it here.
try {
	if (navigator.vendor.indexOf("Apple") !== -1) {
	    sfri = true;
	} // detect Safari browser, ugh.
}
catch(e) {
}
