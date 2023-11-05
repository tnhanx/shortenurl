<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #333;
            margin: 20px 0;
        }
        form {
            margin: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            width: 300px;
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
        }
        button[type="submit"] {
            background-color: #ddd;
            color: #333;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #ccc;
        }
        .result-container {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        button#copy-button {
            background-color: #ddd;
            color: #333;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        button#copy-button:hover {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <h1>URL Shortener</h1>
    <form method="POST" action="">
        <label for="url">Nhập đường dẫn URL:</label>
        <br>
        <input type="text" name="url" id="url" required>
        <br>
        <button type="submit" name="submit">Rút gọn URL</button>
    </form>

    <?php
    $error = ""; // Biến lưu thông báo lỗi

    if (isset($_POST['submit'])) {
        $long_url = urlencode($_POST['url']);
        $api_token = '13192d7873df8f76b9bbb4cc3600eaa4276d0c78';
        $alias = bin2hex(random_bytes(4)); // Tạo một alias ngẫu nhiên
        $api_url = "https://hqth.me/api?api={$api_token}&url={$long_url}&alias={$alias}";
        $result = @json_decode(file_get_contents($api_url), true);

        if ($result["status"] === 'error') {
            $error = implode(", ", $result["message"]); // Chuyển đổi mảng thành chuỗi
        }
    }

    // Kiểm tra xem có lỗi không trước khi hiển thị thông báo lỗi
    if (!empty($error)) {
        echo '<p>Lỗi: ' . $error . '</p>';
    }
    ?>

    <?php if (!empty($result["shortenedUrl"])) : ?>
        <div class="result-container">
            <p>Link rút gọn: 
                <a id="shortened-url" href="<?php echo $result["shortenedUrl"]; ?>"><?php echo $result["shortenedUrl"]; ?></a>
            </p>
            <button id="copy-button" onclick="copyToClipboard()">Copy</button>
        </div>
    <?php endif; ?>

    <script>
        function copyToClipboard() {
            var shortenedUrl = document.getElementById('shortened-url');
            var textArea = document.createElement("textarea");
            textArea.value = shortenedUrl.href;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert("Đã sao chép link rút gọn: " + shortenedUrl.href);
        }
    </script>
</body>
</html>
