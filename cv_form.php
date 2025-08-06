<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: auth.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Times+New+Roman&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Times New Roman', serif;
      background: linear-gradient(to right, #2b003e, #250547);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .cv-form-container {
      background: #1a1a2e;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 0 25px #a600ff99;
      width: 95vw;
      max-width: 1100px;
      max-height: 90vh;
      overflow-y: auto;
      margin: 0 auto;
    }

    form {
      width: 100%;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 25px 40px;
    }

    h1 {
      grid-column: 1 / -1;
      text-align: center;
      font-size: 2em;
      color: #ffccff;
      margin-bottom: 10px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 10px;
    }

    label {
      font-weight: bold;
      color: #ffd6ff;
    }

    input[type="text"], input[type="email"], input[type="tel"], input[type="file"], input[type="date"], textarea, select {
      width: 100%;
      padding: 10px 12px;
      background: #281a40;
      border: 1px solid #663399;
      border-radius: 8px;
      color: #fff;
      font-size: 14px;
      outline: none;
      transition: 0.3s ease;
    }

    input:focus, textarea:focus, select:focus {
      border-color: #cc66ff;
      box-shadow: 0 0 8px #cc66ff66;
    }

    textarea {
      resize: vertical;
      min-height: 60px;
    }

    input:invalid, textarea:invalid {
      border-color: #ff4d4d;
    }

    button[type="submit"] {
      grid-column: 1 / -1;
      background: #cc66ff;
      color: #fff;
      padding: 14px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      box-shadow: 0 0 10px #cc66ff;
      transition: 0.3s ease;
      margin-top: 15px;
    }

    button:hover {
      background: #ff99ff;
      box-shadow: 0 0 16px #ff99ff;
      color: #000;
    }

    #previewContainer {
      margin-top: 12px;
    }

    #previewContainer img {
      max-width: 100px;
      height: auto;
      border-radius: 10px;
    }

    .full-width {
      grid-column: 1 / -1;
    }
  </style>
</head>
<body>
  <div class="cv-form-container">
    <form id="cvForm" enctype="multipart/form-data">
      <h1>Build Your CV</h1>

      <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="fullName" required pattern="[A-Za-z\s]+" title="Only letters and spaces allowed" />
      </div>

      <div class="form-group">
        <label for="jobTitle">Job Title</label>
        <input type="text" id="jobTitle" name="jobTitle" required />
      </div>

      <div class="form-group">
        <label for="birthDate">Date of Birth</label>
        <input type="date" id="birthDate" name="birthDate" required />
      </div>

      <div class="form-group">
        <label for="city">City</label>
        <select id="city" name="city" required>
          <option value="">Select your city</option>
          <option value="Karachi">Karachi</option>
          <option value="Lahore">Lahore</option>
          <option value="Islamabad">Islamabad</option>
          <option value="Peshawar">Peshawar</option>
          <option value="Quetta">Quetta</option>
          <option value="Multan">Multan</option>
          <option value="Faisalabad">Faisalabad</option>
          <option value="Rawalpindi">Rawalpindi</option>
          <option value="Hyderabad">Hyderabad</option>
          <option value="Gujranwala">Gujranwala</option>
        </select>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>

      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" required pattern="[0-9\-\+\s]+" title="Only numbers, + and - allowed" />
      </div>

      <div class="form-group full-width">
        <label for="summary">Professional Summary</label>
        <textarea id="summary" name="summary" required minlength="30"></textarea>
      </div>

      <div class="form-group">
        <label for="skills">Skills</label>
        <textarea id="skills" name="skills" required></textarea>
      </div>

      <div class="form-group">
        <label for="experience">Experience</label>
        <textarea id="experience" name="experience" required></textarea>
      </div>

      <div class="form-group full-width">
        <label for="education">Education</label>
        <textarea id="education" name="education" required></textarea>
      </div>

      <div class="form-group full-width">
        <label for="courses">Training / Courses</label>
        <textarea id="courses" name="courses"></textarea>
      </div>
 
      <div class="form-group full-width">
        <label for="courses">Projects</label>
        <textarea id="projects" name="projects"></textarea>
      </div>
      <div class="form-group">
        <label for="profileImage">Upload Profile Picture</label>
        <input type="file" id="pr5ofileImage" name="profileImage" accept="image/*" required />
        <div id="previewContainer"></div>
      </div>

      <button type="submit">Generate PDF</button>
    </form>
  </div>
  <script src="cv_script.js"></script>
</body>
</html>