<?php

namespace App\Http\Requests\Dashboard;

use App\Repositories\Eloquent\Interfaces\PostRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class DashboardDraftStoreRequest extends FormRequest
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create', $this->postRepository->getModelClass());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required",
            "description" => 'nullable'
        ];
    }
}
