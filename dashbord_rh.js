const allDropdown = document.querySelectorAll('#sidebar .side_dropdown');
const sidebar = document.getElementById('sidebar');
allDropdown.forEach(item => {
    const a = item.parentElement.querySelector('a:first-child');
    a.addEventListener('click', function (e) {
        e.preventDefault();
        if (!this.classList.contains('active')) {
            allDropdown.forEach(i => {
                const aLink = i.parentElement.querySelector('a:first-child');
                aLink.classList.remove('active');
                i.classList.remove('show');
            })
        }
        this.classList.toggle('active');
        item.classList.toggle('show');
    })
})
const toggleSidebar = document.querySelector('nav .toggle_sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');
if (sidebar.classList.contains('hide')) {
    allSideDivider.forEach(item => {
        item.textContent = '-'
    })
} else {
    allSideDivider.forEach(item => {
        item.textContent = item.dataset.text;
    })
}
toggleSidebar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');
    if (sidebar.classList.contains('hide')) {
        allSideDivider.forEach(item => {
            item.textContent = '-'
        })
    } else {
        allSideDivider.forEach(item => {
            item.textContent = item.dataset.text;
        })
    }
})
sidebar.addEventListener('mouseleave', function () {
    if (this.classList.contains('hide')) {
        allDropdown.forEach(item => {
            const a = item.parentElement.querySelector('a:first-child');
            a.classList.remove('active');
            item.classList.remove('show');
        })
        allSideDivider.forEach(item => {
            item.textContent = '-'
        })
    }
})
sidebar.addEventListener('mouseenter', function () {
    if (this.classList.contains('hide')) {
        allDropdown.forEach(item => {
            const a = item.parentElement.querySelector('a:first-child');
            a.classList.remove('active');
            item.classList.remove('show');
        })
        allSideDivider.forEach(item => {
            item.textContent = item.dataset.text;
        })
    }
})
const profile = document.querySelector('nav .profile');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile_link');
imgProfile.addEventListener('click', function () {
    dropdownProfile.classList.toggle('show');
})
const allMenu = document.querySelectorAll('main .content_data .head .menu');
allMenu.forEach(item => {
    const icon = item.querySelector('.icon');
    const menuLink = item.querySelector('.menu_links');
    icon.addEventListener('click', function () {
        menuLink.classList.toggle('show');
    })
})
window.addEventListener('click', function (e) {
    if (e.target !== imgProfile) {
        if (e.target !== dropdownProfile) {
            if (dropdownProfile.classList.contains('show')) {
                dropdownProfile.classList.remove('show');
            }
        }
    }
    allMenu.forEach(item => {
        const icon = item.querySelector('.icon');
        const menuLink = item.querySelector('.menu_links');
        if (e.target !== icon) {
            if (e.target !== menuLink) {
                if (menuLink.classList.contains('show')) {
                    menuLink.classList.remove('show');
                }
            }
        }
    })
})
const allProgress = document.querySelectorAll('main .card .progress');
allProgress.forEach(item => {
    item.style.setProperty('--value', item.dataset.value)
})
async function fetchProfilePicture() {
    try {
        const response = await fetch('get_profile_pic.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        if (data.success && data.profile_pic) {
            document.querySelectorAll('.profile img, .prophile img').forEach(img => {
                img.src = data.profile_pic;
                img.onerror = () => {
                    img.src = 'Images/default_profile.jpg';
                };
            });
        }
    } catch (error) {
        console.error('Error fetching profile picture:', error);
        document.querySelectorAll('.profile img, .prophile img').forEach(img => {
            img.src = 'Images/default_profile.jpg';
        });
    }
}
document.addEventListener('DOMContentLoaded', function() {
    fetchProfilePicture();
});