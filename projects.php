<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .project-card {
            transition: transform 0.3s ease-in-out;
        }
        .project-card:hover {
            transform: translateY(-5px);
        }
        .glassmorphic {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-blue-900 text-white min-h-screen">
    <?php include('includes/header.php'); ?>
    <?php include('includes/db.php'); ?>

    <section id="projects" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <h1 class="text-center text-5xl font-bold mb-12 animate__animated animate__fadeInDown">My Projects</h1>

            <div id="projects-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $result = $conn->query("SELECT * FROM projects");

                if ($result && $result->num_rows > 0) {
                    while ($project = $result->fetch_assoc()) {
                        echo "
                        <div class='project-card glassmorphic p-6 animate__animated animate__fadeIn'>
                            <img src='assets/images/project_images/{$project['image']}' alt='{$project['title']}' class='w-full h-48 object-cover rounded-lg mb-4'>
                            <h3 class='text-2xl font-semibold mb-2'>{$project['title']}</h3>
                            <p class='text-sm text-gray-300 mb-4'>Technologies: {$project['languages']}</p>
                            <a href='project_details.php?id={$project['id']}' class='inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105'>View Details</a>
                        </div>
                        ";
                    }
                } else {
                    echo "<p class='text-center text-xl col-span-full'>No projects found. Add some projects from the admin panel.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>

