<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/tailwind.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
    <?php include('includes/header.php'); ?>

    <section id="about" class="py-20">
        <div class="container mx-auto flex flex-col lg:flex-row items-center">
            <!-- Image Gallery -->
            <div class="lg:w-1/2">
                <img src="me.png" alt="My Profile" class="rounded-lg shadow-lg">
            </div>
            <!-- About Content -->
            <div class="lg:w-1/2 mt-10 lg:mt-0">
                <h1 class="text-4xl font-bold mb-4">About Me</h1>
                <br>
                <br>
                <p class="text-lg leading-relaxed">I'm a passionate developer with expertise in Data Science, Machine Learning, and Full-Stack Web Development...</p>
                <br>
                <br>
                <a href="contact.php" class="btn-primary mt-6">Contact Me</a>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
</body>
</html>
