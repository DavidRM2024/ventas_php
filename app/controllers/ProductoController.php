<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Producto.php';

class ProductoController
{

    public function show($id, $db)
    {
        try {

            // Obtener el producto desde el modelo
            $producto = new Producto($db);
            $producto->find($id);

            return [
                'success' => true,
                'data' => $producto
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener el producto: ' . $e->getMessage()
            ];
        }
    }

    public function index($db)
    {
        try {

            // Obtener todos los productos
            $producto = new Producto($db);
            $productos = $producto->all();

            return [
                'success' => true,
                'data' => $productos
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener los productos: ' . $e->getMessage()
            ];
        }
    }

    public function store($data, $db)
    {
        try {

            // Crear un nuevo objeto Producto
            $producto = new Producto($db);
            $producto->nombre = $data['nombre'];
            $producto->precio = $data['precio'];
            $producto->stock = $data['stock'];
            $producto->categoria_id = $data['categoria_id'];
            $producto->proveedor_id = $data['proveedor_id'];

            if ($producto->create()) {
                return [
                    'success' => true,
                    'message' => 'Producto creado exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al crear el producto'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al crear el producto: ' . $e->getMessage()
            ];
        }
    }

    public function update($id, $data, $db)
    {
        try {

            // Obtener el producto existente
            $producto = new Producto($db);
            $producto->find($id);

            // Actualizar los datos del producto
            $producto->nombre = $data['nombre'];
            $producto->precio = $data['precio'];
            $producto->stock = $data['stock'];
            $producto->categoria_id = $data['categoria_id'];
            $producto->proveedor_id = $data['proveedor_id'];

            if ($producto->update()) {
                return [
                    'success' => true,
                    'message' => 'Producto actualizado exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar el producto'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al actualizar el producto: ' . $e->getMessage()
            ];
        }
    }

    public function delete($id, $db)
    {
        try {

            // Obtener el producto existente
            $producto = new Producto($db);
            $producto->find($id);

            if ($producto->delete()) {
                return [
                    'success' => true,
                    'message' => 'Producto eliminado exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al eliminar el producto'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el producto: ' . $e->getMessage()
            ];
        }
    }
}
