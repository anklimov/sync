$("#resize-conf-larger").click(function () {
    try {
	var el=document.getElementById('cnframe');
        if(!el)  el = document.createElement("iframe");
		{
		el.id = 'cnframe';
		el.src = 'https://meet.jit.si/tube_'+CHANNEL.name;
//                el.src = 'http://tube.lazyhome.ru/apix.html';
		el.width="1024";
		el.height="512";
		el.allow="camera,microphone";
		$(confplayer).append(el);
		}
//        $(confplayer).show();
       document.getElementById('embedconfplayer').style.display = "block";
    } catch (error) {
        console.error(error);
    }
});
        
$("#resize-conf-smaller").click(function () {
    try {
//         $(confplayer).hide();
	document.getElementById('embedconfplayer').style.display = "none";
	 var el=document.getElementById('cnframe');
	 if(el) el.parentNode.removeChild(el);
    } catch (error) {
        console.error(error);
    }
});
