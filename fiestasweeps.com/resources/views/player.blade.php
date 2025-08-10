<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Dashboard - Fiesta Sweeps</title>
    @vite('resources/js/app.js')
    <style>
        #blade-preloader .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #mainErrorBlock{
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            display: none;
            flex-direction: column;
            justify-content: center;
            background: #b22234;
            align-items: center;
            color: #fff;
        }
        #mainErrorBlock button{
            background-color: #dcdcdc; /* Green background */
            color: #b22234; /* Text color */
            padding: 12px 24px; /* Top & Bottom, Left & Right padding */
            border: none; /* Remove border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Cursor on hover */
            font-size: 16px; /* Text size */
            transition: background-color 0.3s, transform 0.2s;
        }
        #mainErrorBlock button:hover{
            background-color: #ebebeb;
            color: #c23749;
        }
    </style>
</head>
<body>
    <div id="root"></div>
    <div id="mainErrorBlock">
        <p>Something is broken, please click button to reload page</p>
        <button onclick="window.location.reload();">Reload</button>
    </div>
    <div id="blade-preloader" style="position: fixed; top:0; left:0; width:100%; height:100%; background:#fff; display:flex; align-items:center; justify-content:center; z-index:9999;">
        <div class="spinner"></div>
    </div>
</body>
<script>
  window.onload = function() {
    document.getElementById('blade-preloader').style.display = 'none';
  }
</script>
</html>
