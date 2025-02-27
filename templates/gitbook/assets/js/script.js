$(document).ready(function() {
        if ($(window).width() <= 768) {
            $('#sidebar').addClass('collapsed');
            $('#toggleSidebar').html(`
            <i class="w-4 h-4 fa-regular fa-left"></i>
          `);
        }

        let isCollapsed = $(window).width() <= 768;
        $('#toggleSidebar').click(function() {
            isCollapsed = !isCollapsed;
            $('#sidebar').toggleClass('collapsed');
            $(this).html(`
            <i class="${isCollapsed ? 'w-4 h-4 fa-regular fa-left' : 'w-4 h-4 fa-regular fa-right'}"></i>
          `);
        });

        let isDark = false;
        $('#toggleTheme').click(function() {
            isDark = !isDark;
            $('html').attr('data-bs-theme', isDark ? 'dark' : 'light');
            $(this).html(`
            <i class="${isDark ? 'w-4 h-4 fa-regular fa-sun' : 'w-4 h-4 fa-regular fa-moon'}"></i>
          `);
        });
    });