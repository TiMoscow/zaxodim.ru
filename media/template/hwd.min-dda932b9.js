jQuery(document).ready(function(){var e=function(){function a(a){a.preventDefault(),jQuery(a.data.selector).attr("disabled",!0);var t=jQuery(a.data.selector).attr("data-media-task"),r=jQuery(a.data.selector).attr("data-media-id"),i=jQuery(a.data.selector).attr("data-media-token"),s=hwdms_live_site,d={};d.option="com_hwdmediashare",d.task="get."+t,d.id=r,d.format="json",d[i]="1";var c=jQuery.post(s,d);c.done(function(r){try{var i=jQuery.parseJSON(r);if("success"==i.status)switch(t){case"favourite":jQuery(a.data.selector).attr("disabled",!1),jQuery(a.data.selector).attr("data-media-task","unfavourite"),jQuery(a.data.selector).addClass("active"),jQuery(a.data.selector+" i:first-child").addClass("red");break;case"unfavourite":jQuery(a.data.selector).attr("disabled",!1),jQuery(a.data.selector).attr("data-media-task","favourite"),jQuery(a.data.selector).removeClass("active"),jQuery(a.data.selector+" i:first-child").removeClass("red");break;case"subscribe":jQuery(a.data.selector).attr("disabled",!1),jQuery(a.data.selector).attr("data-media-task","unsubscribe"),jQuery(a.data.selector).addClass("active"),jQuery(a.data.selector).html('<i class="icon-checkmark"></i> '+hwdms_text_subscribed);break;case"unsubscribe":jQuery(a.data.selector).attr("disabled",!1),jQuery(a.data.selector).attr("data-media-task","subscribe"),jQuery(a.data.selector).removeClass("active"),jQuery(a.data.selector).html('<i class="icon-user"></i> '+hwdms_text_subscribe);break;case"like":jQuery(a.data.selector).addClass("active");var s=parseInt(jQuery("#media-likes").html())+1,d=parseInt(jQuery("#media-dislikes").html()),c=parseInt(100*s/(s+d));jQuery("#media-likes").html(s),jQuery("#percentbar-active").css({width:c+"%"});break;case"dislike":jQuery(a.data.selector).addClass("active");var s=parseInt(jQuery("#media-likes").html()),d=parseInt(jQuery("#media-dislikes").html())+1,c=parseInt(100*s/(s+d));jQuery("#media-dislikes").html(d),jQuery("#percentbar-active").css({width:c+"%"})}else e.popup(i.message),jQuery(a.data.selector).attr("disabled",!1)}catch(n){e.popup(hwdms_text_error_occured),jQuery(a.data.selector).attr("disabled",!1)}}),c.fail(function(t){e.popup(hwdms_text_error_occured),jQuery(a.data.selector).attr("disabled",!1)})}function t(e){jQuery.magnificPopup.open({items:{src:jQuery("<div>"+e+"</div>")},type:"inline",preloader:!1,closeOnBgClick:!0,mainClass:"mfp-alert",closeOnContentClick:!0,removalDelay:0})}return{popup:t,post:a}},e=new e;jQuery("#media-favourite-btn").click({selector:"#media-favourite-btn"},e.post),jQuery("#media-subscribe-btn").click({selector:"#media-subscribe-btn"},e.post),jQuery("#media-like-btn").click({selector:"#media-like-btn"},e.post),jQuery("#media-dislike-btn").click({selector:"#media-dislike-btn"},e.post),jQuery(".hwd-form-filedata").length&&jQuery(".hwd-form-filedata").bootstrapFileInput(),jQuery("#hwd-container .radio.btn-group").length&&(jQuery("#hwd-container .radio.btn-group label").addClass("btn"),jQuery("#hwd-container .btn-group label:not(.active)").click(function(){var e=jQuery(this),a=jQuery("#"+e.attr("for"));a.prop("checked")||(e.closest(".btn-group").find("label").removeClass("active btn-success btn-danger btn-primary"),""==a.val()?e.addClass("active btn-primary"):0==a.val()?e.addClass("active btn-danger"):e.addClass("active btn-success"),a.prop("checked",!0))}),jQuery("#hwd-container .btn-group input[checked=checked]").each(function(){""==jQuery(this).val()?jQuery("label[for="+jQuery(this).attr("id")+"]").addClass("active btn-primary"):0==jQuery(this).val()?jQuery("label[for="+jQuery(this).attr("id")+"]").addClass("active btn-danger"):jQuery("label[for="+jQuery(this).attr("id")+"]").addClass("active btn-success")})),jQuery(document).on("keydown",function(e){if(jQuery("#hwd-container div.media-item-navigation a.prev").on("click",function(){window.location=jQuery("#hwd-container div.media-item-navigation a.prev").attr("href")}),jQuery("#hwd-container div.media-item-navigation a.next").on("click",function(){window.location=jQuery("#hwd-container div.media-item-navigation a.next").attr("href")}),jQuery(e.target.nodeName).is("body")){switch(e.which){case 37:jQuery("#hwd-container div.media-item-navigation a.prev").trigger("click");break;case 39:jQuery("#hwd-container div.media-item-navigation a.next").trigger("click");break;default:return}e.preventDefault()}return!0})}),window.MooTools&&window.addEvent("domready",function(){Element.prototype.hide=function(){-1!=this.className.indexOf("hasTooltip")||(this.style.display="none")}});