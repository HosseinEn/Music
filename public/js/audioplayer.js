String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    var output;
    if(hours != 0) {
        output = hours + ':' + minutes + ':' + seconds
    }
    else {
        output = minutes + ':' + seconds
    }
    return output;
}

var audioId = document.getElementById("songPlayer");
var seekbar = document.getElementById("seekbar");
var playButton = document.getElementById("buttonCircle");
var InsideCircle = document.getElementById("inside-circle");
audioId.onloadedmetadata = function () {
    time = audioId.duration;

    var musicDuration = time;
    var TimeShown = document.getElementById("TimeShown");
    var animationElement = document.getElementsByClassName("animationEffect");
    const musicColor = "red";
    const musicTimeMin = musicDuration;
    const musicTime = musicTimeMin;
    TimeShown.innerHTML = musicDuration.toString().toHHMMSS();
    InsideCircle.addEventListener("mouseover", displayButton);
    InsideCircle.addEventListener("mouseleave", hideButton);
    document.documentElement.style.setProperty("--musicColor", musicColor);
    document.documentElement.style.setProperty("--musicTime", musicTime + 's');
    function displayButton() {
        playButton.style.opacity = 1;
    }
    function hideButton() {
        playButton.style.opacity = 0;
    }
    $('#play-pause-button').on("click", function () {
        for (var i = 0; i < animationElement.length; i++) {
            animationElement[i].style.webkitAnimation = '';
        }
        if ($(this).hasClass('fa-play')) {
            $(this).removeClass('fa-play');
            $(this).addClass('fa-pause');
            audioId.play();
        }
        else {
            $(this).removeClass('fa-pause');
            $(this).addClass('fa-play');
            audioId.pause();
        }
    });

    audioId.onended = function () {
        $("#play-pause-button").removeClass('fa-pause');
        $("#play-pause-button").addClass('fa-play');
        for (var i = 0; i < animationElement.length; i++) {
            animationElement[i].classList.toggle("running");
            animationElement[i].style.webkitAnimation = 'none';
        }

    };






    // Set max value when you know the duration
    seekbar.max = time;
    // update audio position
    seekbar.onchange = () => audioId.currentTime = seekbar.value;
    // update range input when currentTime updates
    audioId.ontimeupdate = function () {
        seekbar.value = audioId.currentTime;
        var timeToDeg = (audioId.currentTime / Math.floor(time)) * 180;
        var currentTimeShown = document.getElementById("currentTimeShown");
        currentTimeShown.innerHTML = audioId.currentTime.toString().toHHMMSS()
        document.documentElement.style.setProperty("--circleRotate", Math.floor(timeToDeg) + 'deg');
    };
};
function getCurTime() {
    alert(audioId.currentTime);
}

