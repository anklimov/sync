    var player = videojs(document.querySelector('video'), {
        language: 'ru',
        plugins: {
            chromecast: {}
        }
    }).toJSON();
