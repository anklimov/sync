var jitsiAPI = null;

$("#toggle-videochat").click(function () 

{
//alert("Videochat");
    try {
            var domain = "meet.jit.si";
            var userinfo = null;
            if (CLIENT.logged_in) userinfo = {
               displayName: CLIENT.name
		};
            var options = {
                roomName: "tube_"+CHANNEL.name,
           //     width: 700,
           //     height: 180,
                parentNode: embedconfplayer,
                configOverwrite: {
                   disableDeepLinking: true,    enableNoisyMicDetection: false

                },
                interfaceConfigOverwrite: {
//                    filmStripOnly: true,
                    MOBILE_APP_PROMO: false,
		    SHOW_JITSI_WATERMARK: false,
		    LANG_DETECTION: true,
//                    SHOW_BRAND_WATERMARK: true,
//                    BRAND_WATERMARK_LINK: 'https://tube.lazyhome.ru',
 TOOLBAR_BUTTONS: [
        'microphone', 
	'camera', 
//	'closedcaptions', 
	'desktop', 
	'fullscreen',
        'fodeviceselection', 
//	'hangup', 
//	'profile', 
//	'info', 
//	'chat', 
//	'recording',
//        'livestreaming', 
//	'etherpad', 
//	'sharedvideo', 
	'settings', 
//	'raisehand',
//        'videoquality', 
//	'filmstrip', 
//	'invite', 
//	'feedback', 
//	'stats', 
//	'shortcuts',
        'tileview', 
//	'videobackgroundblur', 
//	'download', 
//	'help', 
//	'mute-everyone',
        'e2ee'
	],
       SETTINGS_SECTIONS: [ 
        'devices', 
        'language', 
        'moderator' 
//        'profile', 
//        'calendar' 
	],
        OPTIMAL_BROWSERS: [ 'chrome', 'chromium', 'firefox', 'nwjs', 'electron','safari' ]
                },
                userInfo: userinfo
            }


     if (!jitsiAPI) 
	{
	   jitsiAPI = new JitsiMeetExternalAPI(domain, options);
           document.getElementById('embedconfplayer').style.display = "block";
           document.getElementById('messagebuffer').style.height=100+'px';
           document.getElementById('userlist').style.height=100+'px';
           document.getElementById('toggle-videochat').style.backgroundColor="#d6d0d061";
	     }

	  else 
	{
        document.getElementById('embedconfplayer').style.display = "none";
        jitsiAPI.dispose();
        delete jitsiAPI;
        jitsiAPI = null;
        document.getElementById('messagebuffer').style.height=400+'px';
        document.getElementById('userlist').style.height=400+'px';
        document.getElementById('toggle-videochat').style.backgroundColor="#5a585861";    
		}

    } catch (error) {
        console.error(error);
    }
});

