<?php
include('Database.php');
include('Reservation.php');

$db = new Database();
$conn = $db->connect();

$query = "SELECT reservations.*, utilisateurs.nom AS utilisateur_nom, vehicules.modele AS vehicule_modele 
          FROM reservations
          JOIN utilisateurs ON reservations.utilisateur_id = utilisateurs.id
          JOIN vehicules ON reservations.vehicule_id = vehicules.id";
$reservations = $db->fetchAll($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients Management - TravelEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .ocean-gradient {
            background: linear-gradient(135deg, #034694 0%, #00a7b3 100%);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 ocean-gradient text-white py-8 px-6 fixed h-full">
    <div class="flex items-center mb-12">
        <span class="text-2xl font-bold tracking-wider">Drive & Loc</span>
    </div>

    <nav class="space-y-6">
        <a href="dashboord.php" class="flex items-center space-x-4 px-6 py-4 bg-white bg-opacity-10 rounded-xl">
            <i class="fas fa-th-large text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        <a href="users.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-users text-lg"></i>
            <span class="font-medium">Users</span>
        </a>
        <a href="reserv.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-calendar-check text-lg"></i>
            <span class="font-medium">Reservations</span>
        </a>

      
        <div class="relative">
            <a href="#" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl" id="toggleVehicules">
                <i class="fas fa-car text-lg"></i>
                <span class="font-medium">Véhicules</span>
            </a>

            
            <ul class="absolute left-0 w-full bg-white bg-opacity-10 rounded-xl mt-2 hidden" id="vehiculesDropdown">
                <li>
                    <a href="vehicules.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                        <i class="fas fa-car text-lg"></i>
                        <span class="font-medium">Véhicules</span>
                    </a>
                </li>
                <li>
                    <a href="categories.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                        <i class="fas fa-th-large text-lg"></i>
                        <span class="font-medium">Catégories</span>
                    </a>
                </li>
            </ul>
        </div>

        <a href="AvisClients.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-comments text-lg"></i>
            <span class="font-medium">Avis Clients</span>
        </a>
        <a href="#" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-cog text-lg"></i>
            <span class="font-medium">Settings</span>
        </a>
    </nav>
</aside>

<script>
    const toggleButton = document.getElementById('toggleVehicules');
    const dropdownMenu = document.getElementById('vehiculesDropdown');

    toggleButton.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownMenu.classList.toggle('hidden'); // Affiche ou cache le menu
    });

    window.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            dropdownMenu.classList.add('hidden'); // Cache le menu si on clique en dehors
        }
    });
</script>

        <!-- Main Content -->
        <main class="flex-1 ml-72 p-8">
            <!-- Top Navigation -->
            <div class="flex justify-between items-center mb-12 bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="relative">
                        <input type="text" placeholder="Search clients..." 
                               class="pl-12 pr-4 py-3 bg-slate-50 rounded-xl w-72 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                        <i class="fas fa-search absolute left-4 top-4 text-slate-400"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <button class="relative p-2 bg-slate-50 rounded-xl hover:bg-slate-100 transition-all duration-300">
                            <i class="fas fa-bell text-slate-600 text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">3</span>
                        </button>
                    </div>
                    <!-- Admin Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center bg-slate-50 rounded-xl p-2 pr-4 hover:bg-slate-100 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center text-white font-bold mr-3">
                                TA
                            </div>
                            <span class="font-medium text-slate-700">Admin</span>
                            <i class="fas fa-chevron-down ml-3 text-slate-400 transition-transform group-hover:rotate-180"></i>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50">
                            <a href="#" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <hr class="my-2 border-slate-100">
                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-slate-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>


             <!-- table reservation -->
            <div class="bg-white rounded-2xl shadow-sm">
    <div class="p-8 border-b border-slate-100">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-slate-800">Reservation Management</h2>
            <!-- Add New Reservation Button (optional) -->
            <button class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all duration-300">
                <i class="fas fa-plus mr-2"></i>Add New Reservation
            </button>
        </div>
    </div>
    <div class="overflow-x-auto p-4">
        <table class="w-full">
            <thead>
                <tr class="text-left">
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">User</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Vehicle</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Start Date</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">End Date</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Location</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($reservations as $reservation): ?>
                <tr class="hover:bg-slate-50 transition-all duration-300">
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-800"><?= htmlspecialchars($reservation['utilisateur_nom']); ?></p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-800"><?= htmlspecialchars($reservation['vehicule_modele']); ?></p>
                    </td>
                    <td class="px-6 py-4"><?= htmlspecialchars($reservation['date_debut']); ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($reservation['date_fin']); ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($reservation['lieu']); ?></td>
                    <td class="px-6 py-4">
    <a href="accept_reservation.php?id=<?= $reservation['id']; ?>" class="text-green-500 hover:text-green-700">
        <i class="fas fa-check-circle"></i> <!-- Accept Icon -->
    </a>
    <a href="reject_reservation.php?id=<?= $reservation['id']; ?>" class="text-red-500 hover:text-red-700 ml-4" onclick="return confirm('Are you sure you want to reject this reservation?')">
        <i class="fas fa-times-circle"></i> <!-- Reject Icon -->
    </a>
</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>