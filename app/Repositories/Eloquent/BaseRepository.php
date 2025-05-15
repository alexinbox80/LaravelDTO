<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Repositories\Eloquent\Contracts\EloquentRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\RepositoryException;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements EloquentRepositoryContract
{
    /**
     * Fillable attributes of a model.
     *
     * @var array
     */
    protected array $fillable = [];

    /**
     * @var Model
     */
    protected Model $model;

    /**
     * Eloquent query builder.
     *
     * @var Builder
     */
    protected Builder $query;

    /**
     * BaseRepository constructor.
     *
     * @throws RepositoryException
     */
    public function __construct()
    {
        $this->model = $this->loadModel();
    }

    /**
     * The base query builder instance.
     *
     * @throws BindingResolutionException
     * @throws RepositoryException
     */
    public function query(): Builder
    {
        if ($this->query instanceof Builder) {
            return $this->query;
        }

        return $this->model->newQuery();
    }

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @return Model|static
     */
    public function updateOrCreate(array $data, array $conditions): Model|static
    {
        return $this->model->updateOrCreate($data, $conditions);
    }

    /**
     * Bulk insert.
     */
    public function insert(array $rows): bool
    {
        return $this->query()->insert($rows);
    }

    /**
     * Count records by condition.
     *
     * @param array $conditions
     * @return int
     * @throws BindingResolutionException
     * @throws RepositoryException
     */
    public function countBy(array $conditions): int
    {
        return $this->query()->where($conditions)->count();
    }

    /**
     * Find a model by its primary key.
     *
     * @param int $id Id of the searched entity
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Find all models.
     */
    public function findAll(): Collection
    {
        return $this->query()->get();
    }

    /**
     * Find a model with its relations.
     */
    public function findWithRelations(int $id, array $relations): ?Model
    {
        return $this
            ->query()
            ->with($relations)
            ->find($id);
    }

    /**
     * Find a collection of models by conditions.
     *
     * @param array $conditions Array of conditions
     * @param array $relations  An array of relations
     * @param bool  $paginate   Either paginated or not
     * @param int   $pageSize   Page size
     *
     * @return ?Collection|?LengthAwarePaginator A collection or paginated result
     */
    public function findBy(array $conditions, array $relations = [], bool $paginate = true, int $pageSize = 10): Collection|LengthAwarePaginator
    {
        $query = $this
            ->query()
            ->with($relations)
            ->where($conditions);

        return $paginate ? $query->paginate($pageSize) : $query->get();
    }

    /**
     * Find a model by conditions.
     *
     * @param array $conditions Array of conditions
     * @param array $relations  An array of relations
     */
    public function findOneBy(array $conditions, array $relations = []): ?Model
    {
        return $this
            ->query()
            ->with($relations)
            ->where($conditions)
            ->first();
    }

    /**
     * Delete a database entity.
     *
     * @param int|Model $model An entity object or its id
     *
     * @throws RepositoryException Exception if no associated model found
     */
    public function delete(int|Model $model): ?bool
    {
        if (is_numeric($model)) {
            $model = $this->find($model);
            if (!$model instanceof Model) {
                throw new RepositoryException('Model not found!');
            }
        }

        return $model->delete();
    }

    /**
     * Destroy an array or collection of ids.
     *
     * @param array|Collection $ids An array or collection of ids
     *
     * @return int Number of destroyed ids
     */
    public function destroy(array|Collection $ids): int
    {
        return $this->model->destroy($ids);
    }

    /**
     * Update a model by given data.
     *
     * @param Model $model    Model to be updated
     * @param array $data     Associative array of data
     * @param array $fillable Fillable columns
     *
     * @return null|Model Returns null if it fails to update the data.
     *                    Otherwise, updated model is returned
     */
    public function update(Model $model, array $data, array $fillable = []): ?Model
    {
        $data['updated_at'] = new Carbon('now');

        $model = $this->fill($model, $data, $fillable);

        return $model->save() ? $model : null;
    }

    /**
     * This method will fill the given model by the given array of data.
     * It will use the fillable values of the model class if the $fillable
     * parameter is not available.
     *
     * @param Model $model    The model entity
     * @param array $data     Array of data
     * @param array $fillable Fillable columns
     *
     * @return Model The model entity
     */
    public function fill(Model $model, array $data, array $fillable = []): Model
    {
        if (empty($fillable)) {
            $fillable = $model->getFillable();
        }

        if (!empty($fillable)) {
            // Just fill it if fillable array is not empty
            $model->fillable($fillable)->fill($data);
        }

        return $model;
    }

    /**
     * Set the relationships that should be eager loaded.
     *
     * @param array|string         $relations
     * @param null|\Closure|string $callback
     */
    public function with($relations, $callback = null): Builder
    {
        if (!empty($relations)) {
            $this->query = $this->query()->with($relations, $callback);
        }

        return $this->query();
    }

    /**
     * Returns a model namespace.
     *
     * @return string The model namespace
     */
    abstract protected function getModelName(): string;

    /**
     * Load model.
     *
     * @return mixed
     *
     * @throws RepositoryException
     */
    protected function loadModel(): Model
    {
        $model = $this->getModelName();

        if (!class_exists($model)) {
            throw new RepositoryException(sprintf('The class %s does not exist.', $model));
        }

        $model = app()->make($model);

        if (!$model instanceof Model) {
            throw new RepositoryException(sprintf('The class %s must be an instance of %s.', get_class($model), Model::class));
        }

        return $model;
    }
}
