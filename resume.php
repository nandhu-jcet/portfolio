<?php
include('includes/db.php');

$result = $conn->query("SELECT * FROM resume LIMIT 1");
$resume = $result->fetch_assoc();

if (!$resume) {
    die("Resume data not found.");
}

function generatePDF($resume) {
    require_once('tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Resume - ' . $resume['name']);
    $pdf->SetHeaderData('', 0, 'Resume - ' . $resume['name'], '');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->AddPage();

    $html = '<h1>' . htmlspecialchars($resume['name']) . '</h1>';
    $html .= '<h2>' . htmlspecialchars($resume['title']) . '</h2>';
    $html .= '<h3>Summary</h3><p>' . nl2br(htmlspecialchars($resume['summary'])) . '</p>';
    $html .= '<h3>Skills</h3><ul>';
    $skills = json_decode($resume['skills'], true) ?: [];
    foreach ($skills as $skill) {
        $html .= '<li>' . htmlspecialchars($skill['name']) . ' - ' . intval($skill['level']) . '%</li>';
    }
    $html .= '</ul>';
    $html .= '<h3>Education</h3>';
    $education = json_decode($resume['education'], true) ?: [];
    foreach ($education as $edu) {
        $html .= '<p><strong>' . htmlspecialchars($edu['degree']) . '</strong> - ' . htmlspecialchars($edu['institution']) . ' (' . htmlspecialchars($edu['year']) . ')</p>';
    }
    $html .= '<h3>Experience</h3>';
    $experience = json_decode($resume['experience'], true) ?: [];
    foreach ($experience as $exp) {
        $html .= '<p><strong>' . htmlspecialchars($exp['position']) . '</strong> at ' . htmlspecialchars($exp['company']) . ' (' . htmlspecialchars($exp['year']) . ')</p>';
        $html .= '<p>' . nl2br(htmlspecialchars($exp['description'])) . '</p>';
    }

    $pdf->writeHTML($html, true, false, true, false, '');
    return $pdf->Output('resume.pdf', 'S');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume - <?php echo htmlspecialchars($resume['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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

    <div class="container mx-auto py-10 px-4">
        <div class="glassmorphic p-8 animate__animated animate__fadeIn">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold"><?php echo htmlspecialchars($resume['name']); ?></h1>
                <!-- <a href="download_resume.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Download PDF</a> -->
            </div>
            <p class="text-xl text-blue-300 mb-4"><?php echo htmlspecialchars($resume['title']); ?></p>
            
            <div class="mb-8 animate__animated animate__fadeInUp">
                <h2 class="text-2xl font-bold mb-2">Summary</h2>
                <p class="text-lg"><?php echo nl2br(htmlspecialchars($resume['summary'])); ?></p>
            </div>

            <div class="mb-8 animate__animated animate__fadeInUp">
                <h2 class="text-2xl font-bold mb-4">Skills</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php
                    $skills = json_decode($resume['skills'], true) ?: [];
                    foreach ($skills as $skill) {
                        echo '<div class="flex items-center justify-between">';
                        echo '<span>' . htmlspecialchars($skill['name']) . '</span>';
                        echo '<div class="w-1/2 bg-gray-700 rounded-full h-2.5">';
                        echo '<div class="bg-blue-600 h-2.5 rounded-full" style="width: ' . intval($skill['level']) . '%"></div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

            <div class="mb-8 animate__animated animate__fadeInUp">
                <h2 class="text-2xl font-bold mb-4">Education</h2>
                <?php
                $education = json_decode($resume['education'], true) ?: [];
                foreach ($education as $edu) {
                    echo '<div class="mb-4">';
                    echo '<h3 class="text-xl font-semibold">' . htmlspecialchars($edu['degree']) . '</h3>';
                    echo '<p>' . htmlspecialchars($edu['institution']) . ' - ' . htmlspecialchars($edu['year']) . '</p>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class="mb-8 animate__animated animate__fadeInUp">
                <h2 class="text-2xl font-bold mb-4">Experience</h2>
                <?php
                $experience = json_decode($resume['experience'], true) ?: [];
                foreach ($experience as $exp) {
                    echo '<div class="mb-6">';
                    echo '<h3 class="text-xl font-semibold">' . htmlspecialchars($exp['position']) . ' at ' . htmlspecialchars($exp['company']) . '</h3>';
                    echo '<p class="text-blue-300">' . htmlspecialchars($exp['year']) . '</p>';
                    echo '<p class="mt-2">' . nl2br(htmlspecialchars($exp['description'])) . '</p>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class="mt-8 flex justify-center space-x-4">
                <?php
                $socialLinks = json_decode($resume['social_links'] ?? '{}', true);
                foreach ($socialLinks as $platform => $url) {
                    echo '<a href="' . htmlspecialchars($url) . '" target="_blank" class="text-blue-400 hover:text-blue-300">' . ucfirst($platform) . '</a>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>

