$(document).ready(function() {
    // Initialize DataTables
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            responsive: true,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    }
    
    // Auto-hide alerts after 4 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 4000);
    
    // Theme handling
    initTheme();
    $('#themeToggle').on('click', toggleTheme);
});

function initTheme() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        $('body').addClass('dark');
        $('#themeIcon').removeClass('fa-moon').addClass('fa-sun');
        $('#themeText').text('Light Mode');
    } else {
        $('body').removeClass('dark');
        $('#themeIcon').removeClass('fa-sun').addClass('fa-moon');
        $('#themeText').text('Dark Mode');
    }
}

function toggleTheme() {
    if ($('body').hasClass('dark')) {
        $('body').removeClass('dark');
        localStorage.setItem('theme', 'light');
        $('#themeIcon').removeClass('fa-sun').addClass('fa-moon');
        $('#themeText').text('Dark Mode');
    } else {
        $('body').addClass('dark');
        localStorage.setItem('theme', 'dark');
        $('#themeIcon').removeClass('fa-moon').addClass('fa-sun');
        $('#themeText').text('Light Mode');
    }
}

// Optional: Mobile sidebar toggle (if you add a hamburger menu)
function toggleSidebar() {
    $('.sidebar').toggleClass('open');
}