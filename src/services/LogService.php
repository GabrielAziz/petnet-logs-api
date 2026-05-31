<?php
namespace App\services;

use App\repositories\LogRepository;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class LogService
{
    private LogRepository $repository;

    public function __construct()
    {
        $this->repository = new LogRepository();
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): array|false
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): void
    {
        // Valida a existência de uma chave no array e aplica regras ao valor dessa chave
        v::key('entity',      v::stringType()->notEmpty()->length(1, 50))
         ->key('action',      v::stringType()->notEmpty()->length(1, 50))
         ->key('status',      v::stringType()->notEmpty()->length(1, 20))
         ->key('created_at',  v::dateTime('Y-m-d H:i:s'))
         ->key('responsible', v::optional(v::stringType()->length(1, 11)), false)
         ->key('details',     v::optional(v::stringType()), false)
         ->assert($data);

        $this->repository->create($data);
    }
}