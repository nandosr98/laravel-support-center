<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Tags;

use Exception;
use Illuminate\Support\Facades\Log;
use LaravelSupportCenter\Models\BaseSupportAgent;
use LaravelSupportCenter\Models\BaseSupportCategory;
use LaravelSupportCenter\Models\BaseSupportTag;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $tagModal = false;

    public bool $editTagModal = false;

    public bool $confirmDeleteModal = false;

    public $tagToDelete;

    public array $editTagForm = [
        'id' => '',
        'name' => '',
        'color' => ''
    ];

    public array $tagForm = [
        'name' => '',
        'color' => '',
    ];

    public function createCategory(): void
    {
        try{
            BaseSupportTag::create($this->tagForm);
        } catch (Exception $e) {
            Log::error('[LaravelSupportCenter::CreateTag] Could not create tag', [
                'tag' => $this->tagForm,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
            toast()->danger('Error al crear la etiqueta')->push();
            return;
        }

        $this->tagModal = false;
        toast()->success('Etiqueta creada')->push();
    }

    public function showEditTag($id): void
    {
        $tag = BaseSupportTag::find($id);

        $this->editTagForm = [
            'id' => $id,
            'name' => $tag->name,
            'color' => $tag->color
        ];
        $this->editTagModal = true;
    }

    public function editTag(): void
    {
        try{
            BaseSupportTag::find($this->editTagForm['id'])->update($this->editTagForm);
        } catch (Exception $e) {
            Log::error('[LaravelSupportCenter::EditTag] Could not edit tag', [
                'tag' => $this->editTagForm,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
            toast()->danger('Error al editar la etiqueta')->push();
            return;
        }

        $this->editTagModal = false;
        toast()->success('Etiqueta editada')->push();
    }

    public function deleteTag($id): void
    {
        $this->tagToDelete = $id;
        $this->confirmDeleteModal = true;

    }

    public function confirmDeleteTag($id): void
    {
        try{
            BaseSupportTag::find($id)->delete();
        } catch (Exception $e) {
            Log::error('[LaravelSupportCenter::DeleteTag] Could not delete tag', [
                'tag' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
            toast()->danger('Error al eliminar la etiqueta')->push();
            return;
        }

        $this->confirmDeleteModal = true;
        toast()->success('Etiqueta eliminada')->push();
    }

    public function render()
    {
        $tags = BaseSupportTag::query()->latest('created_at')->paginate(15);

        return view('laravel-support-center::livewire.tags.index', [
            'tags' => $tags,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
