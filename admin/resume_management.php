<?php
include('../includes/db.php');

$pageTitle = "Manage Resume";
$message = '';

$result = $conn->query("SELECT * FROM resume LIMIT 1");
$resume = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $title = htmlspecialchars($_POST['title']);
    $summary = $_POST['summary'];
    $skills = json_encode(array_map(function($skill, $level) {
        return ['name' => htmlspecialchars($skill), 'level' => intval($level)];
    }, $_POST['skill_name'] ?? [], $_POST['skill_level'] ?? []));
    $education = json_encode(array_map(function($degree, $institution, $year) {
        return [
            'degree' => htmlspecialchars($degree),
            'institution' => htmlspecialchars($institution),
            'year' => htmlspecialchars($year)
        ];
    }, $_POST['edu_degree'] ?? [], $_POST['edu_institution'] ?? [], $_POST['edu_year'] ?? []));
    $experience = json_encode(array_map(function($position, $company, $year, $description) {
        return [
            'position' => htmlspecialchars($position),
            'company' => htmlspecialchars($company),
            'year' => htmlspecialchars($year),
            'description' => htmlspecialchars($description)
        ];
    }, $_POST['exp_position'] ?? [], $_POST['exp_company'] ?? [], $_POST['exp_year'] ?? [], $_POST['exp_description'] ?? []));
    $social_links = json_encode(array_combine($_POST['social_platform'] ?? [], array_map('htmlspecialchars', $_POST['social_url'] ?? [])));

    if ($resume) {
        $stmt = $conn->prepare("UPDATE resume SET name = ?, title = ?, summary = ?, skills = ?, education = ?, experience = ?, social_links = ? WHERE id = ?");
        if ($stmt === false) {
            $message = "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("sssssssi", $name, $title, $summary, $skills, $education, $experience, $social_links, $resume['id']);
            if ($stmt->execute()) {
                $message = "Resume data saved successfully!";
            } else {
                $message = "Error saving resume data: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO resume (name, title, summary, skills, education, experience, social_links) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            $message = "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("sssssss", $name, $title, $summary, $skills, $education, $experience, $social_links);
            if ($stmt->execute()) {
                $message = "Resume data saved successfully!";
            } else {
                $message = "Error saving resume data: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$result = $conn->query("SELECT * FROM resume LIMIT 1");
$resume = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>

    <main class="ml-64 p-8 pt-24">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Manage Resume</h1>

        <?php if ($message): ?>
            <p class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="<?php echo $resume['name'] ?? ''; ?>" required>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="<?php echo $resume['title'] ?? ''; ?>" required>
            </div>

            <div class="mb-4">
                <label for="summary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Summary</label>
                <textarea id="summary" name="summary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" rows="4"><?php echo $resume['summary'] ?? ''; ?></textarea>
            </div>

            <!-- Skills Section -->
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Skills</h3>
                <div id="skills-container">
                    <?php
                    $skills = json_decode($resume['skills'] ?? '[]', true);
                    foreach ($skills as $index => $skill) {
                        echo '<div class="flex mb-2">';
                        echo '<input type="text" name="skill_name[]" class="mr-2 flex-grow rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($skill['name']) . '" placeholder="Skill name" required>';
                        echo '<input type="number" name="skill_level[]" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . $skill['level'] . '" min="0" max="100" placeholder="%" required>';
                        echo '<button type="button" class="ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="removeSkill(this)">Remove</button>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="addSkill()">Add Skill</button>
            </div>

            <!-- Education Section -->
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Education</h3>
                <div id="education-container">
                    <?php
                    $education = json_decode($resume['education'] ?? '[]', true);
                    foreach ($education as $index => $edu) {
                        echo '<div class="mb-2 p-4 border border-gray-200 dark:border-gray-700 rounded">';
                        echo '<input type="text" name="edu_degree[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($edu['degree']) . '" placeholder="Degree" required>';
                        echo '<input type="text" name="edu_institution[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($edu['institution']) . '" placeholder="Institution" required>';
                        echo '<input type="text" name="edu_year[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($edu['year']) . '" placeholder="Year" required>';
                        echo '<button type="button" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="removeEducation(this)">Remove</button>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="addEducation()">Add Education</button>
            </div>

            <!-- Experience Section -->
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Experience</h3>
                <div id="experience-container">
                    <?php
                    $experience = json_decode($resume['experience'] ?? '[]', true);
                    foreach ($experience as $index => $exp) {
                        echo '<div class="mb-2 p-4 border border-gray-200 dark:border-gray-700 rounded">';
                        echo '<input type="text" name="exp_position[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($exp['position']) . '" placeholder="Position" required>';
                        echo '<input type="text" name="exp_company[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($exp['company']) . '" placeholder="Company" required>';
                        echo '<input type="text" name="exp_year[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($exp['year']) . '" placeholder="Year" required>';
                        echo '<textarea name="exp_description[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" rows="3" placeholder="Description" required>' . htmlspecialchars($exp['description']) . '</textarea>';
                        echo '<button type="button" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="removeExperience(this)">Remove</button>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="addExperience()">Add Experience</button>
            </div>

            <!-- Social Links Section -->
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Social Links</h3>
                <div id="social-links-container">
                    <?php
                    $socialLinks = json_decode($resume['social_links'] ?? '{}', true);
                    foreach ($socialLinks as $platform => $url) {
                        echo '<div class="flex mb-2">';
                        echo '<input type="text" name="social_platform[]" class="mr-2 w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($platform) . '" placeholder="Platform" required>';
                        echo '<input type="url" name="social_url[]" class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="' . htmlspecialchars($url) . '" placeholder="URL" required>';
                        echo '<button type="button" class="ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="removeSocialLink(this)">Remove</button>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="addSocialLink()">Add Social Link</button>
            </div>

            <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Save Resume</button>
        </form>
    </main>

    <script>
        tinymce.init({
            selector: '#summary',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            menubar: false
        });

        function addSkill() {
            const container = document.getElementById('skills-container');
            const div = document.createElement('div');
            div.className = 'flex mb-2';
            div.innerHTML = `
                <input type="text" name="skill_name[]" class="mr-2 flex-grow rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Skill name" required>
                <input type="number" name="skill_level[]" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" min="0" max="100" placeholder="%" required>
                <button type="button" class="ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="removeSkill(this)">Remove</button>
            `;
            container.appendChild(div);
        }

        function removeSkill(button) {
            button.parentElement.remove();
        }

        function addEducation() {
            const container = document.getElementById('education-container');
            const div = document.createElement('div');
            div.className = 'mb-2 p-4 border border-gray-200 dark:border-gray-700 rounded';
            div.innerHTML = `
                <input type="text" name="edu_degree[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Degree" required>
                <input type="text" name="edu_institution[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Institution" required>
                <input type="text" name="edu_year[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Year" required>
                <button type="button" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="removeEducation(this)">Remove</button>
            `;
            container.appendChild(div);
        }

        function removeEducation(button) {
            button.parentElement.remove();
        }

        function addExperience() {
            const container = document.getElementById('experience-container');
            const div = document.createElement('div');
            div.className = 'mb-2 p-4 border border-gray-200 dark:border-gray-700 rounded';
            div.innerHTML = `
                <input type="text" name="exp_position[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Position" required>
                <input type="text" name="exp_company[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Company" required>
                <input type="text" name="exp_year[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Year" required>
                <textarea name="exp_description[]" class="mb-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" rows="3" placeholder="Description" required></textarea>
                <button type="button" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="removeExperience(this)">Remove</button>
            `;
            container.appendChild(div);
        }

        function removeExperience(button) {
            button.parentElement.remove();
        }

        function addSocialLink() {
            const container = document.getElementById('social-links-container');
            const div = document.createElement('div');
            div.className = 'flex mb-2';
            div.innerHTML = `
                <input type="text" name="social_platform[]" class="mr-2 w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Platform" required>
                <input type="url" name="social_url[]" class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="URL" required>
                <button type="button" class="ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="removeSocialLink(this)">Remove</button>
            `;
            container.appendChild(div);
        }

        function removeSocialLink(button) {
            button.parentElement.remove();
        }

        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>