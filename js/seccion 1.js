document.querySelectorAll('.user-button').forEach(button => {
    button.addEventListener('click', function() {
      const userName = this.querySelector("span").textContent;
      alert(`Bienvenido, ${userName}`);
    });
  });
  