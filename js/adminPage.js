document.addEventListener("DOMContentLoaded", () => {
    const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
    const alertMessageElement = document.getElementById('alertModalMessage');
    const alertOkButton = document.getElementById('alertModalOkButton');

    const navLinks = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');
    const lastActiveTab = sessionStorage.getItem('lastActiveTab');
    if (lastActiveTab) {
        const lastTab = document.querySelector(`.nav-link[href="${lastActiveTab}"]`);
        if (lastTab) lastTab.click();
    }

    navLinks.forEach(link => {
        link.addEventListener("click", () => {
            sessionStorage.setItem('lastPage', window.location.href);
        });
    });

    document.querySelectorAll('[data-bs-target="#modifyModal"]').forEach(button => {
        button.addEventListener('click', () => {
            const recordType = button.getAttribute('data-type');
            const recordId = button.getAttribute('data-id');
            const username = button.getAttribute('data-username');
            const email = button.getAttribute('data-email');

            document.getElementById('recordType').value = recordType;
            document.getElementById('recordId').value = recordId;
            document.getElementById('modalUsername').value = username;
            document.getElementById('modalEmail').value = email;

            const emailField = document.getElementById('emailField');
            emailField.style.display = recordType === 'admin' ? 'none' : 'block';
        });
    });

    window.showAlert = (message, reload = false) => {
        alertMessageElement.textContent = message;
        alertModal.show();

        alertOkButton.onclick = () => {
            if (reload) location.reload();
        };
    };
});

function sortTable(section, column) {
    location.href = `test.php?sort=${section}&column=${column}`;
}

function deleteRecord(type, id) {
    fetch('delete_record.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ type, id }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, true);
        } else {
            showAlert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function submitModifyForm() {
    const form = document.getElementById('modifyForm');
    const formData = new FormData(form);

    fetch('modify_record.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function clearSessionStorage() {
    sessionStorage.clear();
}