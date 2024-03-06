<?php
$servidor = "localhost";
$base_datos = "tasa_insercion";
$usuario = "root";
$clave = "";

$conn = new mysqli($servidor, $usuario, $clave , $base_datos);

if ($conn->connect_error) {
    die("Conexion Fallida:" . $conn->connect_error);
}
$cod_facultad = $_POST['cod_facultad'];
$nom_facultad = $_POST['nom_facultad'];
$cod_carrera = $_POST['cod_carrera'];
$nom_carrera = $_POST['nom_carrera'];

if (empty($cod_facultad) || empty($nom_facultad) || empty($cod_carrera) || empty($nom_carrera)) {
    echo "<script>alert('Todos los campos deben ser llenados.');history.back();</script>";
    exit;
}
if (strlen($cod_facultad) > 12 || strlen($cod_carrera) > 12) {
    echo "<script>alert('El código de facultad y carrera solo puede tener un máximo de 12 caracteres.');history.back();</script>";
    exit;
}

$sql = "SELECT * FROM Facultades WHERE nom_facultad = '$nom_facultad'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  if ($row['cod_facultad'] != $cod_facultad) {
    echo "<script>alert('El código de facultad no coincide con el nombre de la facultad.');history.back();</script>";
    exit;
  }
} else {

  $sql = "INSERT INTO Facultades (cod_facultad, nom_facultad)
          VALUES ('$cod_facultad', '$nom_facultad')";
  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Nueva facultad creada exitosamente.');</script>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit;
  }
}
$sql = "SELECT * FROM Carreras WHERE cod_carrera = '$cod_carrera'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<script>alert('El código de carrera ya existe.');history.back();</script>";
  exit;
} else {
  
  $sql = "SELECT * FROM Carreras WHERE nom_carrera = '$nom_carrera'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<script>alert('El nombre de la carrera ya existe.');history.back();</script>";
    exit;
  } else {
    
    $sql = "INSERT INTO Carreras (cod_carrera, nom_carrera, cod_facultad)
            VALUES ('$cod_carrera', '$nom_carrera', '$cod_facultad')";
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Nueva carrera creada exitosamente.');window.location.href='index2.php';</script>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit;
    }
  }
}
$conn->close();
?>