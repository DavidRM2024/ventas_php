<?php

class Producto
{
    private $conn;
    private $table = 'productos';

    public $id;
    public $nombre;
    public $precio;
    public $stock;
    public $categoria_id;
    public $proveedor_id;

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
            $this->precio = $result['precio'];
            $this->stock = $result['stock'];
            $this->categoria_id = $result['categoria_id'];
            $this->proveedor_id = $result['proveedor_id'];
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
        $query = "INSERT INTO " . $this->table . " (nombre, precio, stock, categoria_id, proveedor_id) VALUES (:nombre, :precio, :stock, :categoria_id, :proveedor_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':precio', $this->precio, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);
        $stmt->bindParam(':categoria_id', $this->categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':proveedor_id', $this->proveedor_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE " . $this->table . " SET nombre = :nombre, precio = :precio, stock = :stock, categoria_id = :categoria_id, proveedor_id = :proveedor_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':precio', $this->precio, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);
        $stmt->bindParam(':categoria_id', $this->categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':proveedor_id', $this->proveedor_id, PDO::PARAM_INT);

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