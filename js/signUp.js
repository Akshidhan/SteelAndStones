document.addEventListener('DOMContentLoaded', function () {
    var username = document.getElementById('username');
    var email = document.getElementById('email');
    var form = document.getElementById('signUpForm');
    var numOfChar = document.getElementById('numOfChar');
    var num = document.getElementById('num');
    var ucase = document.getElementById('ucase');
    var lcase = document.getElementById('lcase');
    var passwordHints = document.getElementById('passwordHints');
    var password = document.getElementById('password');
    var submitBtn = document.getElementById('submitBtn');
    var confirmPass = document.getElementById('confirmpass');

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
        if(email.value === "" || username.value === "" || password.value === "" || confirmPass === ""){
            appendAlert('Please fill in all the fields!', 'secondary');
            return false;
        }
        else{
            return true;
        }
    }

    function confirmPasswords(){
        if (password.value === confirmPass.value){
            return true;
        } else {
            appendAlert('Please check your passwords', 'secodary');
            return false;
        }
    }

    submitBtn.addEventListener('click', function (event) {
        event.preventDefault();
    
        const areFieldsNotBlank = checkBlank();
        if (areFieldsNotBlank) {
            const isPasswordValid = checkPass();
            if (isPasswordValid) {
                const arePasswordsMatching = confirmPasswords();
                if (arePasswordsMatching) {
                    HTMLFormElement.prototype.submit.call(form);
                }
            }
        }
    });

    password.addEventListener('input', validatePassword);
});