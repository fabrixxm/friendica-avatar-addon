Avatar Server
==========

libravatar server plugin for friendica.


To be usable from libravatar libraries, you should also read
[DNS Setup](http://wiki.libravatar.org/running_your_own/) 
section on libravatar 'Running your own' wiki page.

This plugin follow api from http://wiki.libravatar.org/api/

Size (s) parameter will return the photo with the width nearest to
the size requested already in db. 

Default (d) parameter can be an url to a photo.
If you pass as value one of mm, identicon, 
monsterid, wavatar, retro (or nothing), you always get 
friendica's rainbow man.

If plugin fallback to default, it will ignore size parameter.
