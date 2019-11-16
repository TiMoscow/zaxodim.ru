/**
 * @package    JJ_Shoutbox
 * @copyright  Copyright (C) 2011 - 2018 JoomJunk. All rights reserved.
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

var JJShoutbox = JJShoutbox || {};


/**
 * Ask access for HTML5 Notifications
 */
JJShoutbox.performNotificationCheck = function()
{
	// Let's check if the browser supports notifications
	if (!('Notification' in window)) 
	{
		// Browser does not support Notifications. Abort
		return;
	}

	Notification.requestPermission(function(permission) {
	});
}


/**
 * Create the HTML5 Notification
 */
JJShoutbox.createNotification = function(title)
{
	var icon = '/media/mod_shoutbox/images/notification.png';

	if (typeof JJ_notification !== 'undefined')
	{
		icon = JJ_notification
	}

	var options = {
		icon: icon
	};

	// Let's check if the browser supports notifications
	if (!('Notification' in window))
	{
		// Browser does not support Notifications. Abort
		return;
	}

	if (Notification.permission === 'granted')
	{
		var notification = new Notification(title, options);
	}
	else if (Notification.permission !== 'denied')
	{
		Notification.requestPermission(function(permission) {
			// If the user accepts, let's create a notification
			if (permission === 'granted') 
			{
				var notification = new Notification(title, options);
			}
		});
	}
}


/**
 * Adds a smiley to the textarea
 */
JJShoutbox.addSmiley = function(smiley, id)
{
	// Get the text area object
	var el = document.getElementById(id);

	// Define ID is not already defined
	if (!el)
	{
		var el = 'jj_message';
	}

	// IE Support
	if (document.selection)
	{
		el.focus();
		var Sel = document.selection.createRange();
		var SelLength = document.selection.createRange().text.length;
		Sel.moveStart ('character', -el.value.length);
		pos = Sel.text.length - SelLength;
	}
	// Firefox support
	else if (el.selectionStart || el.selectionStart == '0')
	{
		pos = el.selectionStart;
	}

	var strBegin = el.value.substring(0, pos);
	var strEnd   = el.value.substring(pos);

	// Piece the text back together with the cursor in the midle
	el.value = strBegin + ' ' + smiley + ' ' + strEnd;
}


/**
 * Inserts the BBCode selected to the textarea
 */
JJShoutbox.insertBBCode = function(tag, tag2, data)
{
	var val, startPos, endPos;
	var range = data.range;
	var text  = '';

	if (range != null)
	{
		text = range.text;
	}
	else if (typeof data.selectionStart != 'undefined')
	{
		startPos = data.selectionStart;
		endPos   = data.selectionEnd;
		text     = data.value.substring(startPos, endPos);
	}

	// Define the tags and text
	val = tag + text + tag2;

	if (range != null)
	{
		range.text = val;

		if (data.highlight)
		{
			range.moveStart('character', -val.length);
		}
		else
		{
			range.moveStart('character', 0);
		}

		range.select();
	}
	else if (typeof data.selectionStart != 'undefined')
	{
		data.value = data.value.substring(0, startPos) + val + data.value.substr(endPos);

		if (data.highlight)
		{
			data.selectionStart = startPos;
			data.selectionEnd   = startPos + val.length;
		}
		else
		{
			data.selectionStart = startPos + val.length;
			data.selectionEnd   = startPos + val.length;
		}
	}
	else
	{
		data.value += val;
	}

	data.focus();

	// If the there's no text inbetween the tags, insert the cursor there
	if (text == '')
	{
		var cursorpos = startPos + val.length - tag2.length;
		data.setSelectionRange(cursorpos, cursorpos);
	}
}


/**
 * Changes the text counter colour based on the max, alert and warning limits
 */
