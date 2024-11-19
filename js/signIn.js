document.addEventListener('DOMContentLoaded', function () {
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    var submitBtn = document.getElementById('submitBtn');
    var form = document.getElementById('signInForm');

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

    function checkBlank(){
        if(email.value === "" || password.value === ""){
            appendAlert('Please fill in all the fields!', 'secondary');
            return false;
        } else {
            return true
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
});