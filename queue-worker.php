#!/usr/bin/php
<?php
#$command = "cd /home/hotsystems/Documentos/novo_eglise && nohup php artisan queue:work --once > /tmp/queue-work.log &";
$command = "ls -l > /tmp/queue-work.log &";
$returnVar = NULL;
$output  = NULL;
exec($command, $output, $returnVar);
?>