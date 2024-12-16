<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Proveedor.php';

class ProveedorController
{

    public function show($id, $db)
    {
        try {

            // Obtener el Proveedor desde el modelo
           $proveedor = new Proveedor($db);
           $proveedor->find($id);

            return [
                'success' => true,
                'data' =>$proveedor
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener el Proveedor: ' . $e->getMessage()
            ];
        }
    }

    public function index($db)
    {
        try {

            // Obtener todos los Provedor
           $proveedor = new Proveedor($db);
            $provedores =$proveedor->all();

            return [
                'success' => true,
                'data' => $provedores
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener los Provedores: ' . $e->getMessage()
            ];
        }
    }

    public function store($data, $db)
    {
        try {

            // Crear un nuevo objeto Proveedor
           $proveedor = new Proveedor($db);
           $proveedor->nombre = $data['nombre'];
           $proveedor->rut = $data['rut'];
           $proveedor->web = $data['web'];
           $proveedor->direccion_id = $data['direccion_id'];

            if ($proveedor->create()) {
                return [
                    'success' => true,
                    'message' => 'Proveedor creado exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al crear el Proveedor'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al crear el Proveedor: ' . $e->getMessage()
            ];
        }
    }

    public function update($id, $data, $db)
    {
        try {

            // Obtener el Proveedor existente
           $proveedor = new Proveedor($db);
           $proveedor->find($id);

            // Actualizar los datos del Proveedor
           $proveedor->nombre = $data['nombre'];
           $proveedor->rut = $data['rut'];
           $proveedor->web = $data['stock'];
           $proveedor->direccion_id = $data['direccion_id'];

            if ($proveedor->update()) {
                return [
                    'success' => true,
                    'message' => 'Proveedor actualizado exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar el Proveedor'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al actualizar el Proveedor: ' . $e->getMessage()
            ];
        }
    }

    public function delete($id, $db)
    {
        try {

            // Obtener el Proveedor existente
           $proveedor = new Proveedor($db);
           $proveedor->find($id);

            if ($proveedor->delete()) {
                return [
                    'success' => true,
                    'message' => 'Proveedor eliminado exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al eliminar el Proveedor'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el Proveedor: ' . $e->getMessage()
            ];
        }
    }
}
