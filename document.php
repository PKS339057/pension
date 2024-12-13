<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Просмотр документа</title>
    <link rel="stylesheet" href="css/styles.css" />
    <style>
      .buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
      }
      .buttons .delete-button {
        background-color: red;
        color: white;
      }
    </style>
  </head>
  <body>
    <?php include 'components/header.php'; ?>
    <?php include 'components/nav.php'; ?>
    <main>
      <div class="container">
        <h2>Просмотр документа</h2>
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
          <p><strong>Сумма перевода взноса на именной счёт:</strong> <span id="named_transfer_amount"></span></p>
          <p><strong>Имя пользователя:</strong> <span id="username"></span></p>
          <p><strong>Дата создания записи:</strong> <span id="record_date"></span></p>
          <p><strong>Время создания записи:</strong> <span id="record_time"></span></p>
        </div>
        <div class="buttons">
          <button type="button" id="editButton">Редактировать</button>
          <button type="button" id="deleteButton" class="delete-button">Удалить</button>
        </div>
      </div>
    </main>
    <?php include 'components/footer.php'; ?>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const docId = urlParams.get("docId");

        fetch(`php/get_document.php?docId=${docId}`)
          .then((response) => response.json())
          .then((doc) => {
            if (doc.error) {
              alert(doc.error);
            } else {
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
                let value = doc[field] || '';
                if (field.includes('date') || field === 'dob') {
                  const date = new Date(value);
                  value = `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()} г.`;
                } else if (field.includes('amount')) {
                  value = `${new Intl.NumberFormat('ru-RU', { style: 'decimal', minimumFractionDigits: 2 }).format(value)} ₽`;
                }
                document.getElementById(field).textContent = value;
              });
            }
          })
          .catch((error) => {
            console.error("Error fetching document:", error);
          });

        document.getElementById("editButton").onclick = function () {
          location.href = `form_part1.php?docId=${docId}`;
        };

        document.getElementById("deleteButton").onclick = function () {
          if (confirm("Вы уверены, что хотите удалить этот документ?")) {
            fetch(`php/delete_document.php?docId=${docId}`, { method: 'DELETE' })
              .then((response) => response.text())
              .then((result) => {
                alert(result);
                location.href = 'tables.php';
              })
              .catch((error) => {
                console.error("Error deleting document:", error);
              });
          }
        };
      });
    </script>
  </body>
</html>