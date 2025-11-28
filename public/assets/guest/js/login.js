$(document).ready(function() {
    // Email validation
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Input validation on blur
    $('#email').on('blur', function() {
        const email = $(this).val().trim();
        if (!email || !isValidEmail(email)) {
            $(this).addClass('error');
        } else {
            $(this).removeClass('error');
        }
    });

    $('#password').on('blur', function() {
        const password = $(this).val();
        if (!password || password.length < 6) {
            $(this).addClass('error');
            $(this).next('.error-message').text('Le mot de passe doit contenir au moins 6 caractères');
        } else {
            $(this).removeClass('error');
        }
    });

    // Remove error on input
    $('.form-input').on('input', function() {
        $(this).removeClass('error');
    });

    // Form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        const email = $('#email').val().trim();
        const password = $('#password').val();
        const remember = $('#remember').is(':checked');

        let isValid = true;

        // Validate email
        if (!email || !isValidEmail(email)) {
            $('#email').addClass('error');
            isValid = false;
        }

        // Validate password
        if (!password || password.length < 6) {
            $('#password').addClass('error');
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        // Show loading state
        const $submitBtn = $(this).find('.btn-primary');
        $submitBtn.addClass('loading').prop('disabled', true);

        // Simulate API call (Replace with actual Laravel API call)
        setTimeout(function() {
            // Success - redirect to dashboard
            window.location.href = 'dashboard/index.html';
            
            // On error, you would do:
            // $submitBtn.removeClass('loading').prop('disabled', false);
            // alert('Email ou mot de passe incorrect');
        }, 1500);
    });

    // Forgot password
    $('a[href="#forgot-password"]').on('click', function(e) {
        e.preventDefault();
        const email = prompt('Entrez votre adresse email pour réinitialiser votre mot de passe :');
        if (email && isValidEmail(email)) {
            alert('Un email de réinitialisation a été envoyé à ' + email);
            // Here you would send the reset email via Laravel
        } else if (email) {
            alert('Adresse email invalide');
        }
    });
});