JJShoutbox.textCounter = function(textarea, countdown, maxlimit, alertLength, warnLength, shoutRemainingText)
{
	var textareaid = document.getElementById(textarea);
	var charsLeft  = document.getElementById('charsLeft');

	if (textareaid.value.length > maxlimit)
	{
		textareaid.value = textareaid.value.substring(0, maxlimit);
	}
	else
	{
		charsLeft.innerHTML = (maxlimit-textareaid.value.length) + ' ' + shoutRemainingText;
	}

	if (maxlimit-textareaid.value.length > alertLength)
	{
		charsLeft.style.color = 'Black';
	}
	if (maxlimit-textareaid.value.length <= alertLength && maxlimit-textareaid.value.length > warnLength)
	{
		charsLeft.style.color = 'Orange';
	}
	if (maxlimit-textareaid.value.length <= warnLength)
	{
		charsLeft.style.color = 'Red';
	}
}


/**
 * Returns a random integer number between min (inclusive) and max (exclusive)
 */
JJShoutbox.getRandomArbitrary = function(min, max)
{
	var random = 0;
    random = Math.random() * (max - min) + min;

	return parseInt(random);
}


/**
 * Draw the maths question using a canvas
 */
JJShoutbox.drawMathsQuestion = function(number1, number2, rtl)
{
	var c   = document.getElementById('mathscanvas'),
	    ctx = c.getContext('2d');

	ctx.clearRect(0, 0, c.width, c.height);
	ctx.font = '14px Arial';
	ctx.fillStyle = 'grey';

	if (rtl == 1)
	{
		ctx.fillText(parseInt(number1) + ' + ' + parseInt(number2) + ' = ', 70, 20);
	}
	else
	{
		ctx.fillText(number1 + ' + ' + number2 + ' = ', 10, 20);
	}
}


/**
 * Returns the last ID of the shoutbox output
 */
JJShoutbox.getLastID = function(instance)
{
	var lastId = instance.find('.shout-header:first-child').data('shout-id');

	return lastId;
}


/**
 * Returns the author of the last shout
 */
JJShoutbox.getLastAuthor = function(instance)
{
	var lastauthor = instance.find('.shout-header:first-child').data('shout-name');

	return lastauthor;
}


/**
 * Check if the name or message fields are empty
 *
 * TODO: Make this the general error handling function and improve it
 */
JJShoutbox.showError = function(msg, instance)
{
	if (JJ_frameworkType === 'uikit')
	{
		var alertClass = 'uk-alert uk-alert-danger';
	}
	else if (JJ_frameworkType === 'bootstrap3')
	{
		var alertClass = 'alert alert-danger';
	}
	else
	{
		var alertClass = 'alert alert-error';
	}

	var errorBox = instance.find('.jj-shout-error');
	var errorMsg = '<div class="' + alertClass + '">' + msg + '</div>';

	errorBox.html(errorMsg)
			.slideDown().delay(5000).slideUp(400, function() {
				errorBox.empty();
			});

	instance.find('#shoutbox-submit').prop('disabled', false);

	return false;
}


/**
 * Change the document title when a new shout is posted
 */
var JJ_original = document.title;
var JJ_timeout;

window.JJTitleBlink = function (msg, count, user)
{
	count = 2000;
	
	function step()
	{
		document.title = (document.title == JJ_original) ? msg : JJ_original;

		if (--count > 0)
		{
			JJ_timeout = setTimeout(step, 1000);
		};
	};

	JJCancelTitleBlink(JJ_timeout);

	if (!document.hasFocus())
	{
		step();
	}
};

window.JJCancelTitleBlink = function () {
	clearTimeout(JJ_timeout);
	document.title = JJ_original;
};


