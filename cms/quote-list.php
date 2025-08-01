<?php
include "../index/config/conf.php";

$tablename = $database . ".`wt_quotes`";
$sql = "SELECT ref_num, quote_date, author, en, cn FROM $tablename ORDER BY quote_date DESC";
$result = $conn->query($sql);
$result->data_seek(0); // reset pointer if already used in a loop
$quoteDataArray = [];
while ($row = $result->fetch_assoc()) {
    $ref = $row['ref_num'];
    $quoteDataArray[$ref] = $row;
}
?>
<?php include "../includes/header.php"; ?>

<head>
    <title>Quote List</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- JS libraries -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <style>
        .quote-table {
            padding: 60px;
            margin-top: 8rem;

        }

        #quoteTable {
            border-collapse: collapse;
        }

        /* Quote section title */
        h2 {
            font-family: 'Poppins', sans-serif;
            color: #0ca83e;
            text-align: center;
            font-weight: 900;
            border-radius: 8px;
        }

        /* Table header (th) styling */
        #quoteTable thead th {
            background-color: #0ca83e;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 0.75rem;
        }

        /* Table body (td) styling */
        #quoteTable tbody td {
            background-color: rgba(255, 176, 0, 0.25);
            color: black;

            padding: 0.75rem;
        }

        #quoteTable th,
        #quoteTable td {
            border: 1px solid grey;
        }


        @media screen and (max-width: 768px) {
            .quote-table {
                padding: 20px;
            }
        }

        /* Allow wrapping only for English and Chinese (columns 4 and 5) */
        #quoteTable td:nth-child(4),
        #quoteTable td:nth-child(5) {
            white-space: normal !important;
            word-wrap: break-word;
            width: 39%;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
        }

        form label {
            display: block;
            margin: 0.5rem 0 0.25rem;
            font-weight: bold;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .formContainer {
            display: flex;
            width: 100%;
            height: 90%;
            background-color: #ffffff;
            font-family: 'Poppins';
            border: 1px solid #ddd;
            overflow-y: auto;
        }

        .addForm,
        .editForm {
            background-color: #ffffff;
            width: 70%;
            flex: 1;
            padding: 40px;
            min-width: 300px;
            overflow-y: auto;
        }

        .quote-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #ffb000;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            cursor: pointer;

        }
    </style>
</head>

