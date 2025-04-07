function toggleManagementModal() {
  const modal = document.getElementById('management-modal');
  modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
}

function handleManagementUser(name) {
  if (name.toLowerCase() === 'admin') {
      document.getElementById('management-modal').style.display = 'none';
      document.getElementById('admin-password-modal').style.display = 'flex';
  } else {
      window.location.href = 'tables.php?users=' + encodeURIComponent(name);
  }
}