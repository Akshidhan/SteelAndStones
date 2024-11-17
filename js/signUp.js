document.addEventListener('DOMContentLoaded', function () {
    var fname = document.getElementById('fname');
    var username = document.getElementById('username');
    var form = document.getElementById('signUpForm');
    var numOfChar = document.getElementById('numOfChar');
    var num = document.getElementById('num');
    var ucase = document.getElementById('ucase');
    var lcase = document.getElementById('lcase');
    var passwordHints = document.getElementById('passwordHints');

    const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
    const appendAlert = (message, type) => {
    const wrapper = document.createElement('div')
    wrapper.innerHTML = [
        `<div class="alert alert-${type} alert-dismissible" role="alert">`,
        `   <div>${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
    ].join('')

    alertPlaceholder.append(wrapper)
    }

    function validatePassword() {
        var pass = password.value;

        passwordHints.style.display = 'block';

        const isAtLeast8Chars = pass.length >= 8;
        const hasLowercase = /[a-z]/.test(pass);
        const hasUppercase = /[A-Z]/.test(pass);
        const hasNumber = /\d/.test(pass);

        if (isAtLeast8Chars) {
            numOfChar.classList.add('ok');
            numOfChar.classList.remove('nok');
        } else {
            numOfChar.classList.add('nok');
            numOfChar.classList.remove('ok');
        }

        if (hasLowercase) {
            lcase.classList.add('ok');
            lcase.classList.remove('nok');
        } else {
            lcase.classList.add('nok');
            lcase.classList.remove('ok');
        }

        if (hasUppercase) {
            ucase.classList.add('ok');
            ucase.classList.remove('nok');
        } else {
            ucase.classList.add('nok');
            ucase.classList.remove('ok');
        }

        if (hasNumber) {
            num.classList.add('ok');
            num.classList.remove('nok');
        } else {
            num.classList.add('nok');
            num.classList.remove('ok');
        }
    }

    function checkPass() {
        var pass = password.value;
    
        const isAtLeast8Chars = pass.length >= 8;
        const hasLowercase = /[a-z]/.test(pass);
        const hasUppercase = /[A-Z]/.test(pass);
        const hasNumber = /\d/.test(pass);
    
        if (isAtLeast8Chars && hasLowercase && hasUppercase && hasNumber) {
            return true;
        } else {
            appendAlert('Please enter a valid password!', 'secondary');
            return false;
        }
    }

    function checkBlank(){
        if(fname.value === "" || username.value === "" || password.value === ""){
            appendAlert('Please fill in all the fields!', 'secondary');
            return false;
        }
        else{
            return true;
        }
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const areFieldsNotBlank = checkBlank();
        if (areFieldsNotBlank) {
            const isPasswordValid = checkPass();

            if (isPasswordValid) {
                console.log(form);
                form.submit();
            }
        }
    });

    password.addEventListener('input', validatePassword);
});