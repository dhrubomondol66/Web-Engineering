<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Users_profile.php"); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog</title>
  <link rel="stylesheet" href="style/blog.css" />
</head>
<body>
<!-- Header -->
 <br><br>
  
  <!-- End of header -->
  <nav>
    <h1>Blog</h1>
  </nav><br><hr>

  <section>
    <div class="blog-section">
      <h2>Latest Health & Wellness Articles</h2>
      <div class="blog-list">

        <div class="blog-item">
          <div class="blog-title">Top 10 Foods to Boost Your Immune System</div>
          <div class="blog-content">
            Eating a balanced diet rich in fruits, vegetables, and whole grains can strengthen your immune system...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">Understanding Hypertension: Causes, Symptoms, and Remedies</div>
          <div class="blog-content">
            Hypertension, or high blood pressure, often has no symptoms but can cause severe health issues if untreated...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">When Should You See a Dermatologist?</div>
          <div class="blog-content">
            Learn when skin conditions like persistent acne, rashes, or suspicious moles should prompt a dermatologist visit...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">Online Consultation vs. In-Person Visit: Which One’s Better?</div>
          <div class="blog-content">
            Online consultations are convenient but in-person visits may be necessary for physical exams...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">“5 Common Childhood Diseases You Shouldn’t Ignore”</div>
          <div class="blog-content">
            Online consultations are convenient but in-person visits may be necessary for physical exams...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">“How Stress Affects Your Body — Backed by Science”</div>
          <div class="blog-content">
            Online consultations are convenient but in-person visits may be necessary for physical exams...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">“Covid-19 Symptoms: What’s New in 2025?”</div>
          <div class="blog-content">
            Online consultations are convenient but in-person visits may be necessary for physical exams...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">“10 Easy Exercises You Can Do at Home”</div>
          <div class="blog-content">
            Online consultations are convenient but in-person visits may be necessary for physical exams...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">“How to Prepare for a Doctor Visit: What Patients Often Forget”</div>
          <div class="blog-content">
            Online consultations are convenient but in-person visits may be necessary for physical exams...
          </div>
        </div>

        <div class="blog-item">
          <div class="blog-title">“Benefits of Regular Health Checkups”</div>
          <div class="blog-content">
            Online consultations are convenient but in-person visits may be necessary for physical exams...
          </div>
        </div>
      </div>
    </div>
  </section><hr><br>
  <script>
    // Make dropdown work on hover
    document.querySelectorAll('.blog-item').forEach(item => {
      item.addEventListener('mouseenter', () => {
        item.classList.add('active');
      });
      item.addEventListener('mouseleave', () => {
        item.classList.remove('active');
      });
    });
  </script>
</body>
</html>
