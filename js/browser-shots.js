/**
 * Browser Shots TinyMCE Integration
 */

;(function() {
	var properties = [];
	var shortcode_name = 'browser-shot';
	var selection = '';

	properties.push(
		{
			'type': 'textbox',
			'name': 'url',
			'label': 'Image Url',
			'value': 'http://',
			'size': 40
		},
		{
			'type': 'textbox',
			'name': 'href',
			'label': 'Image Link Url (optional)',
			'value': '',
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
			'name': 'caption',
			'label': 'Image Caption',
			'value': '',
			'size': 40
		},
		{
			'type': 'textbox',
			'name': 'alt',
			'label': 'Image ALT text',
			'value': '',
			'size': 40
		},
		{
			'type': 'checkbox',
			'name': 'target',
			'label': 'Open Link in new Window?',
		}
	);

	tinymce.create( 'tinymce.plugins.browsershots', {
		init: function(editor, url) {
			editor.addButton('browsershots', {
				title: 'Browser Shots',
				image: url.replace('/js', '/images') + '/browsershots-icon.png',
				onclick: function() {

					selection = editor.selection.getContent();

					properties[4].value = selection;

					editor.windowManager.open({
                        title: 'Browser Shots',
                        body: properties,
                        onsubmit: function (e) {

							// Dialog prompt's
							var width = e.data.width;
							var height = e.data.height;
							var website = e.data.url;
							var link = e.data.href;
							var caption = e.data.caption;
							var alt = e.data.alt;
							var target = e.data.target;

							// Build shortcode tag
							if ( website != null && website != '' ) {
								var shortcode = '[' + shortcode_name + ' url="' + website + '"';
								if ( width != null && width != '' ) {
									shortcode += ' width="' + width + '"';
								}
								if ( height != null && height != '' ) {
									shortcode += ' height="' + height + '"';
								}
								if ( link != null && link != '' ) {
									shortcode += ' href="' + link + '"';
								}
								if ( alt != null && alt != '' ) {
									shortcode += ' alt="' + link + '"';
								}
								if ( true == target ) {
									shortcode += ' target="_blank"';
								}

								shortcode += ']';

								if ( caption != null && caption != '' ) {
									shortcode += caption + '[/' + shortcode_name + ']';
								}

								if ( selection.length ) {
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
		createControl: function() {
			return null;
		},
		getInfo: function() {
			return {
				longname: 'Browser Shots',
				author: 'Ben Gillbanks',
				authorurl: 'http://prothemedesign.com',
				infourl: 'http://wordpress.org/extend/plugins/browser-shots/',
				version: '1.3.1'
			};
		}
	});

	tinymce.PluginManager.add( 'browsershots', tinymce.plugins.browsershots );

})();