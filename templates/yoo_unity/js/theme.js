/* Copyright (C) YOOtheme GmbH, http://www.gnu.org/licenses/gpl.html GNU/GPL */

jQuery(function($) {

    var config = $('html').data('config') || {};

    // Social buttons
    $('article[data-permalink]').socialButtons(config);

    // Menu grid
    var listItems  = $(".tm-header .uk-navbar-nav > li");

	if ( listItems.length <= 6  || listItems.length == 10) {
		listItems.addClass('uk-width-1-' + listItems.length);
	} else {
		listItems.css('width', (100 / listItems.length) +'%')
	}

});
