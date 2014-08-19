function initTooltips() {
    jQuery('.item_box').each(function() {
        jQuery(this).qtip({
            content: {
                title: "Identification Data",
                text: jQuery("." + this.id + "id").html(),
                button: "&cross;"
            },
            show: 'click',
            hide: 'unfocus',
            position: {
                my: 'top center',
                at: 'bottom center'
            }
        });
    });
}

function initPage() {
    initTooltips();
}

jQuery(document).ready(initPage);