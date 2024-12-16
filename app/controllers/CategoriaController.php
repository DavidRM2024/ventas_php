<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController
{

    public function show($id, $db)
    {
        try {

            // Obtener la Categoria desde el modelo
            $categoria = new Categoria($db);
            $categoria->find($id);

            return [
                'success' => true,
                'data' => $categoria
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener la categoria: ' . $e->getMessage()
            ];
        }
    }

    public function index($db)
    {
        try {

            // Obtener todas las Categorias
            $categoria = new Categoria($db);
            $categorias = $categoria->all();

            return [
                'success' => true,
                'data' => $categorias
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener las categorias: ' . $e->getMessage()
            ];
        }
    }

    public function store($data, $db)
    {
        try {

            // Crear un nuevo objeto Categoria
            $categoria = new Categoria($db);
            $categoria->nombre = $data['nombre'];
            $categoria->descripcion = $data['descripcion'];
        

            if ($categoria->create()) {
                return [
                    'success' => true,
                    'message' => 'Categoria creada exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al crear la categoria'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al crear la categoria: ' . $e->getMessage()
            ];
        }
    }

    public function update($id, $data, $db)
    {
        try {

            // Obtener la categoria existente
            $categoria = new Categoria($db);
            $categoria->find($id);

            // Actualizar los datos de la categoria
            $categoria->nombre = $data['nombre'];
            $categoria->descripcion = $data['descripcion'];

            if ($categoria->update()) {
                return [
                    'success' => true,
                    'message' => 'Categoria actualizada exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar la categoria'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al actualizar la categoria: ' . $e->getMessage()
            ];
        }
    }

    public function delete($id, $db)
    {
        try {

            // Obtener la categoria existente
            $categoria = new Categoria($db);
            $categoria->find($id);

            if ($categoria->delete()) {
                return [
                    'success' => true,
                    'message' => 'Categoria eliminada exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al eliminar la Categoria'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar la Categoria: ' . $e->getMessage()
            ];
        }
    }
}
