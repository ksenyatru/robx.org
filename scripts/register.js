function add_elements_register() {
}


function remove_elements_register() {
}

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function init_register() {
	$( ".form input" ).change(function() {
		if ($(".form .required input:empty").filter(function() {
			if($(this).val() == '') {
				return true;
			} else {
				return false;
			}
		}).length == 0) {

			$('.form input[type=submit]').css('opacity', '1').prop( "disabled", false);
		}
	});

	$('.form form').submit(function() {
		var $form = $(this);
		$.ajax({
			url: $form.attr('action'),
			data: $form.serializeObject(),
			type: "POST",
			dataType: 'xml',
			statusCode: {
				0: function (){
					$('.form').addClass('sent');
				},
				200: function (){
					$('.form').addClass('sent');
 				}
			}
		});
		return false;
   	});	
}

function resize_register() {
}
