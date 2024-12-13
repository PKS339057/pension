<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Результаты ввода</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include 'components/header.php'; ?>
    <?php include 'components/nav.php'; ?>
    <main>
      <div class="container result">
        <h2>Результаты ввода</h2>
        <div class="tabs">
          <span>Часть 1</span>
          <span>Часть 2</span>
          <span class="active">Итог</span>
        </div>
        <div class="results">
          <p><strong>ФИО:</strong> <span id="fio"></span></p>
          <p><strong>Дата рождения:</strong> <span id="dob"></span></p>
          <p><strong>Дата наступления пенсионного возраста:</strong> <span id="pension_date"></span></p>
          <p><strong>Дата увольнения из общества:</strong> <span id="dismissal_date"></span></p>
          <p><strong>Стаж работы в Обществе:</strong> <span id="work_experience"></span></p>
          <p><strong>Дата перевода взноса на солидарный счёт:</strong> <span id="transfer_date"></span></p>
          <p><strong>Сумма перевода взноса на солидарный счёт:</strong> <span id="transfer_amount"></span></p>
          <p><strong>Номер Распоряжения:</strong> <span id="order_number"></span></p>
          <p><strong>Дата перевода взноса на именной счёт:</strong> <span id="named_transfer_date"></span></p>
          <p><strong>Размер перевода взноса на именной счёт:</strong> <span id="named_transfer_amount"></span></p>
          <p><strong>Имя пользователя:</strong> <span id="username"></span></p>
          <p><strong>Дата создания записи:</strong> <span id="record_date"></span></p>
          <p><strong>Время создания записи:</strong> <span id="record_time"></span></p>
        </div>
        <div class="buttons">
          <button type="button" onclick="goBack()">Назад</button>
          <button type="button" onclick="saveDocument()">Сохранить</button>
        </div>
      </div>
    </main>
    <?php include 'components/footer.php'; ?>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const formData = JSON.parse(localStorage.getItem("documentData"));

        const fields = [
          "fio",
          "dob",
          "pension_date",
          "dismissal_date",
          "work_experience",
          "transfer_date",
          "transfer_amount",
          "order_number",
          "named_transfer_date",
          "named_transfer_amount",
          "username",
          "record_date",
          "record_time",
        ];

        const monthNames = [
          "января", "февраля", "марта", "апреля", "мая", "июня",
          "июля", "августа", "сентября", "октября", "ноября", "декабря"
        ];

        fields.forEach((field) => {
          let value = formData[field] || '';
          if (field.includes('date') || field === 'dob') {
            const date = new Date(value);
            value = `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()} г.`;
          } else if (field.includes('amount')) {
            value = `${new Intl.NumberFormat('ru-RU', { style: 'decimal', minimumFractionDigits: 2 }).format(value)} ₽`;
          }
          document.getElementById(field).textContent = value;
        });
      });

      function goBack() {
        const docId = new URLSearchParams(window.location.search).get("docId");
        const backUrl = docId ? `form_part2.php?docId=${docId}` : `form_part2.php`;
        location.href = backUrl;
      }

      function saveDocument() {
        const documentData = JSON.parse(localStorage.getItem("documentData"));
        const docId = new URLSearchParams(window.location.search).get("docId");
        const xhr = new XMLHttpRequest();
        const method = docId ? "PUT" : "POST";
        const url = docId ? `php/save_document.php?docId=${docId}` : "php/save_document.php";

        xhr.open(method, url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              const responseText = xhr.responseText;
              const newDocIdMatch = responseText.match(/ID: (\d+)/);
              if (newDocIdMatch) {
                const newDocId = newDocIdMatch[1];
                localStorage.removeItem("documentData");
                window.location.href = `tables.php?docId=${newDocId}`;
              } else {
                console.log(responseText);
                localStorage.removeItem("documentData");
                window.location.href = "tables.php";
              }
            } else {
              console.error("Error:", xhr.statusText);
              console.log(`Error: ${xhr.statusText}`);
            }
          }
        };

        const params = Object.keys(documentData)
          .map((key) => `${key}=${encodeURIComponent(documentData[key])}`)
          .join("&");
        xhr.send(params);
      }
    </script>
  </body>
</html>