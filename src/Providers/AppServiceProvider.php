<?php

namespace iAmBiB\CollectionExtender\Providers;

use iAmBiB\CollectionExtender\Exceptions\CollectionExtenderException;
use iAmBiB\CollectionExtender\Helpers\Cast;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../../config/collection-extender.php';
        $this->mergeConfigFrom($configPath, 'collection-extender');
        $this->registerMacros();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../../config/collection-extender.php';
        $this->publishes(
            [$configPath => $this->getConfigPath()],
            'collection-extender'
        );
    }

    /**
     * Get the config path.
     *
     * @return string
     */
    protected function getConfigPath(): string
    {
        return config_path('collection-extender.php');
    }

    protected function registerMacros(): void
    {
        //## RECURSIVE ###
        Collection::macro('recursive', function ()
        {
            return $this->map(function ($value, $key)
            {
                if (\is_array($value) || \is_object($value))
                {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });

        //## PUSH TO KEY ###
        Collection::macro('pushToKey', function (mixed $key, mixed $value, bool $recursive = false)
        {
            if (!$this->get($key, null) !== null)
            {
                $value = $recursive ? collect([$value])->recursive() : [$value];

                return $this->put($key, $value);
            }
            $value = !\is_array($value) ? [$value] : $value;
            $cur_value = !\is_array($this->get($key)) ? [$this->get($key)] : $this->get($key);
            $mergedValue = array_merge($cur_value, $value);
            $mergedValue = $recursive ?? collect($mergedValue)->recursive();

            return $this->put($key, $mergedValue);
        });

        //## TO MODEL ###
        Collection::macro('toModel', function (string $model_class = null)
        {
            if (!$model_class)
            {
                if (!$model_class)
                {
                    $model_class = $this->get(config('collection-extender.model_class_key'));
                }
            }
            if (!$model_class)
            {
                throw(new CollectionExtenderException('Model class not defined'));
            }
            $newModel = new $model_class;
            unset($this[config('collection-extender.model_class_key')]);
            $newModel->forceFill($this->toArray());

            return $newModel;
        });

        //## INPUT ###

        Collection::macro('input', function (string $keys, $default = null)
        {
            $arr = collect($this)->toArray();

            return data_get($arr, $keys, $default);
        });

        //## INPUT ###

        Collection::macro('morphTo', function (string $object_class)
        {
            $arr = $this->toArray();
            $object = Cast::castArray($arr, ['attributes' => $object_class]);

            return $object;
        });
    }
}
