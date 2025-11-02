<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Categories;

use Exception;
use Illuminate\Support\Facades\Log;
use LaravelSupportCenter\Models\BaseSupportCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class Index extends Component
{
    use WireToast, WithPagination;

    public bool $categoryModal = false;

    public bool $editCategoryModal = false;

    public array $editCategoryForm = [
        'id' => '',
        'name' => '',
        'description' => '',
        'priority' => '',
    ];

    public array $categoryPriorities = [
        ['key' => 'low', 'label' => 'Baja'],
        ['key' => 'medium', 'label' => 'Media'],
        ['key' => 'high', 'label' => 'Alta'],
        ['key' => 'urgent', 'label' => 'Urgente'],
    ];

    public array $categoryForm = [
        'name' => '',
        'description' => '',
        'priority' => 'medium',
    ];

    public function createCategory()
    {
        try{
            BaseSupportCategory::create($this->categoryForm);
        } catch (Exception $e) {
            Log::error('[LaravelSupportCenter::CreateCategory] Could not create category', [
                'category' => $this->categoryForm,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
            toast()->danger('Error al crear la categoría')->push();
            return;
        }

        $this->categoryModal = false;
        toast()->success('Categoría creada')->push();
    }

    public function showEditCategory($id)
    {
        $category = BaseSupportCategory::find($id);

        $this->editCategoryForm = [
            'id' => $id,
            'name' => $category->name,
            'description' => $category->description,
            'priority' => $category->priority,
        ];
        $this->editCategoryModal = true;
    }

    public function editCategory()
    {
        try{
            BaseSupportCategory::find($this->editCategoryForm['id'])->update($this->editCategoryForm);
        } catch (Exception $e) {
            dd($e);
            Log::error('[LaravelSupportCenter::EditCategory] Could not edit category', [
                'category' => $this->editCategoryForm,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
            toast()->danger('Error al editar la categoría')->push();
            return;
        }

        $this->editCategoryModal = false;
        toast()->success('Categoría editada')->push();
    }


    public function render()
    {
        $perPage = 15;

        $categories = BaseSupportCategory::query()
            ->withCount('tickets')
            ->latest('created_at')
            ->paginate($perPage);

        return view('laravel-support-center::livewire.categories.index', [
            'categories' => $categories,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
