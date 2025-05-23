<?php

namespace App\Repositories\Eloquent\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface EloquentRepositoryContract.
 */
interface EloquentRepositoryContract
{
    public function query(): Builder;

    public function insert(array $rows): bool;

    public function create(array $attributes);

    public function delete(int|Model $model): ?bool;

    public function destroy(array|Collection $ids): int;

    public function update(Model $model, array $data, array $fillable = []): ?Model;

    public function updateOrCreate(array $data, array $conditions);

    public function find(int $id): ?Model;

    public function findWithRelations(int $id, array $relations): ?Model;

    public function findOneBy(array $conditions, array $relations = []): ?Model;

    public function findBy(array $conditions, array $relations = [], bool $paginate = true, int $pageSize = 10): Collection|LengthAwarePaginator;

    public function findAll(): Collection;

    public function countBy(array $conditions): int;

    public function with(array $relations): Builder;
}
