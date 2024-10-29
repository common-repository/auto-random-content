jQuery(document).ready(function () {
    jQuery("ul#wp-admin-bar-random-content-default #wp-admin-bar-random-content-create a").on('click', function (e) {
        e.preventDefault();
        jQuery("#container_loader").css("display", "block");
        jQuery("#loader").css("display", "block");
        jQuery("#on_waiting_create").css("display", "block");

        jQuery("#on_waiting_delete").css("display", "none");
        jQuery("#create_success").css("display", "none");
        jQuery("#delete_success").css("display", "none");
        jQuery("#error_message").css("display", "none");
        jQuery("#close_modal_random_content").css("display", "none");

        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: "/wp-admin/admin-ajax.php",
            data: {
                action: "boot_create"
            },
            success: function (data) {
                jQuery("#loader").css("display", "none");
                jQuery("#on_waiting_create").css("display", "none");
                jQuery("#create_success").css("display", "block");
                jQuery("#close_modal_random_content").css("display", "block");
            },
            error: function (error) {
                jQuery("#loader").css("display", "none");
                jQuery("#on_waiting_create").css("display", "none");
                jQuery("#error_message").css("display", "block");
                jQuery("#close_modal_random_content").css("display", "block");
            }
        });
    });

    jQuery("ul#wp-admin-bar-root-default #wp-admin-bar-random-content-delete a").on('click', function (e) {
        e.preventDefault();
        jQuery("#container_loader").css("display", "block");
        jQuery("#loader").css("display", "block");
        jQuery("#on_waiting_delete").css("display", "block");

        jQuery("#on_waiting_create").css("display", "none");
        jQuery("#create_success").css("display", "none");
        jQuery("#delete_success").css("display", "none");
        jQuery("#error_message").css("display", "none");
        jQuery("#close_modal_random_content").css("display", "none");
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: random_content_ajax_object.ajax_url,
            data: {
                action: "boot_delete"
            },
            success: function (data) {
                jQuery("#loader").css("display", "none");
                jQuery("#on_waiting_delete").css("display", "none");
                jQuery("#delete_success").css("display", "block");
                jQuery("#close_modal_random_content").css("display", "block");
            },
            error: function (error) {
                jQuery("#loader").css("display", "none");
                jQuery("#on_waiting_delete").css("display", "none");
                jQuery("#error_message").css("display", "block");
                jQuery("#close_modal_random_content").css("display", "block");
            }
        });
    });

    jQuery("#close_modal_random_content").on("click", function (e) {
        jQuery("#container_loader").css("display", "none");
    });
});


/* code for option page  */
jQuery(document).ready(function () {
    if (jQuery("#auto-random-content-form-option-page").length) {
        compile_taxonomy();
        check_if_element_is_enabled('relate_thumb', 'thumbnail');
        check_if_element_is_enabled('relate_comment', 'comments');
    }

    jQuery("#auto-random-content-form-option-page #relate_term").change(function () {
        verify_check(this, "post_taxonomy");
    });

    jQuery("#auto-random-content-form-option-page #post_type").change(function () {
        compile_taxonomy();
        check_if_element_is_enabled('relate_thumb', 'thumbnail');
        check_if_element_is_enabled('relate_comment', 'comments');
    });
});


/* #################################### js custom function ############################################# */
function hidden_fields(id_field) {
    jQuery("#" + id_field).parents("tr").css("display", "none");
}

function visible_fields(id_field) {
    jQuery("#" + id_field).parents("tr").css("display", "table-row");
}

function verify_check(obj, element) {
    if (jQuery(obj).attr("checked") == "checked") {
        visible_fields(element);
    } else {
        hidden_fields(element);
    }
}

function compile_taxonomy() {
    var post_type = jQuery("#post_type").val();
    var ajax_request = jQuery.ajax({
        type: "post",
        dataType: "json",
        url: random_content_ajax_object.ajax_url,
        data: {
            post_type: post_type,
            action: "get_taxs"
        },
        success: function (data) {

            if (data.taxs != undefined && data.taxs.length > 0) {
                var html = "";
                jQuery.each(data.taxs, function (i, element) {
                    if (element.value_option == data.selected) {
                        html = html + "<option selected value='" + element.value_option + "'>" + element.text_option + "</option>";
                    } else {
                        html = html + "<option value='" + element.value_option + "'>" + element.text_option + "</option>";
                    }

                });
                jQuery("#post_taxonomy").html(html);
                visible_fields("post_taxonomy");
                visible_fields("relate_term");
                verify_check(jQuery("#auto-random-content-form-option-page #relate_term"), "post_taxonomy");
            } else {
                var html = "";
                jQuery("#post_taxonomy").html(html);
                hidden_fields("post_taxonomy");
                hidden_fields("relate_term");
            }

        },
        error: function (error) {

        }
    });
}

function check_if_element_is_enabled(element_to_hidden, support) {
    var post_type = jQuery("#post_type").val();
    var ajax_request = jQuery.ajax({
        type: "post",
        dataType: "json",
        url: random_content_ajax_object.ajax_url,
        data: {
            post_type: post_type,
            support: support,
            action: "get_post_support"
        },
        success: function (data) {
            if (data == true) {
                visible_fields(element_to_hidden);
            } else {
                hidden_fields(element_to_hidden);
            }

        },
        error: function (error) {

        }
    });
}