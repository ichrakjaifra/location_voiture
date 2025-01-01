<?php
require_once 'Categorie.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Adding a category
  if (isset($_POST['add_category'])) {
      $nom = $_POST['nom'];
      $description = $_POST['description'];

      $categorie = new Categorie(null, $nom, $description);
      Categorie::addCategory($categorie);
  }

  // Updating a category
  if (isset($_POST['update_category'])) {
      $categoryId = $_POST['categoryId'];
      $nom = $_POST['nom'];
      $description = $_POST['description'];

      $categorie = new Categorie($categoryId, $nom, $description);
      Categorie::updateCategory($categorie);
  }

  // Deleting a category
  if (isset($_POST['delete_category'])) {
    $categoryId = $_POST['categoryId']; 

    if (Categorie::deleteCategory($categoryId)) {
        echo "Category deleted successfully!";
    } else {
        echo "Failed to delete category!";
    }
}

}
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



            <!-- Categorie Table -->
            <div class="bg-white rounded-2xl shadow-sm">
    <div class="p-8 border-b border-slate-100">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-slate-800">Gestion des Catégories</h2>
            <button onclick="toggleCategoryModal()" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all duration-300">
                <i class="fas fa-plus mr-2"></i>Ajouter une Catégorie
            </button>
        </div>
    </div>

    <!-- Scrollable Table -->
    <div class="overflow-x-auto p-4">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="text-left bg-slate-50">
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Nom</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Description</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php
                // Charger les catégories depuis la base de données
                $categories = Categorie::getCategories();  // Use the static method from the Categorie class

                foreach ($categories as $categorie) {
                ?>
                    <tr class="hover:bg-slate-50 transition-all duration-300">
                        <td class="px-6 py-4 text-slate-800 font-medium"><?php echo $categorie->getNom(); ?></td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $categorie->getDescription(); ?></td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button onclick="editCategory('<?php echo $categorie->getId(); ?>', '<?php echo $categorie->getNom(); ?>', '<?php echo $categorie->getDescription(); ?>')" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                    Modifier
                                </button>
                                <form method="POST">
                                    <input type="hidden" name="categoryId" value="<?php echo $categorie->getId(); ?>">
                                    <button type="submit" name="delete_category" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal for Adding or Editing Category -->
<div id="categoryModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h3 id="modalTitle" class="text-xl font-bold text-slate-800 mb-4">Ajouter une Catégorie</h3>
        <form method="POST">
            <div class="mb-4">
                <label for="nom" class="block text-sm font-semibold text-slate-600">Nom</label>
                <input type="text" id="nom" name="nom" class="mt-2 px-4 py-2 w-full border border-slate-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold text-slate-600">Description</label>
                <textarea id="description" name="description" class="mt-2 px-4 py-2 w-full border border-slate-300 rounded-lg" required></textarea>
            </div>
            <input type="hidden" id="categoryId" name="categoryId"> <!-- Hidden field for category ID -->
            <div class="flex justify-end">
                <button type="submit" id="submitButton" name="add_category" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">Ajouter</button>
                <button type="button" onclick="closeCategoryModal()" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-xl hover:bg-gray-400">Annuler</button>
            </div>
        </form>
    </div>
</div>


<script>
    // Function to show the modal
function toggleCategoryModal() {
    document.getElementById('categoryModal').classList.toggle('hidden');
}

// Function to close the modal
function closeCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
}

// Function to pre-fill the form for editing
function editCategory(id, nom, description) {
    // Populate the form with existing category data
    document.getElementById('nom').value = nom;
    document.getElementById('description').value = description;
    document.getElementById('categoryId').value = id; // Set the hidden category ID

    // Change the title and button text for editing
    document.getElementById('modalTitle').innerText = 'Modifier une Catégorie';
    document.getElementById('submitButton').innerText = 'Modifier'; // Change button text to "Modifier"
    document.getElementById('submitButton').name = 'update_category'; // Set the button to trigger update

    toggleCategoryModal();
}

</script>

</body>
</html>