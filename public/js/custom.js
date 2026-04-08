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

// Animated counters
function animateCounters() {
    $('.counter').each(function() {
        const $this = $(this);
        const target = parseInt($this.data('target'));
        if (isNaN(target)) return;
        
        let current = 0;
        const increment = Math.ceil(target / 30);
        const updateCounter = setInterval(() => {
            current += increment;
            if (current >= target) {
                $this.text(target);
                clearInterval(updateCounter);
            } else {
                $this.text(current);
            }
        }, 30);
    });
}

// Trigger counters when dashboard is visible
$(document).ready(function() {
    if ($('.counter').length) {
        animateCounters();
    }

    function updateCartCount() {
    $.get('/cart/getCartCount', function(data) {
        $('#cart-count').text(data.count);
    });
}
// Call after add/remove

});