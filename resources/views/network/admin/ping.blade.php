<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ping Monitor</title>
</head>
<body>
    <div>
        <h3 style="text-align: center">Ping IP: {{request()->get('ip')}}</h3>
        

        <?php

            $ip = request()->get('ip');
            
            $cmd = "ping -n 10 $ip";

            while (@ ob_end_flush()); // end all output buffers if any

            $proc = popen($cmd, 'r');

            $live_output     = "";
            echo '<pre>';
            while (!feof($proc))
            {
                $live_output     = fread($proc, 4096);
                
                echo "$live_output";
                
                @ flush();
            }
            echo '</pre>';
            

        
        // if($_SESSION['ip']){
        //     if($_SESSION['ip'] != request()->get('ip')){

        //         $ip = request()->get('ip');
        //         session_start();
        //         $_SESSION['ip'] = $ip;
        //     }
            
        // }else{
        //     $ip = request()->get('ip');
        //     session_start();
        //     $_SESSION['ip'] = $ip;
        // }

        //$commandString = 'start /b c:\\programToRun.exe -attachment "c:\\temp\file1.txt"';
        //$commandString = 'start /b c:\\ -attachment "c:\\temp\file1.txt"';
        ?>
    </div>

    <script>
        
        window.onbeforeunload = function (e) {
            e = e || window.event;

            if (e) {
                e.returnValue = 'Any string';
            }

            return 'Any string';
        };
    </script>
</body>
</html>