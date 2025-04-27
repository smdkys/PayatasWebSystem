<?php
session_start();

include_once("connections/connection.php");

$con = connection();

if(!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM livelihoodoffsiteform WHERE status ='finished' ORDER BY id DESC";
$request = $con->query($sql);

// Check if query was successful
if(!$request) {
    die("Query failed: " . $con->error);
}

// Fetch all rows
$rows = $request->fetch_all(MYSQLI_ASSOC);
// Add these lines near the top of your PHP file
mb_internal_encoding('UTF-8');
ini_set('default_charset', 'UTF-8');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/admin.js"></script>
    <title>ARCHIVES PAGE</title>
    <style>
        .request-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .request-card {
            background-color: #f4f4f4;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .request-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0,0,0,0.15);
        }

        .request-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            max-width: 90%; /* Expand modal width */
            width: 700px; /* Adjust as needed */
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .close-btn {
            color: red;
            float: right;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover {
            color: black;
        }
        .modal-images {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px; /* Space between images */
            width: 100%;
            flex-wrap: wrap; /* Prevent overflow */
        }

        .modal-img {
            max-width: 48%; /* Keep images responsive */
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-info {
            padding: 10px;
            text-align: left;
        }

        .modal-info p {
            font-size: 16px;
            margin: 5px 0;
        }
        .arc{
            text-align: center;     /* Center text inside the div */
            font-size: 1.5rem;       /* Approx h1 size */
            color: green;              /* Red text color */
            font-weight: bold;       /* Make it bold like an h1 */
            margin: 0 auto; 
        }
        .request-card select {
            padding: 8px 12px;
            padding-right: 32px; /* 👈 extra space for the arrow */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            outline: none;
            appearance: none;
            background-color: white;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20width='16'%20height='16'%20fill='gray'%20class='bi%20bi-caret-down-fill'%20viewBox='0%200%2016%2016'%3E%3Cpath%20d='M7.247%2011.14%202.451%205.658C2.09%205.234%202.345%204.5%202.908%204.5h10.184c.563%200%20.818.734.457%201.158L8.753%2011.14a.5.5%200%200%201-.753%200z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }

        .request-card select.status-open {
            background-color: #ffe5e5;
            color: #c0392b;
        }

        .request-card select.status-ongoing {
            background-color: #fff9e6;
            color: #f39c12;
        }

        .request-card select.status-finished {
            background-color: #e6f7e6;
            color: #27ae60;
        }
    </style>
</head>
<body>
    <header>
        <div class="header">
            <div class="title">
                <h1>Barangay Payatas</h1>
                <p>Environmental Police Department</p>
            </div>
            <div class="nav-links">
                <a href="livelihood.php" class="nav-link">Requests</a>
                <a href="livelihood_archive.php" class="nav-link active">Archives</a>
            </div>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="search-icon" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
            <div class="profile-menu">
                <div class="hamburger-menu" id="profileMenuToggle">
                    ☰
                </div>
                <div class="dropdown-menu hidden" id="profileDropdown">
                    <p>WELCOME 
                        <?php echo isset($_SESSION['UserLogin']) ? $_SESSION['UserLogin'] : "Guest"; ?>
                    </p>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="arc"><h1>ARCHIVES</h1></div>

    <div class="forms">
        <a href="spray_archive.php" class="link">Spray</a>
        <a href="puno_archive.php" class="link">Team Puno</a>
        <a href="kanal_archive.php" class="link">Linis Kanal</a>
        <a href="dogcare_archive.php" class="link">Dog Care</a>
        <a href="livelihood_archive.php" class="link active">Livelihood</a>
        <a href="debris_archive.php" class="link">Debris</a>
    </div>

    <div class="container">
        <h2>Service Request - Livelihood Forms</h2>
        <div class="forms">
        <a href="livelihood_archive.php" class="link active">Livelihood Off-Site</a>
        <a href="livelihoodon_archive.php" class="link">Livelihood On-Site</a>
        </div>
        
        <div class="request-grid" id="requestGrid">
            <?php if(!empty($rows)): ?>
                <?php foreach($rows as $row): ?>
                    <div class="request-card" data-id="<?php echo $row['id']; ?>">
                        <img src="limage2.php?id=<?php echo $row['id']; ?>" alt="ID Image">
                        <h3><?php echo $row['fullname']; ?></h3>
                        <p><?php echo $row['date']; ?></p>
                        <select onchange="updateStatus(<?php echo $row['id']; ?>, this.value)">
                            <option value="open" <?php echo $row['status'] == 'open' ? 'selected' : ''; ?>>Pending</option>
                            <option value="finished" <?php echo $row['status'] == 'finished' ? 'selected' : ''; ?>>Finished</option>
                        </select>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No records found</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="requestModal" class="modal">
        <div class="modal-content">

            <div id="modalDetails"></div>
        </div>
    </div>

    <script>
        function updateStatus(id, newStatus) {
            fetch('livelihood_update_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: id, status: newStatus})
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Status updated!');
                    // Optionally remove from view if finished:
                    if (newStatus === 'finished') {
                        document.querySelector(`.request-card[data-id="${id}"]`).remove();
                    }
                } else {
                    alert('Failed to update status.');
                }
            });
        }

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
                filterCards(searchTerm);
            });
            
            document.querySelectorAll('.request-card select').forEach(select => {
                select.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent modal from opening
                });
            });

            // Function to filter request cards based on search term
            function filterCards(searchTerm) {
                const cards = document.querySelectorAll('.request-card');
                
                cards.forEach(card => {
                    let found = false;
                    const cardText = card.textContent.toLowerCase();
                    
                    // Check if card content contains the search term
                    if (cardText.includes(searchTerm)) {
                        found = true;
                    }
                    
                    // Show or hide card based on search match
                    if (found) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Check if no results are found
                const visibleCards = document.querySelectorAll('.request-card[style="display: block;"]');
                const requestGrid = document.getElementById('requestGrid');
                
                if (visibleCards.length === 0 && searchTerm !== '') {
                    // Create no results message if it doesn't exist
                    let noResults = document.getElementById('no-results-message');
                    if (!noResults) {
                        noResults = document.createElement('p');
                        noResults.id = 'no-results-message';
                        noResults.textContent = 'No results found.';
                        noResults.style.textAlign = 'center';
                        noResults.style.width = '100%';
                        noResults.style.padding = '20px';
                        requestGrid.appendChild(noResults);
                    }
                } else {
                    // Remove no results message if it exists
                    const noResults = document.getElementById('no-results-message');
                    if (noResults) {
                        noResults.remove();
                    }
                }
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

        // Add click event to request cards
        document.getElementById('requestGrid').addEventListener('click', function(e) {
            const card = e.target.closest('.request-card');
            if (card) {
                const requestId = card.getAttribute('data-id');
                showRequestDetails(requestId);
            }
        });

        function showRequestDetails(id) {
    console.log('Fetching details for ID:', id);

    fetch(`livelihood_get_request_details.php?id=${id}`)
        .then(response => {
            console.log('Full response object:', response);
            
            // Log response status and headers
            console.log('Response status:', response.status);
            console.log('Response headers:', Object.fromEntries(response.headers));
            
            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            // Get response text first for debugging
            return response.text();
        })
        .then(text => {
            console.log('Raw response text:', text);
            
            // Try parsing JSON
            try {
                const data = JSON.parse(text);
                console.log('Parsed data:', data);
                return data;
            } catch (jsonError) {
                console.error('JSON Parse Error:', jsonError);
                console.log('Problematic text:', text);
                throw new Error('Failed to parse JSON: ' + text);
            }
        })
        .then(data => {
            // Check for error in the response
            if (data.error) {
                throw new Error(data.error);
            }

            const modalDetails = document.getElementById('modalDetails');
            modalDetails.innerHTML = `
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2 class="modal-title">Request Details</h2>
                <div class="modal-images">
                    <img src="limage.php?id=${data.id}" alt="ID Image" class="modal-img">
                    <img src="limage2.php?id=${data.id}" alt="Additional Image" class="modal-img">
                </div>
                <div class="modal-info">
                    <p><strong>Name:</strong> ${data.fullname}</p>
                    <p><strong>Contact:</strong> ${data.contact}</p>
                    <p><strong>Location:</strong> ${data.location}</p>
                    <p><strong>Program Type:</strong> ${data.program_type}</p>
                    <p><strong>Participants:</strong> ${data.participants}</p>
                    <p><strong>Date:</strong> ${data.date}</p>
                    <p><strong>Time:</strong> ${data.time}</p>
                </div>
            `;
            document.getElementById('requestModal').style.display = 'block';
        })
        .catch(error => {
            // More verbose error handling
            console.error('Complete Error Details:', error);
            console.error('Error Name:', error.name);
            console.error('Error Message:', error.message);
            console.error('Error Stack:', error.stack);
            
            // Show a more informative alert
            alert('Failed to load request details. Error: ' + error.message);
        });
}

        // Function to close modal
        function closeModal() {
            document.getElementById('requestModal').style.display = 'none';
        }

        // Close modal if clicked outside of content
        window.onclick = function(event) {
            const modal = document.getElementById('requestModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        function applyDropdownStyles() {
            document.querySelectorAll('.request-card select').forEach(select => {
                const value = select.value;
                select.classList.remove('status-open', 'status-ongoing', 'status-finished');
                select.classList.add('status-' + value);
            });
        }

        // Call it on load
        document.addEventListener('DOMContentLoaded', function() {
            applyDropdownStyles();

            // Update class when status changes
            document.querySelectorAll('.request-card select').forEach(select => {
                select.addEventListener('change', function() {
                    applyDropdownStyles();
                });

                // Prevent dropdown from triggering modal
                select.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });
        });
    </script>
</body>
</html>