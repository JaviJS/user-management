<?php
namespace App\Repositories;

/**
 * Interface RepositoryInterface
 * Define los métodos básicos que debe implementar cualquier repositorio en la aplicación.
 */
interface RepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id);
}