<?php

namespace App\DataTables;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SliderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('slider', function($query){
                return $img = "<img width = '100px' src = '".asset('sliders/'.$query->slider)."'></img>";
            })
            ->addColumn('action', function($query){
                $editBtn = "<a href='".route('admin.sliders.edit', ['slider' => $query->id])."' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                $delBtn = "<a href='".route('admin.sliders.destroy', ['slider' => $query->id])."' class='btn btn-danger delete-btn ml-2'><i class='fa fa-trash'></i></a>";
                return $editBtn.$delBtn;
            })
            ->addColumn('status', function($query){
                $active = "<i class='badge badge-success'>Active</i>";
                $inactive = "<i class='badge badge-danger'>Inactive</i>";
                return $query->status == 1 ? $active : $inactive ;
            })
            ->rawColumns(['slider', 'action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Slider $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('created_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('slider-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
                ->orderable(false),
            Column::make('type'),
            Column::make('title'),
            Column::make('slider')->width(150),
            Column::make('serial'),
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
        return 'Slider_' . date('YmdHis');
    }
}
