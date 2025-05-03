const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('form') === 'register') {
    container.classList.add('active');
}
registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});
loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});
document.querySelector('.register form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast();
            this.reset();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
});

const toast = document.querySelector(".toast");
const closeIcon = document.querySelector(".close");
const progress = document.querySelector(".progress");
function showToast(){
    toast.classList.add("active");
    progress.classList.add("active");
    setTimeout(() =>{
        toast.classList.remove("active");
    }, 5000);
    setTimeout(() =>{
        toast.classList.remove("active");
    }, 5300);
    closeIcon.addEventListener("click", () =>{
        toast.classList.remove("active");
        setTimeout(() =>{
            toast.classList.remove("active");
        }, 300);
    });
}
window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    if (params.get('registered') === 'true') {
      showToast();
    }
  });