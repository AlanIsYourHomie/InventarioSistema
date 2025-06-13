<?php
session_start();
session_unset();
session_destroy();
echo json_encode(['status' => 'ok', 'message' => 'Sesion cerrada']);
