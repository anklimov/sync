window.WebtorrentPlayer = class WebtorrentPlayer extends PlayerJSPlayer
    constructor: (data) ->
        if not (this instanceof WebtorrentPlayer)
            return new WebtorrentPlayer(data)
        @client = new WebTorrent()

        super(data)

    load: (data) ->
        data.meta.playerjs =
            magnet: "#{data.id}"
        super(data)
        k = `this.client.add(data.id, function (torrent) {
           var file = torrent.files.find(function (file) {
             return file.name.endsWith('.mp4') || file.name.endsWith('.m4v') || file.name.endsWith('.mkv') || file.name.endsWith('.avi')
             })

        // Stream the file in the browser
        file.renderTo('video#ytapiplayer')})`

