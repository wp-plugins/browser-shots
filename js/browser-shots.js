/**
 * TinyMCE Integration
 */
 
(function() {
	tinymce.create('tinymce.plugins.browsershots', {
		init: function(ed, url) {
			ed.addButton('browsershots', {
				title: 'Browser Shots',
				image: url.replace('/js', '/images') + '/browsershots-icon.png',
				onclick: function() {
				
					// Dialog prompt's
					var width = prompt("How wide should the screenshot be?", "600");
					var website = prompt("What's the URL of the website?", "http://www.kevinleary.net");
					
					if ( website != null && website != '' ) {
						
						// Width and website set
						if ( width != null && width != '' ) {
							var shortcode = '[browser-shot width="' + width + '" url="' + website + '"]';
							ed.execCommand( 'mceInsertContent', false, shortcode );
						}
						else {
							var shortcode = '[browser-shot url="' + website + '"]';
							ed.execCommand( 'mceInsertContent', false, shortcode );
						}
					}
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
		getInfo: function() {
			return {
				longname: "Browser Shots",
				author: 'Kevin Leary',
				authorurl: 'http://www.kevinleary.net',
				infourl: 'http://wordpress.org/extend/plugins/browser-shots/',
				version: "1.0"
			};
		}
	});
	tinymce.PluginManager.add('browsershots', tinymce.plugins.browsershots);
})();