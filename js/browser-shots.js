/**
 * Browser Shots TinyMCE Integration
 */

;(function() {
	var properties = [];

	properties.push(
		{
			'type': 'textbox',
			'name': 'url',
			'label': 'Image Url',
			'value': 'http://prothemedesign.com/',
			'size': 40
		},
		{
			'type': 'textbox',
			'name': 'width',
			'label': 'Image Width',
			'value': '600',
			'size': 10
		},
		{
			'type': 'textbox',
			'name': 'height',
			'label': 'Image Height',
			'value': '450',
			'size': 10
		},
		{
			'type': 'textbox',
			'name': 'link_url',
			'label': 'Link Url',
			'value': '',
			'size': 40
		}

	);

	var shortcode_name = 'browser-shot';

	tinymce.create( 'tinymce.plugins.browsershots', {
		init: function(editor, url) {
			editor.addButton('browsershots', {
				title: 'Browser Shots',
				image: url.replace('/js', '/images') + '/browsershots-icon.png',
				onclick: function() {

					editor.windowManager.open({
                        title: 'Browser Shots',
                        body: properties,
                        onsubmit: function (e) {

							// Dialog prompt's
							var width = e.data.width;
							var height = e.data.height;
							var website = e.data.url;

							// Build shortcode tag
							if ( website != null && website != '' ) {
								var shortcode = '[' + shortcode_name + ' url="' + website + '"';
								if ( width != null && width != '' ) {
									shortcode += ' width="' + width + '"';
								} else if ( height != null && height != '' ) {
									shortcode += ' height="' + height + '"';
								}
								shortcode += ']';

								var selection = editor.selection.getContent();
								if ( selection.length ) {
									var code = shortcode + selection + '[/' + shortcode_name + ']';
									editor.selection.setContent( code );
								} else {
									editor.insertContent( shortcode );
								}
							}

                        }
                    });

				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
		getInfo: function() {
			return {
				longname: 'Browser Shots',
				author: 'Ben Gillbanks',
				authorurl: 'http://prothemedesign.com',
				infourl: 'http://wordpress.org/extend/plugins/browser-shots/',
				version: '1.3'
			};
		}
	});

	tinymce.PluginManager.add( 'browsershots', tinymce.plugins.browsershots );

})();