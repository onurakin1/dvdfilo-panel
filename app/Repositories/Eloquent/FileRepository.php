<?php

namespace App\Repositories\Eloquent;

use App\Models\File;
use App\Repositories\Eloquent\Interfaces\FileRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    public function __construct(File $model)
    {
        parent::__construct($model);
    }

    public function paginate(?object $filters = null, ?string $sortField = null, bool $sortAsc = true, int $pageSize = 20): LengthAwarePaginator
    {
        return $this->model::query()
            ->when(($filters->search), function ($q, $s) {
                $q
                    ->orWhere('title', 'like', '%' . $s . '%')
                    ->orWhere('description', 'like', '%' . $s . '%')
                    ->orWhere('slug', 'like', '%' . $s . '%');
            })
            ->with(['author'])
            ->orderBy('id','desc')
            ->paginate($filters->limit ?? $pageSize);
    }
}
