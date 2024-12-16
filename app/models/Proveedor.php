<?php

class Proveedor
{
    private $conn;
    private $table = 'proveedores';

    public $id;
    public $nombre;
    public $rut;
    public $web;
    public $direccion_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function find($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar valores a las propiedades del objeto
        if ($result) {
            $this->id = $result['id'];
            $this->nombre = $result['nombre'];
            $this->rut = $result['rut'];
            $this->web = $result['web'];
            $this->$direccion_id = $result['$direccion_id'];
        }

        return $result;
    }

    public function all()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " (nombre, rut, web, direccion_id) VALUES (:nombre, :rut, :web, :direccion_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':rut', $this->rut, PDO::PARAM_STR);
        $stmt->bindParam(':web', $this->web, PDO::PARAM_STR);
        $stmt->bindParam(':direccion_id', $this->direccion_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE " . $this->table . " SET nombre = :nombre, rut = :rut, web = :web, direccion_id = :direccion_id =  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':rut', $this->rut, PDO::PARAM_STR);
        $stmt->bindParam(':web', $this->web, PDO::PARAM_STR);
        $stmt->bindParam(':direccion_id', $this->direccion_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>