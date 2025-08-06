// Convert to editable Word-like HTML in a new tab with formatting toolbar

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("cvForm");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    const profileImageFile = formData.get("profileImage");

    const reader = new FileReader();
    reader.onload = function (event) {
      const imageData = event.target.result;

      function formatLinks(text) {
        return text.replace(/(https?:\/\/[\w./?=&%-]+)/g, '<a href="$1" target="_blank">$1</a>');
      }

      function formatList(text) {
        const items = text.split(/\n|,/).map(item => item.trim()).filter(Boolean);
        return `<ul>${items.map(i => `<li>${i}</li>`).join('')}</ul>`;
      }

      function formatEducation(text) {
        const entries = text.split(/\n+/).map(line => {
          const parts = line.split("|").map(p => p.trim());
          if (parts.length < 3) return null;
          return `<div class="edu-entry">
            <strong>${parts[0]}</strong>
            <em>${parts[1]}</em>
            <p>${parts[2]}</p>
          </div>`;
        }).filter(Boolean);
        return entries.join("\n");
      }

      const editableDoc = `
        <html>
        <head>
          <title>Editable CV</title>
          <style>
            @media print {
              .toolbar, #exportBtn { display: none !important; }
            }
            body {
              font-family: 'Times New Roman', serif;
              padding: 40pt;
              background: #fff;
              color: #000;
              line-height: 1.8;
            }
            h1, h2 {
              border-bottom: 1px solid #000;
              padding-bottom: 4pt;
              margin-bottom: 12pt;
            }
            img {
              width: 120pt;
              height: 120pt;
              object-fit: cover;
              border-radius: 8pt;
              border: 2pt solid #000;
            }
            .header {
              display: flex;
              gap: 20pt;
              align-items: center;
              margin-bottom: 30pt;
            }
            .section {
              margin-top: 25pt;
              text-align: justify;
            }
            .edu-entry strong,
            .proj-entry strong {
              display: block;
              font-size: 16pt;
            }
            .edu-entry em,
            .proj-entry em {
              display: block;
              font-style: italic;
            }
            #exportBtn {
              display: inline-block;
              margin-top: 40pt;
              padding: 10pt 20pt;
              background: #000;
              color: #fff;
              text-decoration: none;
              font-weight: bold;
              border-radius: 6pt;
            }
            .toolbar {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              background: #eee;
              padding: 10pt;
              z-index: 999;
              display: flex;
              flex-wrap: wrap;
              gap: 10pt;
              border-bottom: 1pt solid #ccc;
              box-shadow: 0 2pt 4pt rgba(0,0,0,0.1);
            }
            .toolbar button {
              padding: 6pt 10pt;
              font-size: 14pt;
              border: 1pt solid #aaa;
              background: #fff;
              cursor: pointer;
              border-radius: 4pt;
            }
            .toolbar button:hover {
              background: #f0f0f0;
            }
          </style>
        </head>
        <body contenteditable="true">
          <div class="toolbar" contenteditable="false">
            <button onclick="document.execCommand('bold')">Bold</button>
            <button onclick="document.execCommand('italic')">Italic</button>
            <button onclick="document.execCommand('underline')">Underline</button>
            <button onclick="document.execCommand('insertUnorderedList')">Bullets</button>
            <button onclick="document.execCommand('insertOrderedList')">Numbered</button>
            <button onclick="document.execCommand('createLink', false, prompt('Enter URL'))">Link</button>
            <button onclick="document.execCommand('justifyLeft')">Left</button>
            <button onclick="document.execCommand('justifyCenter')">Center</button>
            <button onclick="document.execCommand('justifyRight')">Right</button>
            <button onclick="document.execCommand('justifyFull')">Justify</button>
            <button onclick="document.execCommand('removeFormat')">Clear</button>
          </div>

          <div class="header">
            <img src="${imageData}" />
            <div>
              <h1>${formData.get("fullName")}</h1>
              <p>${formData.get("jobTitle")}</p>
              <p>Date of Birth: ${formData.get("birthDate")} | ${formData.get("city")}</p>
              <p>Email: ${formData.get("email")} | Phone: ${formData.get("phone")}</p>
            </div>
          </div>

          <div class="section">
            <h2>Professional Summary</h2>
            <p>${formData.get("summary")}</p>
          </div>

          <div class="section">
            <h2>Skills</h2>
            ${formatList(formData.get("skills"))}
          </div>

          <div class="section">
            <h2>Experience</h2>
            ${formatList(formData.get("experience"))}
          </div>

          <div class="section">
            <h2>Education</h2>
            ${formatEducation(formData.get("education"))}
          </div>

          <div class="section">
            <h2>Projects</h2>
            ${formatList(formData.get("projects"))}
          </div>

          <div class="section">
            <h2>Training / Courses</h2>
            ${formatList(formData.get("courses"))}
          </div>

          <a id="exportBtn" onclick="window.print()">Export / Print</a>
        </body>
        </html>
      `;

      const newTab = window.open("", "_blank");
      newTab.document.open();
      newTab.document.write(editableDoc);
      newTab.document.close();
    };

    if (profileImageFile) {
      reader.readAsDataURL(profileImageFile);
    }
  });
});
