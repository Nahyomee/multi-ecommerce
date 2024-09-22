<?php

namespace App\DataTables;

use App\Models\ShippingRule;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShippingRuleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function($query){
            $editBtn = "<a href='".route('admin.shipping-rules.edit', ['shipping_rule' => $query])."' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
            $delBtn = "<a href='".route('admin.shipping-rules.destroy', ['shipping_rule' => $query])."' class='btn btn-danger delete-btn ml-2'><i class='fa fa-trash'></i></a>";
            return $editBtn.$delBtn;
        })
        ->addColumn('type', function($query){
            if($query->type == 'flat_fee'){
                return "<i class='badge badge-success'>Flat Fee</i>";

            }
            else return "<i class='badge badge-primary'>Minimum Order Amount</i>";
        })
        ->addColumn('min_cost', function($query){
            if($query->type == 'flat_fee'){
                return 0;

            }
            else return number_format($query->min_cost, 2);
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
        ->rawColumns(['action', 'status', 'type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ShippingRule $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('created_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('shippingrule-table')
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
            ->width(50)
            ->orderable(false),
            Column::make('name'),
            Column::make('type'),
            Column::make('min_cost'),
            Column::make('cost'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(150)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ShippingRule_' . date('YmdHis');
    }
}
