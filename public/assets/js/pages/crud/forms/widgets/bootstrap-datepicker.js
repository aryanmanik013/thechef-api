// Class definition

var KTBootstrapDatepicker = function () {

    var arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }
    
    // Private functions
    var demos = function () {

                // used in  delivery charge section
        $('#end-date').datepicker({
            rtl: KTUtil.isRTL(),
            autoclose: true,
           todayHighlight: true,
           format: 'dd-mm-yyyy', 
            orientation: "bottom left",
            templates: arrows
        });

             $('#start-date').datepicker({
            rtl: KTUtil.isRTL(),
             autoclose: true,
            todayHighlight: true,
            format: 'dd-mm-yyyy' ,
            orientation: "bottom left",
            templates: arrows
        });
   

       
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

jQuery(document).ready(function() {    
    KTBootstrapDatepicker.init();
});