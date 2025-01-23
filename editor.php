<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $get=$_GET['file'];
                    if($get){$info=pathinfo($_GET['file'])['filename'];}else{$info='save text';}
                    echo strtoupper($info); ?></title>
    <style>
@font-face {
    font-family: 'FiraCode';
    src: url('https://dl.natilos.ir/ffff/FiraCode-Medium.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
}

.monaco-editor {
    font-family: 'FiraCode';
}

html, body {
    font-family: 'FiraCode';
    background:#1e1e1e;
    margin: 0;
    padding: 0;
}
#save-btn {
    font-family: 'FiraCode';
    position: fixed;
    z-index: 6;
    right: 0px;
    border-bottom-left-radius: 18px;
    padding: 10px 20px;
    background-color: #7d1776d1;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
    opacity: 0.5;
    transition: opacity 0.25s ease;
}
#save-btn:hover {
    opacity: 1;
}
#error-message {
    display: none;
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: #f44336;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    z-index: 99;
    font-size: 16px;
    transition: opacity 0.3s ease;
}
#success-message {
    display: none;
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 999;
    font-size: 16px;
        }
    </style>
</head>
<body>
<div id="success-message">Successful</div>
<div id="error-message">An error occurred.</div>
<button id="save-btn">Save</button>
<div id="editor-container"></div>

<!-- لود کردن CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/monaco-editor@latest/min/vs/editor/editor.main.min.css">
<script src="https://cdn.jsdelivr.net/npm/monaco-editor@latest/min/vs/loader.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@latest/dist/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('keydown', function(e) {
            if (e.ctrlKey && e.code === 'KeyS') {
                e.preventDefault(); // جلوگیری از رفتار پیش‌فرض مرورگر برای ctrl+s
                $('#save-btn').click(); // کلیک کردن دکمه
            }
        });

        // تنظیم ارتفاع ویرایشگر به 100% صفحه
        const setEditorHeight = () => {
            const windowHeight = $(window).height()-2;
            const windowwidth = $(window).width()-2;
            const buttonHeight = $('#save-btn').outerHeight(true); // محاسبه ارتفاع دکمه
            $('#editor-container').height(windowHeight).width(windowwidth);
        };

        // فراخوانی تابع برای تنظیم ارتفاع اولیه
        setEditorHeight();

        // به‌روزرسانی ارتفاع هنگام تغییر اندازه صفحه
        $(window).resize(setEditorHeight);

        // تنظیمات موناکو
        let editor;
      require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.52.2/min/vs' }});

        // ایجاد ویرایشگر
  require(['vs/editor/editor.main'], function() {
            editor = monaco.editor.create(document.getElementById('editor-container'), {
                language: '<?php 
                error_reporting(0);
                $get=$_GET['file'];
                    if($get){$info=pathinfo($_GET['file'])['extension'];}else{$info='php';}
                    if($info=="js"){$info="javascript";}
                    echo $info; ?>', // زبان کدنویسی
                    theme: "vs-dark",
                        fontFamily: "FiraCode", 
                            fontSize: 11.9, 
                            lineHeight: 19,
                            fontLigatures: true,    

                  });

            // دریافت فایل از سرور
            const urlParams = new URLSearchParams(window.location.search);
            const Url = urlParams.get('file');
            if (Url) {fileUrl=Url;}else{fileUrl='route.php';}
            $.ajax({
                url: "vendor/natilosir/bot/load_file.php",
                type: "GET",
                data: { file: fileUrl },
                success: function (data) {
                    editor.setValue(data);
                },
                error: function () {
                    $('#error-message').html('⚠️ Error opening file ⚠️<br>Please press Ctrl+S to create a new one.<br>Example open file: editor.php?file=route.php').fadeIn();
                    setTimeout(function () {
                        $('#error-message').fadeOut();
                    }, 15000);                
                }
            });

        });

        // دکمه ذخیره تغییرات
        $('#save-btn').click(function () {
            // دریافت متن و جایگزینی‌ها
            let text = editor.getValue();
            text = text.replace(/<\?php/g, 'd&ff')
                .replace(/POST/g, 'df&n')
                .replace(/GET/g, 'vf&jc')
                .replace(/"/g, '&#34;')
                .replace(/call_user_func/g, 'dw#34;')
                .replace(/readfile/g, 'c&dcd')
                .replace(/substr/g, 'fg&hg')
                .replace(/'/g, '&#39;')
                .replace(/\/\/php/g, 't&cf')
                .replace(/>/g, '&enz')
                .replace(/</g, '&wfc')
                .replace(/php:\/\//g, 'p&ff');

            // ارسال داده‌ها به سرور
            const urlParams = new URLSearchParams(window.location.search);
            const fileUrl = urlParams.get('file');
            $.ajax({
                url: "vendor/natilosir/bot/save_code.php",
                type: "POST",
                data: {
                    editor: text,
                    url: fileUrl
                },
                success: function (response) {
                    $('#error-message').fadeOut();
                    $('#success-message').fadeIn();
                    setTimeout(function () {
                        $('#success-message').fadeOut();
                    }, 2000);
                },
                error: function () {
                    $('#error-message').text('Error saving file').fadeIn();
                    setTimeout(function () {
                        $('#error-message').fadeOut();
                    }, 2000);
                }
            });
        });
    });
</script>
</body>
</html>
