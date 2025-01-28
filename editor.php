<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php 
    error_reporting(0);
    $get = $_GET['file'];
    if ($get) {
        $info = pathinfo($_GET['file'])['filename'];
    } else {
        $info = 'route editor';
    }
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


.menu-container {
        position: fixed;
        top: 0;
        right: -300px; 
        width: 300px; 
        height: 100%; 
        background-color: #170e1c; 
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.5);
        transition: right 0.3s ease; 
        z-index: 8; 
}

.toggle-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    cursor: pointer;
    font-size: 24px;
    color: #ffffff;
    z-index: 9;
    background: #7d177669;
    border-radius: 11px;
    padding: 3px 9px;
}

.menu-container ul {
    list-style-type: none;
    padding: 9px;
    margin: 0;
}

.menu-container li {
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    padding: 8px 11px;
    cursor: pointer;
    color: #ffffffd6;
}

.menu-container li:hover {
    background-color: #ffffff0f; 
    border-radius: 8px;
}

li a {
    margin-left: auto; 
    color:#e0a5f7;
    text-decoration: none;
    white-space: nowrap; 
}

li a:hover {
    text-decoration: underline;
    color:#bdece6;
}

</style>
</head>
<body>
<div id="success-message">Successful</div>
<div id="error-message">An error occurred.</div>
<button id="save-btn">Save</button>
<div id="editor-container"></div>

<div class="menu-container" id="menu">
    <ul id="file-list"></ul>
</div>
    <div class="toggle-btn" id="toggle-menu">•••</div>

<!-- لود کردن CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/monaco-editor@latest/min/vs/editor/editor.main.min.css">
<script src="https://cdn.jsdelivr.net/npm/monaco-editor@latest/min/vs/loader.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@latest/dist/jquery.min.js"></script>
<script>
function getUrl() {
    const currentUrl = window.location.href; 
    const parsedUrl = new URL(currentUrl); 
    const fileParam = parsedUrl.searchParams.get("file"); 
    return fileParam !== null ? fileParam : ''; 
}
function loadFolders(folder) {
    $.ajax({
        url: 'vendor/natilosir/bot/load_file.php?folder=' + encodeURIComponent(folder),
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#file-list').empty();
            $.each(data, function(index, item) {
                itemType = item.type ? '📂 ' : '📄 ';
                TypeSlug = item.type ? 'folder' : 'file';
                link = `<a href="editor.php?file=${item.slug}">➡</a>`;

                $('#file-list').append(`<li class="${TypeSlug}" slug="${item.slug}">${itemType} ${item.name} ${link}</li>`);
            });
        },
        error: function(xhr, status, error) {
            $('#file-list').html('<li>خطا در بارگذاری داده‌ها: ' + error + '</li>');
        }
    });
}



$(document).ready(function () {
    $('#file-list').on('click', '.folder', function() {
    var folderName = $(this).attr('slug');
    loadFolders(folderName); 
});

loadFolders(getUrl());


$(document).on('keydown', function(e) {
    if (e.ctrlKey && e.code === 'KeyS') {
        e.preventDefault(); 
        $('#save-btn').click(); 
    }
});

const setEditorHeight = () => {
    const windowHeight = $(window).height()-2;
    const windowwidth = $(window).width()-2;
    const buttonHeight = $('#save-btn').outerHeight(true);
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
        $get = $_GET['file'];
        if ($get) {
            $info = pathinfo($_GET['file'])['extension'];
        } else {
            $info = 'php';
        }
        if ($info == 'js') {
            $info = 'javascript';
        }
        echo $info; ?>', 
            theme: "vs-dark",
            fontFamily: "FiraCode", 
            fontSize: 11.9, 
            lineHeight: 19,
            fontLigatures: true,    

            });
            Url=getUrl()

        if (Url) {fileUrl=Url;}else{fileUrl='route.php';}
        
        function loadFile(fileUrl) {
            $.ajax({
                url: "vendor/natilosir/bot/load_file.php",
                type: "GET",
                data: { file: fileUrl },
                success: function (data) {
                editor.setValue(data); 
                },
                error: function () {
                    $('#error-message').html('⚠️ Error Opening file ⚠️<br>Please press Ctrl+S to create a new one.<br>Example open file: editor.php?file=route.php').fadeIn();
                    setTimeout(function () {
                        $('#error-message').fadeOut();
                    }, 15000);                
                }
            });
            return fileUrl
        }

        loadFile(fileUrl);
        $('#file-list').on('click', '.file', function() {
            var folderName = $(this).attr('slug');
            fileUrl=loadFile(folderName); 
        });

    });

    $('#save-btn').click(function () {
        
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

        $.ajax({
            url: "vendor/natilosir/bot/save_code.php",
            type: "POST",
            data: {
                url: fileUrl,
                editor: text
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

    $('#toggle-menu').click(function() {
    var menu = $('#menu');
    if (menu.css('right') === '0px') {
        menu.css('right', '-300px'); 
    } else {
        menu.css('right', '0'); 
    }
    });

$(document).click(function(event) {
    if (!$(event.target).closest('#menu').length && !$(event.target).closest('#toggle-menu').length) {
        $('#menu').css('right', '-300px'); 
    }
});

});
</script>
</body>
</html>
