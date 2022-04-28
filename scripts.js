// jQuery registerForm validation

$(document).ready(function () {
    $('#registerForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 6
            },
            phone: {
                required: true,
                minlength: 10,
                number: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            address: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            name: {
                required: "Please enter your full name",
                minlength: "Full name should be atleast 6 characters"
            },
            phone: {
                required: "Please enter your phone number",
                minlength: "Phone number should be atleast 10 characters",
                number: "Enter valid number"
            },
            email: "Please provide your email address",
            password: {
                required: "Please provide a password",
                minlength: "Password should be atleast 6 characters"
            },
            address: {
                required: "Please provide your address",
                minlength: "Address should be atleast 4 characters"
            }
        }
    });

    // $('#registerForm #email').keyup(function () {
    //     var email = $(this).val();
    //     $.ajax({
    //         url: 'checkEmail.php',
    //         data: { 'token': email },
    //         dataType: 'text',
    //         method: 'post',
    //         success: function (response) {
    //             $('#registerEmail').html(response);
    //             if (response == 'Email is available') {
    //                 $('#registerEmail').css({ color: 'green' });
    //             } else {
    //                 $('#registerEmail').css({ color: 'red' });

    //             }
    //         }
    //     });
    // });

    // $('.likeBtn').on('click', function () {
    //     let fId = $(this).data('id');
    //     $clickedBtn = $(this);

    //     if ($clickedBtn.hasClass('inactive')) {
    //         action = 'like';
    //     } else if ($clickedBtn.hasClass('active')) {
    //         action = 'unlike';
    //     }

    //     $.ajax({
    //         url: 'read.php',
    //         data: { 'action': action, 'fId': fId },
    //         datatype: 'text',
    //         method: 'post',
    //         success: function (response) {

    //         }
    //     });
    // });

});

// JavaScript loginForm validations

const errors = document.querySelectorAll('span.error');
const emailErr = document.querySelector('.emailErr');
const passwordErr = document.querySelector('.passwordErr');

function validateForm() {
    clearError();
    error = 0;
    let emailPattern = new RegExp('/^([\w._%+-]+@[\w.-]+\.[a-zA-Z]{2,4})$/');

    const email = document.loginForm.email.value.trim();
    if (email == '') {
        error++;
        emailErr.innerText = 'Enter your email address';
    }
    // else if (!emailPattern.test(email)) {
    //     error++;
    //     emailErr.innerText = 'Enter valid email address';
    // }

    const password = document.loginForm.password.value.trim();
    if (password == '') {
        error++;
        passwordErr.innerText = 'Enter your password';
    } else if (password.length < 6) {
        error++;
        passwordErr.innerText = 'Password should atleast be 6 characters';
    }

    if (error > 0) {
        return false;
    }
}

function clearError() {
    for (let i = errors.length - 1; i >= 0; i--) {
        errors[i].innerText = '';
    }
}