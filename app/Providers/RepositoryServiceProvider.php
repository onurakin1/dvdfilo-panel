<?php

namespace App\Providers;

use App\Repositories\Eloquent\ExhibitionUserRepository;
use App\Repositories\Eloquent\Interfaces\ExhibitionUserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\TagRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\FileRepository;
use App\Repositories\Eloquent\MenuRepository;
use App\Repositories\Eloquent\PageRepository;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\BlockRepository;
use App\Repositories\Eloquent\EventRepository;
use App\Repositories\Eloquent\ModuleRepository;
use App\Repositories\Eloquent\SliderRepository;
use App\Repositories\Eloquent\WidgetRepository;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\ContentRepository;
use App\Repositories\Eloquent\CountryRepository;
use App\Repositories\Eloquent\GalleryRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\SettingRepository;
use App\Repositories\Eloquent\AdditionRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\LanguageRepository;
use App\Repositories\Eloquent\LocationRepository;
use App\Repositories\Eloquent\MenuItemRepository;
use App\Repositories\Eloquent\BlockItemRepository;
use App\Repositories\Eloquent\ExhibitionRepository;
use App\Repositories\Eloquent\SliderItemRepository;
use App\Repositories\Eloquent\AdvertisingRepository;
use App\Repositories\Eloquent\GalleryItemRepository;
use App\Repositories\Eloquent\AdditionTypeRepository;
use App\Repositories\Eloquent\LocationTypeRepository;
use App\Repositories\Eloquent\ExhibitionItemRepository;
use App\Repositories\Eloquent\ExhibitionLogRepository;
use App\Repositories\Eloquent\FormRepository;
use App\Repositories\Eloquent\FormItemRepository;
use App\Repositories\Eloquent\FormSizeRepository;
use App\Repositories\Eloquent\FormTypeRepository;
use App\Repositories\Eloquent\LocationFilterRepository;
use App\Repositories\Eloquent\LocationPersonRepository;
use App\Repositories\Eloquent\ProductCategoryRepository;
use App\Repositories\Eloquent\LocationFilterTypeRepository;
use App\Repositories\Eloquent\Interfaces\TagRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\FileRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\MenuRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\PageRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\PostRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\BlockRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\EventRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\ModuleRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\SliderRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\WidgetRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\CommentRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\ContentRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\CountryRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\GalleryRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\ProductRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\SettingRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\AdditionRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\EloquentRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\LocationRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\MenuItemRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\BlockItemRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\ExhibitionRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\SliderItemRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\AdvertisingRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\GalleryItemRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\AdditionTypeRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\LocationTypeRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\ExhibitionItemRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\ExhibitionLogRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\FormRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\FormItemRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\FormSizeRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\FormTypeRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\LocationFilterRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\LocationPersonRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\ProductCategoryRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\LocationFilterTypeRepositoryInterface;
use App\Repositories\Eloquent\Interfaces\LogRepositoryInterface;
use App\Repositories\Eloquent\LogRepository;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()

    {
            $this->app->bind(EloquentRepositoryInterface::class,BaseRepository::class);
            $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
            $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
            $this->app->bind(LogRepositoryInterface::class,LogRepository::class);
            $this->app->bind(FileRepositoryInterface::class,FileRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
