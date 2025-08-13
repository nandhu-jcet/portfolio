<?php
include('includes/db.php');

$pageTitle = "Our Services";

function getServices($conn) {
    $services = array();
    $result = $conn->query("SELECT * FROM services ORDER BY id DESC");
    while($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
    return $services;
}

$services = getServices($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Nandhakumar Sekar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <style>
        .glassmorphic {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .service-card {
            transition: transform 0.3s ease-in-out;
        }
        .service-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-blue-900 text-white min-h-screen">
    <?php include('includes/header.php'); ?>

    <section id="services" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <h1 class="text-center text-5xl font-bold mb-12 animate__animated animate__fadeInDown"><?php echo $pageTitle; ?></h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($services as $service): ?>
                <div class="service-card glassmorphic p-6 animate__animated animate__fadeIn">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-semibold"><?php echo htmlspecialchars($service['title']); ?></h3>
                        <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="<?php echo $service['icon']; ?> text-2xl text-blue-300"></i>
                        </div>
                    </div>
                    <p class="text-lg text-gray-300 mb-6"><?php echo htmlspecialchars($service['description']); ?></p>
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">Learn More</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
    
    <script>
        // Adding particles background for consistency with other pages
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: false },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 6, direction: "none", random: false, straight: false, out_mode: "out", bounce: false }
            },
            interactivity: {
                detect_on: "canvas",
                events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" }, resize: true },
                modes: { grab: { distance: 400, line_linked: { opacity: 1 } }, bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 }, repulse: { distance: 200, duration: 0.4 }, push: { particles_nb: 4 }, remove: { particles_nb: 2 } }
            },
            retina_detect: true
        });
    </script>
</body>
</html>