jQuery(document).ready(function() {
	// click on next button

    $('input[name=tahapan]').on('change', function() {
        console.log(this.value)
        if (this.value == "1") {
            $('#tahap-lanjut-2').show();
            $('#tahap-lanjut-3').hide();
        } else if (this.value == "2") {
            $('#tahap-lanjut-2').show();
            $('#tahap-lanjut-3').show();
        } else {
            $('#tahap-lanjut-2').hide();
            $('#tahap-lanjut-3').hide();
        }
    });
	
	$(document).ready(function() {
		$(".content-new").hide();
		$(".show_hide_new").on("click", function() {
			var content = $(this).prev('.content-new');
			content.slideToggle(100);
			if ($(this).text().trim() == "Show more") {
				$(this).text("Show less");
			} else {
				$(this).text("Show more");
			}
		});
	});

	$('input[name=gaji]').on('change', function() {
        if (this.value == "1") {
            $('#nominal').prop('disabled', false).prop('required',true);;
        } else {
            $('#nominal').prop('disabled', true).prop('required',false);;
        }
    });

    $('.select2-multiple').select2({
        tags: true,
        createTag: function (params) {
          var term = $.trim(params.term);

          if (term === '') {
            return null;
          }

          return {
            id: term,
            text: term,
            newTag: true // add additional parameters
          }
        }
    });
	
	jQuery('.form-wizard-next-btn').click(function() {
        // $('#jenismagang').select2("enable", true);
		var parentFieldset = jQuery(this).parents('.wizard-fieldset');
		var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
		var next = jQuery(this);
		var nextWizardStep = true;
		parentFieldset.find('.wizard-required').each(function(){
			var thisValue = jQuery(this).val();

            // console.log("sadsd",jQuery(this).prop("tagName"));
            if(jQuery(this).prop("tagName")=="SELECT" && ( thisValue == "" || thisValue == null)){
                $(".select2-error-form").slideDown();
                $("#form-error").slideDown();
				nextWizardStep = false;

            }else if( thisValue == "" || thisValue == null) {
				jQuery(this).siblings(".wizard-form-error").slideDown();
				$("#form-error").slideDown();
				nextWizardStep = false;
			}
			else {
				jQuery(this).siblings(".wizard-form-error").slideUp();
			}
		});
		if( nextWizardStep) {
			next.parents('.wizard-fieldset').removeClass("show","400");
			currentActiveStep.removeClass('active').addClass('activated').next().addClass('active',"400");
			next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show","400");
			jQuery(document).find('.wizard-fieldset').each(function(){
				if(jQuery(this).hasClass('show')){
					var formAtrr = jQuery(this).attr('data-tab-content');
					jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function(){
						if(jQuery(this).attr('data-attr') == formAtrr){
							jQuery(this).addClass('active');
							var innerWidth = jQuery(this).innerWidth();
							var position = jQuery(this).position();
							jQuery(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
						}else{
							jQuery(this).removeClass('active');
						}
					});
				}
			});
		}
	});
	//click on previous button
	jQuery('.form-wizard-previous-btn').click(function() {
		var counter = parseInt(jQuery(".wizard-counter").text());;
		var prev =jQuery(this);
		var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
		prev.parents('.wizard-fieldset').removeClass("show","400");
		prev.parents('.wizard-fieldset').prev('.wizard-fieldset').addClass("show","400");
		currentActiveStep.removeClass('active').prev().removeClass('activated').addClass('active',"400");
		jQuery(document).find('.wizard-fieldset').each(function(){
			if(jQuery(this).hasClass('show')){
				var formAtrr = jQuery(this).attr('data-tab-content');
				jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function(){
					if(jQuery(this).attr('data-attr') == formAtrr){
						jQuery(this).addClass('active');
						var innerWidth = jQuery(this).innerWidth();
						var position = jQuery(this).position();
						jQuery(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
					}else{
						jQuery(this).removeClass('active');
					}
				});
			}
		});
	});
	//click on form submit button
	jQuery(document).on("click",".form-wizard .form-wizard-submit" , function(){
		var parentFieldset = jQuery(this).parents('.wizard-fieldset');
		var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
		parentFieldset.find('.wizard-required').each(function() {
			var thisValue = jQuery(this).val();
			if( thisValue == "" ) {
				jQuery(this).siblings(".wizard-form-error").slideDown();
			}
			else {
				jQuery(this).siblings(".wizard-form-error").slideUp();
			}
		});
	});
	// focus on input field check empty or not
	jQuery(".form-control").on('focus', function(){
		var tmpThis = jQuery(this).val();
		if(tmpThis == '' ) {
			jQuery(this).parent().addClass("focus-input");
		}
		else if(tmpThis !='' ){
			jQuery(this).parent().addClass("focus-input");
		}
	}).on('blur', function(){
		var tmpThis = jQuery(this).val();
		if(tmpThis == '' ) {
			jQuery(this).parent().removeClass("focus-input");
			jQuery(this).siblings('.wizard-form-error').slideDown("3000");
		}
		else if(tmpThis !='' ){
			jQuery(this).parent().addClass("focus-input");
			jQuery(this).siblings('.wizard-form-error').slideUp("3000");
		}

	});
    jQuery(".select2").change(function(){
		let thisValue = jQuery(this).val();
        if(jQuery(this).prop("tagName")=="SELECT" && ( thisValue == "" || thisValue == null)){
            $(".select2-error-form").slideDown();
                $("#form-error").slideDown();
        }else{
            $(".select2-error-form").slideUp("3000");
                $("#form-error").slideUp();
        }
	});
});
