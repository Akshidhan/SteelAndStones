document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');

    const lastActiveTab = sessionStorage.getItem('lastActiveTab');
    if (lastActiveTab) {
      const lastTab = document.querySelector(`.nav-link[href="${lastActiveTab}"]`);
      if (lastTab) {
        lastTab.click();
      }
    }

    navLinks.forEach(link => {
      link.addEventListener("click", (e) => {
        sessionStorage.setItem('lastPage', window.location.href);
      });
    });
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
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}


function showModifyModal(type, id) {
    document.getElementById('recordType').value = type;
    document.getElementById('recordID').value = id;

    fetch(`fetch_record.php?type=${type}&id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modifyUsername').value = data.username;
            document.getElementById('modifyEmail').value = data.email || '';
            document.getElementById('modifyPassword').value = data.password;
            new bootstrap.Modal(document.getElementById('modifyModal')).show();
        });
}

function clearSessionStorage() {
    sessionStorage.clear();
}