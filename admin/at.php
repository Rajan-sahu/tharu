<?php
// client_log_server.php
set_time_limit(0);

// $host = "192.168.29.180"; 
$host = "0.0.0.0";  // Listen on all interfaces
$port = 8080;       // Choose a port (set same in device settings)

$logFile = __DIR__ . "/client_logs.txt";

// Create TCP socket
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($sock === false) {
    die("Socket create error: " . socket_strerror(socket_last_error()) . "\n");
}

// Bind socket
if (!socket_bind($sock, $host, $port)) {
    die("Socket bind error: " . socket_strerror(socket_last_error($sock)) . "\n");
}

// Start listening
if (!socket_listen($sock)) {
    die("Socket listen error: " . socket_strerror(socket_last_error($sock)) . "\n");
}

echo "Client Log server started on $host:$port\n";

while (true) {
    $client = socket_accept($sock);
    if ($client === false) {
        continue;
    }

    $input = socket_read($client, 4096); // read up to 4KB
    if ($input) {
        $logEntry  = "=============================\n";
        $logEntry .= "Time: " . date("Y-m-d H:i:s") . "\n";
        $logEntry .= "Raw Data: " . $input . "\n";
        $logEntry .= "=============================\n\n";

        file_put_contents($logFile, $logEntry, FILE_APPEND);
        echo "Log saved: " . substr($input, 0, 50) . "...\n";
    }

    // Respond to device (many devices expect a simple ACK)
    socket_write($client, "OK\n");

    socket_close($client);
}
socket_close($sock);