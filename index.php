<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nandhakumar Sekar - Data Scientist & Full-Stack Developer</title>
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
        .typewriter {
            overflow: hidden;
            border-right: .15em solid orange;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .15em;
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite;
        }
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: orange; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-blue-900 text-white min-h-screen">
    <?php include('includes/header.php'); ?>

    <section id="hero" class="h-screen relative overflow-hidden flex items-center justify-center">
        <div id="particles-js" class="absolute top-0 left-0 w-full h-full z-0"></div>
        <div class="z-10 text-center animate__animated animate__fadeIn">
            <h1 class="text-4xl md:text-6xl font-bold tracking-wide mb-4">
                <span class="typewriter">Hi, I'm Nandhakumar Sekar </span>
            </h1>
            <p class="text-xl mt-4 mb-8">A Full-Stack Developer & AI Tools Expert</p>
            <div class="space-x-4">
                <a href="#about" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">Learn More</a>
                <a href="#contact" class="bg-transparent hover:bg-blue-700 text-blue-500 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded transition duration-300 ease-in-out transform hover:scale-105">Contact Me</a>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <h2 class="text-center text-4xl font-bold mb-12 animate__animated animate__fadeInDown">About Me</h2>
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <img src="me.png" alt="Nandhakumar Sekar" class="rounded-lg shadow-lg w-full max-w-md mx-auto">
                </div>
                <div class="md:w-1/2 md:pl-8">
                    <p class="text-lg leading-relaxed mb-6">
                        I'm a passionate developer with expertise in Data Science, Machine Learning, and Full-Stack Web Development. With a strong background in both front-end and back-end technologies, I create innovative solutions that drive business growth and user engagement.
                    </p>
                    <p class="text-lg leading-relaxed mb-6">
                        My goal is to leverage cutting-edge technologies to solve complex problems and create seamless user experiences. Whether it's developing predictive models or building responsive web applications, I'm always excited to take on new challenges.
                    </p>
                    <a href="#contact" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out inline-block">Get in Touch</a>
                </div>
            </div>
        </div>
    </section>

    <section id="skills" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-800">
        <div class="container mx-auto">
            <h2 class="text-center text-4xl font-bold mb-12 animate__animated animate__fadeInDown">My Skills</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $skills = [
                    ['name' => 'Python', 'level' => 90],
                    ['name' => 'Machine Learning', 'level' => 85],
                    ['name' => 'JavaScript', 'level' => 80],
                    ['name' => 'React', 'level' => 75],
                    ['name' => 'Node.js', 'level' => 70],
                    ['name' => 'SQL', 'level' => 85]
                ];
                foreach ($skills as $skill) {
                    echo "
                    <div class='glassmorphic p-6 animate__animated animate__fadeIn'>
                        <h3 class='text-xl font-semibold mb-4'>{$skill['name']}</h3>
                        <div class='relative pt-1'>
                            <div class='overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200'>
                                <div style='width: {$skill['level']}%' class='shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500'></div>
                            </div>
                        </div>
                        <p class='text-sm text-gray-300'>{$skill['level']}% proficiency</p>
                    </div>
                    ";
                }
                ?>
            </div>
        </div>
    </section>

    <section id="contact" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-8 animate__animated animate__fadeInDown">Get in Touch</h2>
            <p class="text-xl mb-12 animate__animated animate__fadeIn">I'm always open to new opportunities and collaborations. Feel free to reach out!</p>

            <form action="send_message.php" method="POST" class="glassmorphic p-8 rounded-lg mx-auto max-w-md animate__animated animate__fadeInUp">
                <div class="mb-6">
                    <label for="name" class="block text-lg font-semibold mb-2">Name</label>
                    <input type="text" id="name" name="name" class="w-full bg-gray-800 rounded px-3 py-2 text-white" required>
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-lg font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full bg-gray-800 rounded px-3 py-2 text-white" required>
                </div>
                <div class="mb-6">
                    <label for="message" class="block text-lg font-semibold mb-2">Message</label>
                    <textarea id="message" name="message" class="w-full bg-gray-800 rounded px-3 py-2 text-white h-32" required></textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105 w-full">Send Message</button>
            </form>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>

    <script>
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