jQuery(document).ready(function($) {

	/**
	 * Compile the BBCode ready to insert
	 * Display insert box for images and links
	 */
	$('#jjshoutboxform .bbcode-button').on('click', function() {

		var bbcode = $(this).data('bbcode-type');
		var start  = '[' + bbcode + ']';
		var end    = '[/' + bbcode + ']';

		if (bbcode === 'url' || bbcode === 'img')
		{
			$('#jj-bbcode-type').data('bbcode-input-type', bbcode);

			if (bbcode === 'url')
			{
				$('#bbcode-form p').text(Joomla.JText._('SHOUT_BBCODE_INSERT_URL'));
			}
			else
			{
				$('#bbcode-form p').text(Joomla.JText._('SHOUT_BBCODE_INSERT_IMG'));
			}

			$('#bbcode-form').slideDown();
		}
		else
		{
			JJShoutbox.insertBBCode(start, end, $('#jj_message').get(0));
		}

	});


	/**
	 * Insert the BBCode and close the form
	 */
	$('#jjshoutboxform #bbcode-insert').on('click', function() {

		var bbcode = $('#jj-bbcode-type').data('bbcode-input-type');
		var start  = '[' + bbcode + '=' + $('#bbcode-form #bbcode-url').val() + ']' + $('#bbcode-form #bbcode-text').val();
		var end    = '[/' + bbcode + ']';

		JJShoutbox.insertBBCode(start, end, $('#jj_message').get(0));	

		$('#bbcode-form').slideUp();
	});


	/**
	 * Close the form
	 */
	$('#jjshoutboxform #bbcode-cancel').on('click', function() {

		$('#bbcode-form').slideUp();

	});


	/**
	 * Populate modal with image
	 */
	$('#jjshoutboxoutput').on('click', '.jj-image-modal', function(e) {

		e.preventDefault();

		if (JJ_frameworkType === 'uikit')
		{
			var modal = UIkit.modal('#jj-image-modal');
		}
		else
		{
			var modal = $('#jj-image-modal');
		}

		// Get the image src and name
		var image 	= $(this).data('jj-image');
		var alt 	= $(this).data('jj-image-alt');

		// Populate the image src/alt and header text
		modal.find('img').attr('src', image);
		modal.find('img').attr('alt', alt);
		modal.find('.image-name').text(alt);

		// Show the modal
		if (JJ_frameworkType === 'uikit')
		{
			modal.show();
		}
		else
		{
			modal.modal('show');
		}

	});


	/**
	 * Open the history modal
	 */
	$('#jjshoutboxoutput').on('click', '#jj-history-trigger', function(e) {

		e.preventDefault();

		if (JJ_frameworkType === 'uikit')
		{
			UIkit.modal('#jj-history-modal').show();
		}
		else
		{
			$('#jj-history-modal').modal('show');
		}

	});


	/**
	 * Return shoutbox to "insert" mode if cancel button is clicked
	 */
	$('#jjshoutboxform').on('click', '#edit-cancel', function(e) {

		e.preventDefault();

		$self = $(this);
		$self.css('display', 'none');

		$parent = $(this).parents('#jjshoutboxform');
		$parent.find('#jj_message').val('');		
		$parent.find('#shoutbox-submit').val(Joomla.JText._('SHOUT_SUBMITTEXT'));
		$parent.find('#shout-submit-type').attr('data-submit-type', 'insert')
										  .attr('data-shout-id', '');

	});

	
	/**
	 * Check the current timestamp and the timestamp stored in the database for that shout
	 */
	JJShoutbox.checkTimestamp = function(title, Itemid, instance, id)
	{
		// Assemble variables to submit
		var request = {
			'option'         : 'com_ajax',
			'module'         : 'shoutbox',
			'method'         : 'checkTimestamp',
			'format'         : 'raw',
			'jjshout[title]' : title,
			'jjshout[id]'    : id
		};

		// If there is an active menu item then we need to add it to the request.
		if (Itemid !== null)
		{
			request['Itemid'] = Itemid;
		}

		// AJAX request
		$.ajax({
			type: 'POST',
			data: request,
			success: function(response){

				if (response == '')
				{
					JJShoutbox.showError(Joomla.JText._('SHOUT_EDITOWN_TOO_LATE'), instance);
				}
				else
				{
					var json = $.parseJSON(response);

					$('#jj_message').val(json[0].msg);
					$('#shoutbox-name').val(json[0].name);

					$('#edit-cancel').css('display', 'block');

					$('#shoutbox-submit').val(Joomla.JText._('SHOUT_UPDATE'));

					$('#shout-submit-type').attr('data-submit-type', 'update')
										   .attr('data-shout-id', json[0].id);
				}
			},
			error: function(){
				JJShoutbox.showError(Joomla.JText._('SHOUT_AJAX_ERROR'), instance);
			}
		});

		return false;
	}


	/**
	 * Submit a shout
	 */
	JJShoutbox.submitPost = function(params)
	{
		// If the session state is "destroyed", throw an error
		if (params.session === 'destroyed')
		{
			JJShoutbox.showError(Joomla.JText._('SHOUT_SESSION_EXPIRED'), params.instance);
			return false;
		}

		// Assemble some commonly used vars
		var textarea = params.instance.find('#jj_message'),
		message = textarea.val();

		// Assemble variables to submit	
		var request = {
			'option'           : 'com_ajax',
			'module'           : 'shoutbox',
			'method'           : 'submit',
			'format'           : 'json',
			'jjshout[id]'      : params.shoutId,
			'jjshout[type]'    : params.type,
			'jjshout[name]'    : params.name,
			'jjshout[message]' : message.replace(/\n/g, "<br />"),
			'jjshout[shout]'   : 'Shout!',
			'jjshout[title]'   : params.title,
		};

		request[params.token] = 1;

		if (params.securityType === 1)
		{
			request['g-recaptcha-response'] = params.recaptcha;
		}

		if (params.securityType === 2)
		{
			request['jjshout[sum1]']  = params.instance.find('input[name="jjshout[sum1]"]').val();
			request['jjshout[sum2]']  = params.instance.find('input[name="jjshout[sum2]"]').val();
			request['jjshout[human]'] = params.instance.find('input[name="jjshout[human]"]').val();
		}

		// If there is an active menu item then we need to add it to the request.
		if (params.itemId !== null)
		{
			request['Itemid'] = params.itemId;
		}

		var submitButton = params.instance.find('#shoutbox-submit');
		submitButton.prop('disabled', true);

		// AJAX request
		$.ajax({
			type: 'POST',
			data: request,
			success: function(response){
				if (response.success)
				{
					// Empty the message value
					textarea.val('');

					// Empty the name value if there is one
					if (params.instance.find('#shoutbox-name').val())
					{
						params.instance.find('#shoutbox-name').val('');
					}

					submitButton.prop('disabled', false);
					submitButton.val(Joomla.JText._('SHOUT_SUBMITTEXT'));

					$('#shout-submit-type').attr('data-submit-type', 'insert')
										   .attr('data-shout-id', '');

					$('#edit-cancel').css('display', 'none');
					
					var JJ_ShoutGetParams = {
						title         : params.title,
						sound         : false,
						notifications : false,
						Itemid        : params.itemId,
						instance      : params.instance,
						loggedInUser  : params.name,
						history       : params.history,
					};

					// Refresh the output
					JJShoutbox.getPosts(JJ_ShoutGetParams);
				}
				else
				{
					JJShoutbox.showError(response.message, params.instance);
				}
			},
			error: function(){
				JJShoutbox.showError(Joomla.JText._('SHOUT_AJAX_ERROR'), params.instance);
			}
		});

		// Valid or not refresh recaptcha
		if (params.securityType === 1)
		{
			var JJ_RecaptchaReset = typeof(grecaptcha) == 'undefined' ? '' : grecaptcha.reset();
			
			JJ_RecaptchaReset;
		}

		// Valid or not refresh maths values and empty answer
		if (params.securityType === 2 && params.securityHide !== 1)
		{
			var val1, val2;
			val1 = JJShoutbox.getRandomArbitrary(0,9);
			val2 = JJShoutbox.getRandomArbitrary(0,9);
			params.instance.find('input[name="jjshout[sum1]"]').val(val1);
			params.instance.find('input[name="jjshout[sum2]"]').val(val2);
			params.instance.find('label[for="math_output"]').text(val1 + ' + ' + val2);
			params.instance.find('input[name="jjshout[human]"]').val('');
			JJShoutbox.drawMathsQuestion(val1, val2, params.rtl);
		}

		return false;
	}


	/**
	 * Get the latest shouts
	 * Play a sound notification if new shouts are shown
	 */
	JJShoutbox.getPosts = function(params)
	{
		// Get the ID of the last shout
		var lastID 	 = JJShoutbox.getLastID(params.instance);
		var lastName = JJShoutbox.getLastAuthor(params.instance);

		// Assemble variables to submit
		var request = {
			'option'         : 'com_ajax',
			'module'         : 'shoutbox',
			'method'         : 'getPosts',
			'format'         : 'json',
			'jjshout[title]' : params.title,
		};

		// If there is an active menu item then we need to add it to the request.
		if (params.Itemid !== null)
		{
			request['Itemid'] = params.Itemid;
		}

		// AJAX request
		$.ajax({
			type: 'POST',
			data: request,
			success: function(response){
				if (response.success)
				{
					params.instance.find('#jjshoutboxoutput').empty().prepend($('<div class="jj-shout-new"></div>'));
					
					var historyButton = '';
					
					if (params.history === 1)
					{
						historyButton = '<div class="center-block"><a href="#" id="jj-history-trigger" class="btn btn-primary btn-mini btn-xs uk-button uk-button-primary uk-button-mini">' + Joomla.JText._('SHOUT_HISTORY_BUTTON') + '</a></div>';
					}

					// Grab the html output and append it to the shoutbox message
					params.instance.find('.jj-shout-new').after(response.data.html + historyButton);

					// Get the ID of the last shout after the output has been updated
					var newLastID = JJShoutbox.getLastID(params.instance);

					// Post ID and name checks
					if (newLastID > lastID && (params.loggedInUser !== lastName))
					{
						JJTitleBlink(Joomla.JText._('SHOUT_NEW_SHOUT_ALERT'));

						// Show HTML5 Notification if enabled
						if (params.notifications == 1)
						{
							JJShoutbox.createNotification(Joomla.JText._('SHOUT_NEW_SHOUT_ALERT'));
						}
						// Play notification sound if enabled
						if (params.sound === 1)
						{
							params.instance.find('.jjshoutbox-audio').get(0).play();
						}
					}
				}
				else
				{
					JJShoutbox.showError(response.message, params.instance);
				}
			},
			error: function(){
				JJShoutbox.showError(Joomla.JText._('SHOUT_AJAX_ERROR'), params.instance);
			}
		});

		return false;
	}


	/**
	 * Get the the shouts history based on the offset and count
	 */
	JJShoutbox.getPostsHistory = function(title, Itemid, instance, offset)
	{
		// Assemble variables to submit
		var request = {
			'option'          : 'com_ajax',
			'module'          : 'shoutbox',
			'method'          : 'getPosts',
			'format'          : 'json',
			'jjshout[title]'  : title,
			'jjshout[offset]' : offset,
		};

		// If there is an active menu item then we need to add it to the request.
		if (Itemid !== null)
		{
			request['Itemid'] = Itemid;
		}

		// AJAX request
		$.ajax({
			type: 'POST',
			data: request,
			success: function(response){
				if (response.success)
				{
					if (response.data.html == '')
					{
						$('#jj-load-more').hide();
					}
					else
					{
						// Grab the html output and append it to the shoutbox message
						$('#jj-load-more').parent().before(response.data.html);
					}
				}
				else
				{
					JJShoutbox.showError(response.message, instance);
				}
			},
			error: function(){
				JJShoutbox.showError(Joomla.JText._('SHOUT_AJAX_ERROR'), instance);
			}
		});

		return false;
	}

	$(window).on('focus', function() {
		JJCancelTitleBlink();
	});

});
