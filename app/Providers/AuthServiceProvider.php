<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\File;
use App\Models\LocationPerson;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Tag;
use App\Policies\CategoryPolicy;
use App\Policies\FilePolicy;
use App\Policies\LocationPersonPolicy;
use App\Policies\MenuItemPolicy;
use App\Policies\PagePolicy;
use App\Policies\ProductCategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\TagPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
