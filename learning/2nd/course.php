<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shobhit wallah - Courses</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <nav>
            <h1>Shobhit wallah</h1>
            <ul>
                <li><a href="mainpage.php">Home</a></li>
                <li><a href="#">Courses</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="courses">
            <h2>Available Courses</h2>
            <!-- add -->

            <body>
                <div id="app" role="main" aria-label="Online Learning Platform">


                    <nav aria-label="Main navigation">
                        <button id="nav-home" class="active" aria-current="page" tabindex="0">Courses</button>
                        <button id="nav-login" tabindex="0"></button>
                    </nav>

                    <main tabindex="0">
                        <section id="course-list" aria-label="Course Catalog" role="list">
                            <!-- Courses will be dynamically loaded here -->
                        </section>

                        <section id="course-detail" aria-label="Course Detail" role="region" tabindex="0">
                            <button class="back-btn" aria-label="Back to course catalog">&larr; Back</button>
                            <h2></h2>
                            <p></p>
                            <h3>Lessons</h3>
                            <ul id="lessons-list"></ul>
                        </section>
                    </main>

                    <footer>
                        &copy; Shobhit platform. All rights reserved.
                    </footer>
                </div>

                <!-- Modal for Login/Register -->
                <div id="modal-bg" class="modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                    <div id="modal">
                        <button class="close-btn" aria-label="Close login/register modal">&times;</button>
                        <h3 id="modal-title">Login</h3>
                        <form id="auth-form" action="login.php" method="POST" novalidate>
                            <label for="input-email">Email</label>
                            <input id="input-email" type="email" name="email" autocomplete="email" required placeholder="you@example.com" />
                            <label for="input-password">Password</label>
                            <input id="input-password" type="password" name="password" autocomplete="current-password" required minlength="6" placeholder="At least 6 characters" />
                            <button type="submit">Login</button>
                        </form>
                        <div class="switch-mode">
                            Don't have an account? <a href="#" id="switch-to-register">Register here</a>
                        </div>
                    </div>
                </div>

                <script src="script.js"></script>


        </section>
    </main>
</body>

</html>