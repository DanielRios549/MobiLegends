jQuery(document).ready(function($) {
    $("#mobi_install_default_data").click(function () {
        $.ajax({
            type: "POST",
            url: mobi_install_obj.ajax_url,
            data: {
                action: 'mobi_install_action',
                _ajax_nonce: mobi_install_obj.nonce_install,
            },
            success: function () {
                alert('Default data installed successfully.');
                location.reload();
            },
            error: function () {
                alert('Default data installed error.');
            }
        });
    });
    $("#mobi_install_default_data_skip").click(function () {
        $.ajax({
            type: "POST",
            url: mobi_install_obj.ajax_url,
            data: {
                action: 'mobi_install_action_skip',
                _ajax_nonce: mobi_install_obj.nonce_skip,
            },
            success: function () {
                alert('Default data not installed successfully.');
                location.reload();
            },
            error: function () {
                alert('Default data not installed error.');
            }
        });
    });
 });
