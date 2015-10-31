$(function() {

    $("input,textarea,select").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function($form, event, errors) {
            // additional error messages or events
        },
        submitSuccess: function($form, event) {
            // Prevent spam click and default submit behaviour
            $("#btnSubmit").attr("disabled", true);
            event.preventDefault();
            var e = document.getElementById("corso");
            // get values from FORM
            var name = $("input#name").val();
            if($("input#regolamento").is(':checked')) { var regolamento = 1; };
            if($("input#liberatoria").is(':checked')) { var liberatoria = 1; } else { var liberatoria = 0; };
            var corso = e.options[e.selectedIndex].value;
            var nascita = $("input#nascita").val();
            var luogodinascita = $("input#luogodinascita").val();
            var residenza = $("input#residenza").val();
            var cap = $("input#cap").val();
            var via = $("input#via").val();
            var n = $("input#n").val();
            var email = $("input#email").val();
            var username = $("input#username").val();
            var phone = $("input#phone").val();
            var cf = $("input#cf").val();
            var firstName = name; // For Success/Failure Message
            // Check for white space in name for Success/Fail message
            if (firstName.indexOf(' ') >= 0) {
                firstName = name.split(' ').slice(0, -1).join(' ');
            }
            $.ajax({
                url: "https://scuola.fantasiadanzarovigo.com/mail/iscrizioni.php",
                type: "POST",
                data: {
                    name: name,
                    regolamento: regolamento,
                    liberatoria: liberatoria,
                    corso: corso,
                    nascita: nascita,
                    luogodinascita: luogodinascita,
                    residenza: residenza,
                    via: via,
                    n: n,
                    email: email,
                    phone: phone,
                    cf: cf,
                    username: username,
                    cap: cap
                },
                cache: false,
                success: function() {
                    // Enable button & show success message
                    $("#btnSubmit").attr("disabled", false);
                    $('#success').html("<div class='alert alert-success'>");
                    $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-success')
                        .append("<strong>L'iscrizione &egrave; stata inviata. </strong>");
                    $('#success > .alert-success')
                        .append('</div>');

                    //clear all fields
                    $('#contactForm').trigger("reset");
                    location.reload(true);
                },
                error: function() {
                    // Fail message
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-danger').append("<strong>Scusa " + firstName + ", sembra che ci sia stato un errore :(!");
                    $('#success > .alert-danger').append('</div>');
                    //clear all fields
                    $('#contactForm').trigger("reset");
                },
            })
        },
        filter: function() {
            return $(this).is(":visible");
        },
    });

    $("a[data-toggle=\"tab\"]").click(function(e) {
        e.preventDefault();
        $(this).tab("show");
    });
});

// When clicking on Full hide fail/success boxes
$('#name').focus(function() {
    $('#success').html('');
});
