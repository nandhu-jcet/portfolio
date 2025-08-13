<?php
include('includes/db.php');

// Fetch skills from the database
$query = "SELECT * FROM skills ORDER BY category, name";
$result = $conn->query($query);

if ($result === false) {
    die("Database error: " . $conn->error);
}
$skills = $result->fetch_all(MYSQLI_ASSOC);

// Group skills by category
$skillsByCategory = [];
foreach ($skills as $skill) {
    $skillsByCategory[$skill['category']][] = $skill;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Skills</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .skill-card {
            transition: transform 0.3s ease-in-out;
        }
        .skill-card:hover {
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
    <section id="skills" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <h1 class="text-center text-5xl font-bold mb-12 animate__animated animate__fadeInDown">My Skills</h1>

            <div class="flex flex-wrap justify-center mb-8 animate__animated animate__fadeIn">
                <?php foreach (array_keys($skillsByCategory) as $category): ?>
                    <button class="btn-secondary mx-2 my-2 skill-tab" data-tab="<?php echo htmlspecialchars($category); ?>">
                        <?php echo htmlspecialchars(ucfirst($category)); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div id="skills-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($skillsByCategory as $category => $categorySkills): ?>
                    <?php foreach ($categorySkills as $skill): ?>
                        <div class="skill-card glassmorphic p-6 animate__animated animate__fadeIn" data-tab="<?php echo htmlspecialchars($category); ?>">
                            <h3 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($skill['name']); ?></h3>
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                                    <div style="width: <?php echo htmlspecialchars($skill['proficiency']); ?>%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-300"><?php echo htmlspecialchars($skill['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php include('includes/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.skill-tab').click(function() {
                const tab = $(this).data('tab');
                $('.skill-card').hide();
                $(`.skill-card[data-tab="${tab}"]`).show();
                $('.skill-tab').removeClass('bg-blue-600');
                $(this).addClass('bg-blue-600');
            });

            $('.skill-tab:first').click();
        });
    </script>
</body>
</html>
