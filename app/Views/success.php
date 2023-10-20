<!DOCTYPE html>
<html>
<head>
    <title>Registrado correctamente</title>
    <?php echo $this->include('/layout/navbar.php'); ?>
    <?php echo $this->include('/layout/footer.php'); ?>
    <script>
        alert('Registrado correctamente, ya puedes acceder a tu cuenta.');
        window.location.href = 'http://localhost/libreria/public/login';
    </script>
</head>
<body>
</body>
</html>