<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Список документов</title>
    <link rel="stylesheet" href="css/styles.css" />
    <style>
      .table-container {
        display: block;
        overflow-x: auto;
        width: 100%;
      }
      .table-footer {
        position: sticky;
        bottom: 0;
        background-color: #fffacd;
        border-top: 1px solid #ccc;
        padding: 10px;
        text-align: right;
      }
      .table-footer td {
        border-top: 1px solid #ccc;
        white-space: nowrap;
      }
      table {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
      }
      th {
        background-color: #477B9B;
        color: white;
        padding: 8px;
        border: 1px solid #ccc;
        white-space: nowrap;
        text-align: center;
      }
      td {
        padding: 8px;
        border: 1px solid #ccc;
        white-space: nowrap;
        text-align: center;
      }
      .container {
        display: flex;
        justify-content: center;
        max-width: 1000px;
        width: 100%;
      }
      .table-wrapper {
        display: inline-block;
        width: auto;
      }
      .total-row {
        background-color: #fffacd;
      }
    </style>
  </head>
  <body>
    <?php include 'components/header.php'; ?>
    <?php include 'components/nav.php'; ?>
    <main>
      <div class="container">
        <div class="table-wrapper">
          <h2 style="margin-bottom: 20px;">Список документов</h2>
          <div class="table-container">
            <table id="documentsTable">
              <thead>
                <tr>
                  <th>Документ</th>
                  <th>Дата создания</th>
                  <th>Размер ССч</th>
                  <th>Размер ИмСч</th>
                  <th>Ежедневная выплата</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr class="table-footer">
                  <td class="total-row" colspan="2">Итог:</td>
                  <td class="total-row"><span id="totalTransferAmount">0</span> ₽</td>
                  <td class="total-row"><span id="totalNamedTransferAmount">0</span> ₽</td>
                  <td class="total-row"><span id="totalDailyPayout">0</span> ₽</td>
                </tr>
              </tfoot>
            </table>
            <p id="emptyMessage" style="display: none;">На данный момент список документов пуст.</p>
          </div>
        </div>
      </div>
    </main>
    <?php include 'components/footer.php'; ?>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        fetch("php/fetch_documents.php")
          .then((response) => response.json())
          .then((documents) => {
            const table = document.getElementById("documentsTable");
            const tableBody = table.querySelector("tbody");
            const tableHead = table.querySelector("thead");
            const emptyMessage = document.getElementById("emptyMessage");
            const totalTransferAmountElem = document.getElementById("totalTransferAmount");
            const totalNamedTransferAmountElem = document.getElementById("totalNamedTransferAmount");
            const totalDailyPayoutElem = document.getElementById("totalDailyPayout");

            let totalTransferAmount = 0;
            let totalNamedTransferAmount = 0;
            let totalDailyPayout = 0;

            if (documents.length === 0) {
              tableHead.style.display = "none";
              tableBody.style.display = "none";
              emptyMessage.style.display = "block";
            } else {
              tableHead.style.display = "table-header-group";
              tableBody.style.display = "table-row-group";
              emptyMessage.style.display = "none";
              documents.forEach((doc, index) => {
                const payoutPeriod = 3650;
                const dailyPayout = ((parseFloat(doc.transfer_amount) + parseFloat(doc.named_transfer_amount)) / payoutPeriod).toFixed(2);

                const row = document.createElement("tr");
                row.innerHTML = `
                  <td><a href="document.php?docId=${doc.id}">Документ ${index + 1}</a></td>
                  <td>${new Date(doc.record_date).toLocaleDateString('ru-RU')}</td>
                  <td>${new Intl.NumberFormat('ru-RU', { style: 'decimal', minimumFractionDigits: 2 }).format(doc.transfer_amount)} ₽</td>
                  <td>${new Intl.NumberFormat('ru-RU', { style: 'decimal', minimumFractionDigits: 2 }).format(doc.named_transfer_amount)} ₽</td>
                  <td>${new Intl.NumberFormat('ru-RU', { style: 'decimal', minimumFractionDigits: 2 }).format(dailyPayout)} ₽</td>
                `;
                tableBody.appendChild(row);

                totalTransferAmount += parseFloat(doc.transfer_amount);
                totalNamedTransferAmount += parseFloat(doc.named_transfer_amount);
                totalDailyPayout += parseFloat(dailyPayout);
              });

              totalTransferAmountElem.textContent = new Intl.NumberFormat('ru-RU', { style: 'decimal', minimumFractionDigits: 2 }).format(totalTransferAmount);
              totalNamedTransferAmountElem.textContent = new Intl.NumberFormat('ru-RU', { style: 'decimal', minimumFractionDigits: 2 }).format(totalNamedTransferAmount);
              totalDailyPayoutElem.textContent = new Intl.NumberFormat('ru-RU', { style: 'decimal', minimumFractionDigits: 2 }).format(totalDailyPayout);
            }
          })
          .catch((error) => {
            console.error("Error fetching documents:", error);
          });
      });
    </script>
  </body>
</html>
