<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface {

    // model property on class instances
    protected $model;
    protected $per_page_records;

    // Constructor to bind model to repo
    public function __construct(Model $model) {
        $this->model = $model;
        $this->per_page_records = $this->model->per_page ? $this->model->per_page : '10';
    }

    // Get all instances of model
    public function all() {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data) {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id) {
        $record = $this->model->findOrFail($id);
        return $record->update($data);
    }

    // Active record in the database
    public function isActive(array $data, $id) {
        $record = $this->model->findOrFail($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id) {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id) {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel() {
        return $this->model;
    }

    // Set the associated model

    public function setModel($model) {
        $this->model = $model;

        return $this;
    }

    // Eager load database relationships
    public function with($relations) {
        return $this->model->with($relations);
    }

    public function getpaginatedRecords() {
        return $this->model->paginate($this->per_page_records);
    }

}
