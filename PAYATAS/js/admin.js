document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    
    // Check if searchInput exists
    if (!searchInput) {
        console.error('Search input element not found!');
        return;
    }
    
    // Add event listener for search input
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        filterTable(searchTerm);
    });
    
    // Function to filter table rows based on search term
    function filterTable(searchTerm) {
        const rows = document.querySelectorAll('#formData tr.data-row');
        
        rows.forEach(row => {
            let found = false;
            const cells = row.querySelectorAll('td');
            
            // Check each cell in the row
            cells.forEach(cell => {
                const cellText = cell.textContent.toLowerCase();
                if (cellText.includes(searchTerm)) {
                    found = true;
                }
            });
            
            // Show or hide row based on search match
            if (found) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }
    
    // Add click event for mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', function() {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        });
    }
});

    document.addEventListener('DOMContentLoaded', function () {
    const profileMenuToggle = document.getElementById('profileMenuToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profileMenuToggle && profileDropdown) {
        profileMenuToggle.addEventListener('click', function (event) {
            profileDropdown.classList.toggle('active');
            event.stopPropagation();
        });

        document.addEventListener('click', function (event) {
            if (!profileDropdown.contains(event.target) && event.target !== profileMenuToggle) {
                profileDropdown.classList.remove('active');
            }
        });
    }
});