<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        .glassmorphic {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .success-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4caf50;
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            animation: slide-down 0.5s ease-in-out;
        }
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-blue-900 text-white min-h-screen">
    <?php include('includes/header.php'); ?>

    <div id="successMessageContainer"></div>

    <section id="contact" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl font-bold mb-8 animate__animated animate__fadeInDown">Contact Me</h1>
            <p class="text-xl mb-12 animate__animated animate__fadeIn">Feel free to reach out for collaborations, project inquiries, or just to say hi!</p>
            <div class="flex flex-col md:flex-row justify-between items-start space-y-8 md:space-y-0 md:space-x-8">
                <form id="contactForm" class="glassmorphic p-8 rounded-lg mx-auto w-full md:w-1/2 animate__animated animate__fadeInLeft">
                    <div class="mb-6">
                        <label for="name" class="block text-lg font-semibold mb-2">Name</label>
                        <input type="text" id="name" name="name" class="w-full bg-gray-800 rounded px-3 py-2 text-white" required>
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block text-lg font-semibold mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full bg-gray-800 rounded px-3 py-2 text-white" required>
                    </div>
                    <div class="mb-6">
                        <label for="mobile" class="block text-lg font-semibold mb-2">Mobile</label>
                        <input type="tel" id="mobile" name="mobile" class="w-full bg-gray-800 rounded px-3 py-2 text-white" required>
                    </div>
                    <div class="mb-6">
                        <label for="message" class="block text-lg font-semibold mb-2">Message</label>
                        <textarea id="message" name="message" class="w-full bg-gray-800 rounded px-3 py-2 text-white h-32" required></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105 w-full">Send Message</button>
                </form>
                <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
                    <div id="globe" class="mx-auto" style="width: 300px; height: 300px;"></div>
                </div>
            </div>
        </div>
    </section>
    <?php include('includes/footer.php'); ?>
    <script>
        // Globe visualization
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, 300 / 300, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(300, 300);
        document.getElementById('globe').appendChild(renderer.domElement);
        const geometry = new THREE.SphereGeometry(1, 32, 32);
        const material = new THREE.MeshBasicMaterial({color: 0x3498db, wireframe: true});
        const globe = new THREE.Mesh(geometry, material);
        scene.add(globe);
        camera.position.z = 2;
        function animate() {
            requestAnimationFrame(animate);
            globe.rotation.x += 0.01;
            globe.rotation.y += 0.01;
            renderer.render(scene, camera);
        }
        animate();

        // Handle form submission via AJAX
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('send_message.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Message sent successfully')) {
                    const successMessage = document.createElement('div');
                    successMessage.className = 'success-message';
                    successMessage.textContent = 'Your message has been sent successfully!';
                    
                    const successMessageContainer = document.getElementById('successMessageContainer');
                    successMessageContainer.innerHTML = '';
                    successMessageContainer.appendChild(successMessage);

                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                } else {
                    alert('Failed to send message. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>