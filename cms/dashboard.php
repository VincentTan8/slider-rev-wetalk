<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<?php include "../includes/header.php"; ?>

<head>
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" /> -->

    <title>Dashboard</title>
    <style>
        h2 {
            font-family: 'Poppins', sans-serif;
            margin-bottom: 1.5rem;
            color: #0ca83e;
            padding: 1rem;
            text-align: center;
            font-weight: 900;
            border-radius: 8px;
        }

        .dash-modal {
            justify-self: center;
            align-items: center;
        }

        .dashboard {
            margin-top: 8rem;
            padding: 2rem;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            justify-content: center;
        }

        .dashboard a {
            display: block;
            margin: 0.5rem 0;
            padding: 0.75rem;
            background-color: #ffb000;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
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

        form button {
            padding: 0.5rem 1rem;
            background-color: #ffb000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #357ab7;
        }

        .dashboard h2 {
            font-family: 'Poppins', sans-serif;
            margin-bottom: 1.5rem;
            color: #0ca83e;
            padding: 1rem;
            text-align: center;
            font-weight: 900;
            border-radius: 8px;
        }

        @media (max-width: 500px) {
            .dashboard {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="dash-modal">
        <div class="dashboard">
            <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
            <a id="openAddEntry">Add Translation</a>
            <a href="quote-list.php">Quote List</a>
            <a href="course-list.php">Course List</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <!-- Add Entry Modal -->
    <div id="entryModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal('entryModal')">&times;</span>
            <h2>Add Translation</h2>
            <form id="entryForm">
                <label for="web_page">Page Data Name:</label>
                <input type="text" name="web_page">

                <label for="element_id">Element ID:</label>
                <input type="text" name="element_id" required>

                <label for="en">English (en):</label>
                <textarea name="en"></textarea>

                <label for="cn">Chinese (cn):</label>
                <textarea name="cn"></textarea>

                <label for="kr">Korean (kr):</label>
                <textarea name="kr"></textarea>

                <label for="jp">Japanese (jp):</label>
                <textarea name="jp"></textarea>

                <div class="button-group">
                    <button type="submit">Add Entry</button>
                </div>
                <div id="entryResult" class="result"></div>
            </form>
        </div>
    </div>

    <script>
        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }
        document.getElementById('openAddEntry').addEventListener('click', () => {
            document.getElementById('entryModal').style.display = 'flex';
        });

        // Close modal when clicking outside the modal content
        window.addEventListener('click', function (event) {
            const entryModal = document.getElementById('entryModal');
            if (event.target === entryModal) entryModal.style.display = "none";
        });

        //Submit translation entry
        document.getElementById('entryForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const resultDiv = document.getElementById('entryResult');

            const response = await fetch('add-entry.php', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            const [status, message] = text.trim().split('|');

            if (status === 'success') {
                alert(' Translation added successfully! ');
                form.reset();
                closeModal('entryModal');
                location.reload();
            } else {
                // Clear previous errors
                resultDiv.innerHTML = '';

                if (status === 'error') {
                    resultDiv.innerHTML = "<p style='color:red;'>" + message + "</p>";
                }
            }
        });

    </script>
    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php include "../includes/footer.php"; ?>