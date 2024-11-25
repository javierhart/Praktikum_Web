<?php
@include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaltim Fun</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<body>
    <!-- Header Section -->
    <header>
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1></h1>
            </div>
        </section>
    </header>

   <section>
    <div class="category-bar">
        <div class="category">
            <div class="animasi">
                <a href=""><img src="WEB US ASET/Gua Haji Mangku.jpg" alt="Gua Haji Mangku"></a>
                <p><b>Gua Haji Mangku</b></p>
            </div>
        </div>
        <div class="category">
            <div class="animasi">
                <a href=""><img src="WEB US ASET/Labuan Cermin.jpg" alt="Labuan Cermin"></a>
                <p><b>Labuan Cermin</b></p>
            </div>
        </div>
        <div class="category">
            <div class="animasi">
                <a href=""><img src="WEB US ASET/Goa Tapak Raja.jpg" alt="Goa Tapak Raja"></a>
                <p><b>Goa Tapak Raja</b></p>
            </div>
        </div>
        <div class="category">
            <div class="animasi">
                <a href=""><img src="WEB US ASET/Lake View.jpg" alt="Lake View"></a>
                <p><b>Lake View</b></p>
            </div>
        </div>
        <div class="category">
            <div class="animasi">
                <a href=""><img src="WEB US ASET/Laguna Kehe Daing.jpg" alt="Pulau Kaniungan"></a>
                <p><b>Pulau Kaniungan</b></p>
            </div>
        </div>
        <div class="category">
            <div class="animasi">
                <a href=""><img src="WEB US ASET/Ladang Budaya Tenggarong.jpg" alt="Ladang Budaya Tenggarong"></a>
                <p><b>Ladang Budaya Tenggarong</b></p>
            </div>
        </div>
        <div class="category">
            <div class="animasi">
                <a href=""><img src="WEB US ASET/Air Terjun Riam Ampang.jpg" alt="Air Terjun Riam Ampang"></a>
                <p><b>Air Terjun Riam Ampang</b></p>
            </div>
        </div>
    </div>
</section>

    <!-- Recommendations Section -->
    <section class="recommendations1">
        <h1>Recommendations Destination</h1>

        <!-- Tour Section -->
        <div class="section-container">
            <h2>Tour</h2>
            <div class="scroll-container">
                <?php
                // Mengambil data destinasi yang bertipe 'destination'
                $query = "SELECT * FROM `destinations` WHERE type = 'destination'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="ride-card">
                                <a href="destination.php?id=' . htmlspecialchars($row['id']) . '">
                                    <img src="uploaded_img/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                                </a>
                                <h3>' . htmlspecialchars($row['name']) . '</h3>
                                <p>' . htmlspecialchars($row['location']) . '</p>
                            </div>';
                    }
                } else {
                    echo '<p>No destinations available at this time.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Hotel Section -->
    <section class="recommendations2">
        <div class="section-container">
            <h2>Hotels</h2>
            <div class="scroll-container">
                <?php
                // Mengambil data hotel yang bertipe 'hotel'
                $query = "SELECT * FROM `destinations` WHERE type = 'hotel'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="hotel-card">
                                <a href="destination.php?id=' . htmlspecialchars($row['id']) . '">
                                    <img src="uploaded_img/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                                </a>
                                <h3>' . htmlspecialchars($row['name']) . '</h3>
                                <p>' . htmlspecialchars($row['location']) . '</p>
                            </div>';
                    }
                } else {
                    echo '<p>No hotels available at this time.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Dining Section -->
    <section class="recommendations2">
        <div class="section-container">
            <h2>Dining</h2>
            <div class="scroll-container">
                <?php
                // Mengambil data dining yang bertipe 'dining'
                $query = "SELECT * FROM `destinations` WHERE type = 'dining'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="resto-card">
                                <a href="destination.php?id=' . htmlspecialchars($row['id']) . '">
                                    <img src="uploaded_img/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                                </a>
                                <h3>' . htmlspecialchars($row['name']) . '</h3>
                                <p>' . htmlspecialchars($row['location']) . '</p>
                            </div>';
                    }
                } else {
                    echo '<p>No dining options available at this time.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Store Section -->
    <section class="recommendations-str">
        <div class="section-container">
            <h2>Stores</h2>
            <div class="scroll-container">
                <?php
                // Mengambil data store yang bertipe 'store'
                $query = "SELECT * FROM `destinations` WHERE type = 'store'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="store-item">
                                <a href="destination.php?id=' . htmlspecialchars($row['id']) . '">
                                    <img src="uploaded_img/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                                </a>
                                <h3>' . htmlspecialchars($row['name']) . '</h3>
                            </div>';
                    }
                } else {
                    echo '<p>No stores available at this time.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <script src="index.js"></script>

<script>
const categoryBar = document.querySelector('.category-bar');
const categories = document.querySelectorAll('.category');

let currentCategory = 0;
let maxCategories = categories.length;

function slideAnimation() {
  if (currentCategory >= maxCategories * 2) {
    currentCategory = 0;
  }
  categoryBar.style.transform = `translateX(-${currentCategory * 180}px)`;
  currentCategory++;
}

setInterval(slideAnimation, 6000);

// Add smooth scrolling effect
categoryBar.style.transition = 'transform 1s ease-in-out';

// Buat fotonya berulang
categoryBar.innerHTML += categoryBar.innerHTML;
categoryBar.style.transform = `translateX(-${currentCategory * 180}px)`;
categoryBar.style.overflow = 'hidden';
categoryBar.style.width = '200%';
categoryBar.style.transition = 'transform 1s ease-in-out';
categoryBar.parentElement.style.overflow = 'hidden';

// Tambahkan kode untuk membuat foto berulang
categoryBar.style.animation = 'loop 60s linear infinite';
categoryBar.style.animationName = 'loop';
categoryBar.style.animationDuration = '60s';
categoryBar.style.animationTimingFunction = 'linear';
categoryBar.style.animationIterationCount = 'infinite';

// Tambahkan keyframe untuk animasi loop
const style = document.createElement('style');
style.innerHTML = `
  @keyframes loop {
    0% {
      transform: translateX(0);
    }
    100% {
      transform: translateX(-${maxCategories * 180}px);
    }
  }
`;
document.head.appendChild(style);setInterval(slideAnimation, 3000);
</script>
</body>
</html>