<body>
    <div class="quote-table">
        <div style="display: flex; justify-content: space-between; margin-bottom:2rem;">
            <h2>Quote of the Day</h2>

            <div style="text-align: center;">
                <a class="quote-button" id="openAddQuote">
                    Add Quote
                </a>
            </div>
        </div>

        <table id="quoteTable" class="display nowrap" style="width:100%;">
            <thead>
                <tr>
                    <th></th>
                    <th>Date</th>
                    <th>Author</th>
                    <th>English</th>
                    <th>Chinese</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $result->data_seek(0);
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <a class="quote-button editQuote" data-refnum="<?= $row['ref_num'] ?>">
                                    Edit <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td><?= $row['quote_date'] ?? '' ?></td>
                            <td><?= $row['author'] ?? '' ?></td>
                            <td><?= $row['en'] ?? '' ?></td>
                            <td><?= $row['cn'] ?? '' ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No quotes found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div id="quoteModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal('quoteModal')">&times;</span>
            <h2>Add Quote</h2>
            <div class="formContainer" style="justify-content: center">
                <form id="quoteForm" class="addForm">
                    <label>Quote Date</label>
                    <input type="date" name="quote_date" required>

                    <label>Author</label>
                    <input type="text" name="author">

                    <label for="en">English Quote<div id="enError"
                            style="color:red; font-size: 0.9rem; margin-bottom: 5px;"></div></label>

                    <textarea name="en" id="en" required></textarea>

                    <label for="cn">Chinese Quote <div id="cnError"
                            style="color:red; font-size: 0.9rem; margin-bottom: 5px;"></div></label>

                    <textarea name="cn" id="cn"></textarea>

                    <button class="quote-button" type="submit">Submit</button>
                </form>
            </div>
            <div id="quoteResult"></div>
        </div>
    </div>

    <div id="editQuoteModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal('editQuoteModal')">&times;</span>
            <h2>Edit Quote</h2>
            <div class="formContainer" style="justify-content: center">
                <form id="editQuoteForm" class="editForm">
                    <input id="editQuoteRefNum" type="hidden" name="ref_num" required>

                    <label>Quote Date</label>
                    <input id="editQuoteDate" type="date" name="quote_date" required>

                    <label>Author</label>
                    <input id="editQuoteAuthor" type="text" name="author">

                    <label for="en">English Quote<div id="editENError"
                            style="color:red; font-size: 0.9rem; margin-bottom: 5px;"></div></label>

                    <textarea id="editQuoteEN" name="en" required></textarea>

                    <label for="cn">Chinese Quote <div id="editCNError"
                            style="color:red; font-size: 0.9rem; margin-bottom: 5px;"></div></label>

                    <textarea id="editQuoteCN" name="cn"></textarea>

                    <button class="quote-button" type="submit">Submit</button>
                </form>
            </div>
            <div id="editQuoteResult"></div>
        </div>
    </div>

    <script>
        //pass php courses array object into js
        const quoteData = <?= json_encode($quoteDataArray, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

        $(document).ready(function () {
            $('#quoteTable').DataTable({
                responsive: true,
                columnDefs: [
                    {
                        targets: 0, //target first column
                        searchable: false,
                        orderable: false
                    }
                ]
            });

            document.getElementById('openAddQuote').addEventListener('click', () => {
                document.getElementById('quoteModal').style.display = 'flex';
            });

            document.addEventListener('click', (e) => {
                //Open Edit Quote Info
                const editButton = e.target.closest('.editQuote');
                if (editButton) {
                    const ref = editButton.dataset.refnum;
                    const row = quoteData[ref];
                    if (!row) return alert('Quote data not found.');

                    document.getElementById('editQuoteModal').style.display = 'flex';
                    document.getElementById('editQuoteRefNum').value = row.ref_num;
                    document.getElementById('editQuoteDate').value = row.quote_date;
                    document.getElementById('editQuoteAuthor').value = row.author;
                    document.getElementById('editQuoteEN').value = row.en;
                    document.getElementById('editQuoteCN').value = row.cn;
                }
            });
        });

        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        // Submit Add Quote Form
        document.getElementById('quoteForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const resultDiv = document.getElementById('quoteResult');

            const response = await fetch('../index/scripts/add-quote.php', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            const [status, message] = text.trim().split('|');

            if (status === 'success') {
                alert(' Quote added successfully! ');
                form.reset();
                closeModal('quoteModal');
                location.reload();
            } else {
                // Clear previous errors
                document.getElementById('enError').textContent = '';
                document.getElementById('cnError').textContent = '';
                resultDiv.innerHTML = '';

                if (status === 'error') {
                    try {
                        const errors = JSON.parse(message); // `field` now contains JSON string
                        if (errors.en) document.getElementById('enError').textContent = errors.en;
                        if (errors.cn) document.getElementById('cnError').textContent = errors.cn;
                    } catch (e) {
                        resultDiv.innerHTML = "<p style='color:red;'>" + field + "</p>";
                    }
                } else {
                    resultDiv.innerHTML = "<p style='color:red;'>" + msg + "</p>";
                }
            }
        });

        // Submit Edit Quote Form
        document.getElementById('editQuoteForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const resultDiv = document.getElementById('editQuoteResult');

            const response = await fetch('../index/scripts/edit-quote.php', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            const [status, message] = text.trim().split('|');

            if (status === 'success') {
                alert(' Quote edited successfully! ');
                form.reset();
                closeModal('editQuoteModal');
                location.reload();
            } else {
                alert('Failed to edit ');
                // Clear previous errors
                document.getElementById('editENError').textContent = '';
                document.getElementById('editCNError').textContent = '';
                resultDiv.innerHTML = '';

                if (status === 'error') {
                    try {
                        const errors = JSON.parse(message); // `field` now contains JSON string
                        if (errors.en) document.getElementById('editENError').textContent = errors.en;
                        if (errors.cn) document.getElementById('editCNError').textContent = errors.cn;
                    } catch (e) {
                        resultDiv.innerHTML = "<p style='color:red;'>" + e + "</p>";
                    }
                } else {
                    resultDiv.innerHTML = "<p style='color:red;'>" + status + "</p>";
                }
            }
        });

        // Close modal when clicking outside the modal content
        window.addEventListener('click', function (event) {
            const quoteModal = document.getElementById('quoteModal');
            const editQuoteModal = document.getElementById('editQuoteModal');

            if (event.target === quoteModal) {
                quoteModal.style.display = "none";
            }
            if (event.target === editQuoteModal) {
                editQuoteModal.style.display = "none";
            }
        });

    </script>
</body>

<?php include "../includes/footer.php"; ?>