$(document).ready(function() {
    let currentStep = 1;

    // Validation functions
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validateStep(step) {
        let isValid = true;
        const $section = $(`.form-section[data-section="${step}"]`);

        $section.find('input[required], select[required]').each(function() {
            const $input = $(this);
            const value = $input.val().trim();

            if (!value) {
                $input.addClass('error');
                isValid = false;
            } else if ($input.attr('type') === 'email' && !isValidEmail(value)) {
                $input.addClass('error');
                isValid = false;
            } else {
                $input.removeClass('error');
            }
        });

        return isValid;
    }

    function goToStep(step) {
        $('.form-section').removeClass('active');
        $(`.form-section[data-section="${step}"]`).addClass('active');

        $('.step').removeClass('active completed');
        for (let i = 1; i < step; i++) {
            $(`.step[data-step="${i}"]`).addClass('completed');
        }
        $(`.step[data-step="${step}"]`).addClass('active');

        const progressWidth = ((step - 1) / 2) * 100;
        $('.progress-line').css('width', progressWidth + '%');

        currentStep = step;
    }

    // Password strength
    $('#password').on('input', function() {
        const password = $(this).val();
        const $fill = $('.strength-fill');
        const $text = $('.strength-text');

        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        $fill.removeClass('weak medium strong');
        
        if (strength <= 1) {
            $fill.addClass('weak');
            $text.text('Mot de passe faible');
        } else if (strength <= 2) {
            $fill.addClass('medium');
            $text.text('Mot de passe moyen');
        } else {
            $fill.addClass('strong');
            $text.text('Mot de passe fort');
        }
    });

    // Remove error on input
    $('.form-input, .form-select').on('input change', function() {
        $(this).removeClass('error');
    });

    // Navigation
    $('#nextStep1').on('click', function() {
        if (validateStep(1)) {
            goToStep(2);
        }
    });

    $('#nextStep2').on('click', function() {
        if (validateStep(2)) {
            goToStep(3);
        }
    });

    $('#prevStep2').on('click', function() {
        goToStep(1);
    });

    $('#prevStep3').on('click', function() {
        goToStep(2);
    });

    // Form submission
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        const password = $('#password').val();
        const passwordConfirm = $('#password_confirm').val();
        const terms = $('#terms').is(':checked');

        let isValid = true;

        // Validate password match
        if (password !== passwordConfirm) {
            $('#password_confirm').addClass('error');
            isValid = false;
        }

        // Validate terms
        if (!terms) {
            alert('Vous devez accepter les conditions générales');
            isValid = false;
        }

        if (!isValid) return;

        // Collect form data
        const formData = {
            nom: $('#nom').val(),
            prenom: $('#prenom').val(),
            email: $('#email').val(),
            telephone: $('#telephone').val(),
            pays: $('#pays').val(),
            password: password
        };

        console.log('Form Data:', formData);

        // Simulate API call (Replace with actual Laravel API)
        $('#submitBtn').prop('disabled', true).text('Création en cours...');

        setTimeout(function() {
            alert('Compte créé avec succès ! Vous allez être redirigé vers la connexion.');
            window.location.href = 'login.html';
        }, 1500);
    });
});