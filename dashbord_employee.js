const allDropdown = document.querySelectorAll('#sidebar .side_dropdown');
const sidebar = document.getElementById('sidebar');
allDropdown.forEach(item => {
    const a = item.parentElement.querySelector('a:first-child');
    a.addEventListener('click', function (e) {
        e.preventDefault();
        if (!this.classList.toggle('active')) {
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
    }
    allSideDivider.forEach(item => {
        item.textContent = '-'
    })
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
const profile = document.querySelector('nav .prophile');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile_link');
imgProfile.addEventListener('click', function () {
    dropdownProfile.classList.toggle('show');
})
const allMenu = document.querySelectorAll('main .content_data .head .menu');
allMenu.forEach(item => {
    const icon = item.querySelector('.icon');
    const menuLink = item.querySelector('.menu_link');
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
        const menuLink = item.querySelector('.menu_link');
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
document.addEventListener('DOMContentLoaded', function () {
    fetchProfilePicture();
});
async function updateDashboardCards() {
    try {
        const response = await fetch('fetch_dashboard_data.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        if (data.success) {
            document.querySelector('.card:nth-child(1) h2').textContent = data.data.tasks.pending;
            document.querySelector('.card:nth-child(2) h2').textContent = data.data.tasks.completed;
            document.querySelectorAll('.card:nth-child(1) .progress, .card:nth-child(2) .progress').forEach(progress => {
                progress.style.setProperty('--value', `${data.data.tasks.completion}%`);
                progress.nextElementSibling.textContent = `${data.data.tasks.completion}%`;
            });
            document.querySelector('.card:nth-child(3) h2').textContent = data.data.quizzes.pending;
            document.querySelector('.card:nth-child(3) .progress').style.setProperty('--value', `${data.data.quizzes.completion}%`);
            document.querySelector('.card:nth-child(3) .label').textContent = `${data.data.quizzes.completion}%`;
            document.querySelector('.card:nth-child(4) h2').textContent = data.data.messages.unread;
            document.querySelector('nav .nav_link:nth-child(3) .badge').textContent = data.data.messages.unread;
        }
    } catch (error) {
        console.error('Error updating dashboard:', error);
    }
}
document.addEventListener('DOMContentLoaded', function () {
    updateDashboardCards();
    fetchProfilePicture();
    setInterval(updateDashboardCards, 30000);
});

document.addEventListener('DOMContentLoaded', function () {
    const sidebarLinks = document.querySelectorAll('#sidebar a[data-section]');
    const mainSections = document.querySelectorAll('.main-section');
    const detailLink = document.querySelector('.menu_link a[data-section="messagerie"]');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            const sectionId = this.getAttribute('data-section');
            mainSections.forEach(main => main.classList.remove('active'));
            const targetMain = document.getElementById(sectionId);
            if (targetMain) {
                targetMain.classList.add('active');
            }
        });
    });

    detailLink.addEventListener('click', function (e) {
        e.preventDefault();
        sidebarLinks.forEach(link => link.classList.remove('active'));
        const messageLink = document.querySelector('#sidebar a[data-section="messagerie"]');
        messageLink.classList.add('active');
        mainSections.forEach(main => main.classList.remove('active'));
        const targetMain = document.getElementById('messagerie');
        if (targetMain) {
            targetMain.classList.add('active');
        }
    });

});