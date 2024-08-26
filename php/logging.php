<?php
include "";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT , name, email, password FROM  WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Define as variáveis de sessão
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            // Redirecionamento para a página inicial
            header('Location: ');
            exit;
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
    $stmt->close();
    $conn->close();
} else {
    // Caso não o metodo não seja POST, então retorna para a página inicial em logoff
    header('Location: ');
    exit;
}
