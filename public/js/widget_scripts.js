jQuery(document).ready(function(){
	jQuery('.adults-number .minus').click(function () {
	    var jQueryinput = jQuery(this).parent().find('input');
	    var count = parseInt(jQueryinput.val()) - 1;
	    count = count < 1 ? 1 : count;
	    jQueryinput.val(count);
	    jQueryinput.change();

	    var ad_str = 'Adult';
	    if ( count <= 1 ) {
	    	ad_str = 'Adults';
	    }
	    jQuery(".adult_count_str").html(count+" "+ad_str);
	    return false;
	});
	 
	jQuery('.adults-number .plus').click(function () {
	    var jQueryinput = jQuery(this).parent().find('input');
	    jQueryinput.val(parseInt(jQueryinput.val()) + 1);
	    jQueryinput.change();

	    var count = parseInt(jQueryinput.val()) + 1;
	    jQuery('#childage'+count).css('display', 'none');

	    var ad_str = 'Adult';
	    if ( count <= 1 ) {
	    	ad_str = 'Adults';
	    }
	    jQuery(".adult_count_str").html(parseInt(jQueryinput.val())+" "+ad_str);
	    return false;
	});

	jQuery('.children-number .plus').click(function (e) {
	    var jQueryinput = jQuery(this).parent().find('input');
	    var count = parseInt(jQueryinput.val()) + 1;
	    if ( count > 6 ) {
	    	alert("Select maximum 6 children only");
	    	return false;
	    }
	    else {
	    	jQueryinput.val(parseInt(jQueryinput.val()) + 1);
		    jQueryinput.change();
		}
		jQuery('#childage'+count).css('display', 'block');

		var ad_str = 'Childeren';
	    if ( count <= 1 ) {
	    	ad_str = 'Childeren';
	    }
	    jQuery(".child_count_str").html(count+" "+ad_str);
	    return false;
	});

	jQuery('.children-number .minus').click(function (e) {
	    var jQueryinput = jQuery(this).parent().find('input');
	    var remove_index = parseInt(jQueryinput.val());
	    var count = parseInt(jQueryinput.val()) - 1;

	    count = count < 0 ? 0 : count;
	    jQueryinput.val(count);
	    jQueryinput.change();
		
		jQuery('#childage'+remove_index).css('display', 'none');

		var ad_str = 'Childeren';
	    if ( count <= 1 ) {
	    	ad_str = 'Childeren';
	    }
	    jQuery(".child_count_str").html(count+" "+ad_str);
	    return false;
	});

    // jQuery('.t-datepicker').tDatePicker({

    // });

    jQuery('.booking_search_button').click(function (e) {
	    jQuery("#booking_widget_form").submit();
	});
});


