<script src="{{ asset('admin_assets/js/plugins/chartjs.min.js') }}" async></script>
<script src="{{ asset('admin_assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{ asset('admin_assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5') }}" async></script>

<script>
  // SIDEBAR TOGGLE LOGIC
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-sidebar');

    // State management
    let isHidden = false;

    // Toggle function
    function toggleSidebar() {
      if (isHidden) {
        // Show sidebar with animation
        sidebar.classList.remove('opacity-0', 'scale-95', '-translate-x-full');
        sidebar.classList.add('opacity-100', 'scale-100', 'translate-x-0');
        toggleBtn.innerHTML = '<i class="fas fa-bars text-sm"></i>';
        toggleBtn.title = 'Hide Sidebar';
        isHidden = false;
      } else {
        // Hide sidebar with animation
        sidebar.classList.remove('opacity-100', 'scale-100', 'translate-x-0');
        sidebar.classList.add('opacity-0', 'scale-95', '-translate-x-full');
        toggleBtn.innerHTML = '<i class="fas fa-bars text-sm"></i>';
        toggleBtn.title = 'Show Sidebar';
        isHidden = true;
      }
    }

    // Attach event listener
    toggleBtn.addEventListener('click', toggleSidebar);
  });
</script>
