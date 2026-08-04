<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(Request $request, string $type): View
    {
        $config = $this->config($type);
        $model = $config['model'];
        $items = $model::query()->orderBy($config['order'][0], $config['order'][1])->get();
        $editing = $request->filled('edit') ? $model::findOrFail($request->integer('edit')) : null;

        return view('admin.content.index', compact('type', 'config', 'items', 'editing'));
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $config = $this->config($type);
        $config['model']::create($this->validated($request, $type));

        return redirect()->route('admin.content.index', $type)
            ->with('success', $config['singular'].' was added successfully.');
    }

    public function update(Request $request, string $type, int $id): RedirectResponse
    {
        $config = $this->config($type);
        $item = $config['model']::findOrFail($id);
        $item->update($this->validated($request, $type, $item));

        return redirect()->route('admin.content.index', $type)
            ->with('success', $config['singular'].' was updated successfully.');
    }

    public function destroy(string $type, int $id): RedirectResponse
    {
        $config = $this->config($type);
        $config['model']::findOrFail($id)->delete();

        return redirect()->route('admin.content.index', $type)
            ->with('success', $config['singular'].' was deleted successfully.');
    }

    private function validated(Request $request, string $type, ?Model $item = null): array
    {
        $data = match ($type) {
            'projects' => $request->validate([
                'title' => ['required', 'string', 'max:150'],
                'slug' => [
                    'required', 'string', 'max:180',
                    Rule::unique('projects', 'slug')->ignore($item?->id),
                ],
                'description' => ['nullable', 'string', 'max:5000'],
                'image' => ['nullable', 'string', 'max:2048'],
                'technology' => ['nullable', 'string', 'max:1000'],
                'github_url' => ['nullable', 'url', 'max:2048'],
                'demo_url' => ['nullable', 'url', 'max:2048'],
                'status' => ['required', 'in:draft,published'],
                'featured' => ['nullable', 'boolean'],
                'sort_order' => ['required', 'integer', 'min:0'],
            ]),
            'skills' => $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'category' => ['nullable', 'string', 'max:100'],
                'icon' => ['nullable', 'string', 'max:255'],
                'percentage' => ['required', 'integer', 'between:0,100'],
                'sort_order' => ['required', 'integer', 'min:0'],
            ]),
            'educations' => $request->validate([
                'school_name' => ['required', 'string', 'max:150'],
                'level' => ['nullable', Rule::in(['primary', 'secondary', 'highschool', 'university'])],
                'degree' => ['nullable', 'string', 'max:150'],
                'field' => ['nullable', 'string', 'max:150'],
                'start_year' => ['nullable', 'integer', 'between:1900,2100'],
                'end_year' => ['nullable', 'integer', 'between:1900,2100', 'gte:start_year'],
                'description' => ['nullable', 'string', 'max:3000'],
            ]),
            'experiences' => $request->validate([
                'company_name' => ['required', 'string', 'max:150'],
                'position' => ['required', 'string', 'max:150'],
                'start_date' => ['nullable', 'date'],
                'end_date' => ['nullable', 'date', 'after_or_equal:start_date', Rule::requiredIf(! $request->boolean('currently_working'))],
                'currently_working' => ['nullable', 'boolean'],
                'description' => ['nullable', 'string', 'max:3000'],
            ]),
            'services' => $request->validate([
                'name' => ['required', 'string', 'max:120'],
                'description' => ['nullable', 'string', 'max:3000'],
                'icon' => ['nullable', 'string', 'max:255'],
                'sort_order' => ['required', 'integer', 'min:0'],
                'active' => ['nullable', 'boolean'],
            ]),
            default => abort(404),
        };

        if ($type === 'experiences') {
            $data['currently_working'] = $request->boolean('currently_working');
            if ($data['currently_working']) {
                $data['end_date'] = null;
            }
        }

        if ($type === 'services') {
            $data['active'] = $request->boolean('active');
        }

        if ($type === 'projects') {
            $data['featured'] = $request->boolean('featured');
        }

        return $data;
    }

    private function config(string $type): array
    {
        return match ($type) {
            'projects' => [
                'title' => 'Projects', 'singular' => 'Project', 'model' => Project::class,
                'order' => ['sort_order', 'asc'],
                'fields' => [
                    ['name' => 'title', 'label' => 'Project title', 'required' => true],
                    ['name' => 'slug', 'label' => 'Slug', 'required' => true],
                    ['name' => 'technology', 'label' => 'Technologies'],
                    ['name' => 'image', 'label' => 'Image path / URL'],
                    ['name' => 'github_url', 'label' => 'GitHub URL', 'type' => 'url'],
                    ['name' => 'demo_url', 'label' => 'Demo URL', 'type' => 'url'],
                    ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => true, 'options' => ['published' => 'Published', 'draft' => 'Draft']],
                    ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'min' => 0, 'required' => true],
                    ['name' => 'featured', 'label' => 'Featured project', 'type' => 'checkbox', 'wide' => true],
                    ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'wide' => true],
                ],
                'columns' => ['title' => 'Project', 'technology' => 'Technologies', 'status' => 'Status', 'featured' => 'Featured'],
            ],
            'skills' => [
                'title' => 'Skills', 'singular' => 'Skill', 'model' => Skill::class,
                'order' => ['sort_order', 'asc'],
                'fields' => [
                    ['name' => 'name', 'label' => 'Skill name', 'required' => true],
                    ['name' => 'category', 'label' => 'Category'],
                    ['name' => 'icon', 'label' => 'Icon / image URL'],
                    ['name' => 'percentage', 'label' => 'Percentage', 'type' => 'number', 'min' => 0, 'max' => 100, 'required' => true],
                    ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'min' => 0, 'required' => true],
                ],
                'columns' => ['name' => 'Name', 'category' => 'Category', 'percentage' => 'Level', 'sort_order' => 'Order'],
            ],
            'educations' => [
                'title' => 'Education', 'singular' => 'Education', 'model' => Education::class,
                'order' => ['start_year', 'desc'],
                'fields' => [
                    ['name' => 'school_name', 'label' => 'School / University', 'required' => true],
                    ['name' => 'level', 'label' => 'Education level', 'type' => 'select', 'required' => true, 'options' => [
                        'primary' => 'Primary School',
                        'secondary' => 'Secondary School',
                        'highschool' => 'High School',
                        'university' => 'University',
                    ]],
                    ['name' => 'degree', 'label' => 'Degree'],
                    ['name' => 'field', 'label' => 'Field of study'],
                    ['name' => 'start_year', 'label' => 'Start year', 'type' => 'number', 'min' => 1900, 'max' => 2100],
                    ['name' => 'end_year', 'label' => 'End year', 'type' => 'number', 'min' => 1900, 'max' => 2100],
                    ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'wide' => true],
                ],
                'columns' => ['school_name' => 'School', 'level' => 'Level', 'degree' => 'Degree', 'start_year' => 'Period'],
            ],
            'experiences' => [
                'title' => 'Experience', 'singular' => 'Experience', 'model' => Experience::class,
                'order' => ['start_date', 'desc'],
                'fields' => [
                    ['name' => 'company_name', 'label' => 'Company', 'required' => true],
                    ['name' => 'position', 'label' => 'Position', 'required' => true],
                    ['name' => 'start_date', 'label' => 'Start date', 'type' => 'date'],
                    ['name' => 'end_date', 'label' => 'End date', 'type' => 'date'],
                    ['name' => 'currently_working', 'label' => 'Currently working here', 'type' => 'checkbox', 'wide' => true],
                    ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'wide' => true],
                ],
                'columns' => ['company_name' => 'Company', 'position' => 'Position', 'start_date' => 'Period', 'currently_working' => 'Status'],
            ],
            'services' => [
                'title' => 'Services', 'singular' => 'Service', 'model' => Service::class,
                'order' => ['sort_order', 'asc'],
                'fields' => [
                    ['name' => 'name', 'label' => 'Service name', 'required' => true],
                    ['name' => 'icon', 'label' => 'Icon / image URL'],
                    ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'min' => 0, 'required' => true],
                    ['name' => 'active', 'label' => 'Show this service publicly', 'type' => 'checkbox', 'wide' => true, 'default' => true],
                    ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'wide' => true],
                ],
                'columns' => ['name' => 'Service', 'description' => 'Description', 'sort_order' => 'Order', 'active' => 'Status'],
            ],
            default => abort(404),
        };
    }
}
