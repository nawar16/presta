$('#profile_url').appendTo('#customer-form');
$('#profile_url_value').change(function() {
    var url = $('#profile_url_value').val();
    console.log(url)

    localStorage.setItem('profile_url', url);

    $.getJSON(mjax.ajax_link, { profile_url: url }, function(data) {
        if (typeof data.status !== "undefined") {
            console.log(data);
        }

    });
});