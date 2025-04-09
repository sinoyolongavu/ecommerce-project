<?php

// Function to hash password and generate SQL update queries for users
function generatePasswordUpdateQuery($userEmail) {
    // Set the password
    $password = "user123";
    
    // Hash the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Return the SQL query to update the user's password based on their email
    return "UPDATE users SET password = '$hashed_password' WHERE email = '$userEmail';";
}

// User emails
$userEmails = [
    'john.doe@example.com',
    'jane.smith@example.com',
    'michael.johnson@example.com',
    'emily.brown@example.com',
    'david.wilson@example.com'
];

// Generate and display SQL update queries for each user
foreach ($userEmails as $email) {
    echo generatePasswordUpdateQuery($email) . "<br>";
}

?>

<!--
UPDATE users SET password = '$2y$10$yNYV9sPbClwOmWWXuxKbi.viIg7dFfg3pvvriffyKKMcK1NLQHx9u' WHERE email = 'john.doe@example.com'
UPDATE users SET password = '$2y$10$mO2Z9.1.EUPf4ZBXn2gpRuECaeqxd/QEU9yLkXVCYaXd/B3AbE4Vm' WHERE email = 'jane.smith@example.com'
UPDATE users SET password = '$2y$10$eo4FvtwTSU5uwADytWUZy.LBjKW6iGm/KVt42ZKjWxxmVpHsYx7L2' WHERE email = 'michael.johnson@example.com'
UPDATE users SET password = '$2y$10$QhPzHCd9IEzpUMJ6uMR/T.psvJn3u1UdEgw2u9zmFTmpNmvXtO4PO' WHERE email = 'emily.brown@example.com'
UPDATE users SET password = '$2y$10$Jrf7iujDIHFaeHJB1ku3YuGxojmAeGbV82ofdZz8gnQbHrGG.RSgq' WHERE email = 'david.wilson@example.com' -->