<?php

namespace App\DataTables;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BrandDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('logo', function($query){
            return $img = "<img width = '100px' src = '".asset('brands/'.$query->logo)."'></img>";
        })
        ->addColumn('action', function($query){
            $editBtn = "<a href='".route('admin.brands.edit', ['brand' => $query])."' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
            $delBtn = "<a href='".route('admin.brands.destroy', ['brand' => $query])."' class='btn btn-danger delete-btn ml-2'><i class='fa fa-trash'></i></a>";
            return $editBtn.$delBtn;
        })
        ->addColumn('status', function($query){
            if($query->status == 1){
                $button = '<label class="custom-switch mt-2">
                <input type="checkbox" name="custom-switch-checkbox" checked data-id="'.$query->id.'" class="custom-switch-input change-status">
                <span class="custom-switch-indicator"></span>
               </label>';
            }
            else{
                $button = '<label class="custom-switch mt-2">
                <input type="checkbox" name="custom-switch-checkbox" data-id="'.$query->id.'" class="custom-switch-input change-status">
                <span class="custom-switch-indicator"></span>
               </label>';
            }
            return $button ;
        })
        ->addColumn('is_featured', function($query){
            $yes = "<i class='badge badge-success'>Yes</i>";
            $no = "<i class='badge badge-danger'>No</i>";
            return $query->is_featured == 1 ? $yes : $no ;
        })
        ->rawColumns(['logo', 'action', 'is_featured', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Brand $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('brand-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('S/N')
                ->title('#')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(50)
                ->orderable(false),
            Column::make('logo'),
            Column::make('name'),
            Column::make('is_featured'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(200)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Brand_' . date('YmdHis');
    }
}
