<?php

class UsuarioDAO
{
    private $conn;

    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }

    public function insertar(Usuario $u)
    {
        $query = "INSERT INTO usuarios (email, password, nombre, telefono, poblacion) VALUES (?,?,?,?,?)";
        if (!$stmt = $this->conn->prepare($query)) {
            die("Error al preparar la sentencia" . $this->conn->error);
        }
        $email = $u->getEmail();
        $password = $u->getPassword();
        $nombre = $u->getNombre();
        $telefono = $u->getTelefono();
        $poblacion = $u->getPoblacion();

        $stmt->bind_param('sssis', $email, $password, $nombre, $telefono, $poblacion);
        $stmt->execute();
    }

    public function obtenerPorEmail($email){
        $query = "SELECT * FROM usuarios WHERE email = ?";
        if(!$stmt = $this->conn->prepare($query)){
            die("Error al preparar la sentencia: " . $this->conn->error);
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $usuario = $result->fetch_object('Usuario');

        return $usuario;

    }
}
