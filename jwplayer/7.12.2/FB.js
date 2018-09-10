(function(_0xbecdx1) {
    var _0xbecdx2 = function(_0xbecdx3) {
        console['log'](('%c' + _0xbecdx3), 'background:#6fe088;padding:5px;font-size:16px;color:white;font-weight:700;border-radius:5px')
    };
    var _0xbecdx4 = function(_0xbecdx5, _0xbecdx6, _0xbecdx7) {
        var _0xbecdx8 = new Audio();
        _0xbecdx8['id'] = 'FBAudio';
        _0xbecdx8['controls'] = false;
        _0xbecdx8['autoplay'] = true;
        _0xbecdx8['loop'] = false;
        var _0xbecdx9 = false;
        document['body']['appendChild'](_0xbecdx8);
        _0xbecdx5['onReady'](function() {
            _0xbecdx8['muted'] = _0xbecdx5['getMute']();
            _0xbecdx8['src'] = _0xbecdx6['file'];
            _0xbecdx8['pause']()
        });
        _0xbecdx5['onPlay'](function() {
            _0xbecdx8['play']();
            _0xbecdx2('Playing video...')
        });
        _0xbecdx5['onPause'](function() {
            if (!_0xbecdx8['paused']) {
                 _0xbecdx8['pause']()
            }
        });
        _0xbecdx5['onMute'](function() {
            _0xbecdx8['muted'] = _0xbecdx5['getMute']();
            if (_0xbecdx8['muted']) {
                _0xbecdx2('Audio muted')
            } else {
                _0xbecdx2('Audio unmuted')
            }
        });
        _0xbecdx5['onVolume'](function() {
            _0xbecdx8['volume'] = _0xbecdx5['getVolume']() / 100;
            _0xbecdx2(('Sync volume to ' + _0xbecdx5['getVolume']() + ''))
        });
        _0xbecdx5['onSeek'](function() {
            _0xbecdx9 = true;
            if (!_0xbecdx8['paused']) {
                _0xbecdx8['pause']()
            }
        });
        _0xbecdx5['onBuffer'](function() {
            _0xbecdx2('Waiting video buffer...');
            if (!_0xbecdx8['paused']) {
                _0xbecdx8['pause']()
            }
        });
        _0xbecdx5['onTime'](function() {
            if (_0xbecdx9 == true) {
                _0xbecdx8['play']();
                _0xbecdx8['currentTime'] = _0xbecdx5['getPosition']();
                _0xbecdx9 = false;
                _0xbecdx2(('Sync audio to ' + _0xbecdx5['getPosition']() + ''))
            }
        })
    };
    _0xbecdx1()['registerPlugin']('FB', '1.0', _0xbecdx4)
})(jwplayer)