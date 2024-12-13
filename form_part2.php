<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Расходы на пенсионное страхование - Часть 2</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include 'components/header.php'; ?>
    <?php include 'components/nav.php'; ?>
    <main>
      <div class="container">
        <h2>Введите необходимые поля</h2>
        <div class="tabs">
          <span>Часть 1</span>
          <span class="active">Часть 2</span>
          <span>Итог</span>
        </div>
        <form id="formPart2" action="review.php" method="GET">
          <input type="hidden" name="docId" value="<?php echo htmlspecialchars($_GET['docId'] ?? ''); ?>" />
          <label>Номер Распоряжения <input type="text" name="order_number" value="12345" required /></label>
          <label>Дата перевода взноса на именной счёт <input type="date" name="named_transfer_date" value="2023-01-01" required /></label>
          <label>Сумма перевода взноса на именной счёт <input type="number" step="0.01" name="named_transfer_amount" value="500.00" required /></label>
          <label>Имя пользователя <input type="text" name="username" value="user123" required /></label>
          <label>Дата создания записи <input type="date" name="record_date" value="2023-01-01" required /></label>
          <label>Время создания записи <input type="time" name="record_time" value="12:00" required /></label>
          <div class="buttons">
            <button type="button" id="backButton">Назад</button>
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

        const data = JSON.parse(localStorage.getItem("documentData")) || {};
        for (const key in data) {
          if (data.hasOwnProperty(key)) {
            const input = document.querySelector(`input[name="${key}"]`);
            if (input) {
              input.value = data[key];
            }
          }
        }

        document.getElementById("formPart2").onsubmit = function (event) {
          event.preventDefault();
          const form = document.getElementById("formPart2");
          const formData = new FormData(form);
          const data = JSON.parse(localStorage.getItem("documentData")) || {};
          formData.forEach((value, key) => {
            data[key] = value;
          });
          localStorage.setItem("documentData", JSON.stringify(data));
          const nextUrl = docId ? `review.php?docId=${docId}` : `review.php`;
          location.href = nextUrl;
        };

        document.getElementById("backButton").onclick = function () {
          location.href = `form_part1.php?${urlParams.toString()}`;
        };
      });
    </script>
  </body>
</html>