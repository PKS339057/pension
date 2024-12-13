<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Расходы на пенсионное страхование - Часть 1</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include 'components/header.php'; ?>
    <?php include 'components/nav.php'; ?>
    <main>
      <div class="container">
        <h2>Введите необходимые поля</h2>
        <div class="tabs">
          <span class="active">Часть 1</span>
          <span>Часть 2</span>
          <span>Итог</span>
        </div>
        <form id="formPart1" method="GET">
          <input type="hidden" name="docId" id="docId" value="" />
          <label>ФИО <input type="text" name="fio" value="Иван Иванов" required /></label>
          <label>Дата рождения <input type="date" name="dob" value="1980-01-01" required /></label>
          <label>Дата наступления пенсионного возраста <input type="date" name="pension_date" value="2045-01-01" required /></label>
          <label>Дата увольнения из общества <input type="date" name="dismissal_date" value="2025-01-01" /></label>
          <label>Стаж работы в Обществе <input type="number" name="work_experience" value="20" required /></label>
          <label>Дата перевода взноса на солидарный счёт <input type="date" name="transfer_date" value="2023-01-01" required /></label>
          <label>Сумма перевода взноса на солидарный счёт <input type="number" step="0.01" name="transfer_amount" value="1000.00" required /></label>
          <div class="buttons">
            <button type="submit">Вперёд</button>
          </div>
        </form>
      </div>
    </main>
    <?php include 'components/footer.php'; ?>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const docId = urlParams.get("docId");

        if (docId && !localStorage.getItem("documentData")) {
          fetch(`php/get_document.php?docId=${docId}`)
            .then((response) => response.json())
            .then((doc) => {
              if (doc) {
                localStorage.setItem("documentData", JSON.stringify(doc));
                for (const key in doc) {
                  if (doc.hasOwnProperty(key)) {
                    const input = document.querySelector(`input[name="${key}"]`);
                    if (input) {
                      input.value = doc[key];
                    }
                  }
                }
              }
            })
            .catch((error) => {
              console.error("Error fetching document:", error);
            });
        } else {
          const data = JSON.parse(localStorage.getItem("documentData")) || {};
          for (const key in data) {
            if (data.hasOwnProperty(key)) {
              const input = document.querySelector(`input[name="${key}"]`);
              if (input) {
                input.value = data[key];
              }
            }
          }
        }

        document.getElementById("formPart1").onsubmit = function (event) {
          event.preventDefault();
          const form = document.getElementById("formPart1");
          const formData = new FormData(form);
          const data = JSON.parse(localStorage.getItem("documentData")) || {};
          formData.forEach((value, key) => {
            data[key] = value;
          });
          localStorage.setItem("documentData", JSON.stringify(data));
          const nextUrl = docId ? `form_part2.php?docId=${docId}` : `form_part2.php`;
          location.href = nextUrl;
        };
      });
    </script>
  </body>
</html>