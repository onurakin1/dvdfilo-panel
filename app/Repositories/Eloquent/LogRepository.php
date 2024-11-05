<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Eloquent\Interfaces\LogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LogRepository extends BaseRepository implements LogRepositoryInterface
{

    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }



    public function paginate(?object $filters = null, ?string $sortField = null, bool $sortAsc = true, int $pageSize = 20): LengthAwarePaginator
    {

        return $this->model::query()
            ->with(['causer'])
            ->when(($filters->search), function ($q, $s) {
                $q->orWhere('log_name', 'like', '%' . $s . '%');
                $q->orWhere('description', 'like', '%' . $s . '%');
                $q->orWhere('subject_type', 'like', '%' . $s . '%');
                $q->orWhere('event', 'like', '%' . $s . '%');
                $q->orWhere('subject_id', 'like', '%' . $s . '%');
                $q->orWhere('properties', 'like', '%' . $s . '%');
                $q->orWhere('created_at', 'like', '%' . $s . '%');
            })

            ->orderBy('id','desc')
            ->paginate($filters->limit ?? $pageSize);
    }

}
