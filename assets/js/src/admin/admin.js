var $body = $('body'),
	$page_template_select = $('select#page_template');


$(document).ready(function() {

	/**
	 * Appends a 'template-template-slug.php' body class in 
	 * the WP admin when adding / editing a page and updates
	 * when the template is changed
	 */
	if( ( $body.hasClass('post-php') || $body.hasClass('post-new-php') ) && $page_template_select.length > 0 ) {
		var template_class = wp_admin_template_body_class( '', $page_template_select.val() );

		// Add page template body class
		$('#page_template').on('change', function() {

			template_class = wp_admin_template_body_class( template_class, $(this).val() );

		});
	}
	
});

function wp_admin_template_body_class( old_template, template ) {
	let class_name = 'template-' + template;

	$body.removeClass( old_template ).addClass( class_name );

	return class_name;
}
