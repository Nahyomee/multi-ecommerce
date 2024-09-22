<?php

namespace App\DataTables\Vendor;

use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductVariantItemDataTable extends DataTable
{
    public function __construct(private ProductVariant $variant)
    {
        
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function ($query){
            $editBtn = "<a href='".route('vendor.variants.items.edit', ['item' => $query, 'variant' => $query->variant])."' class='btn btn-sm btn-primary ml-2'><i class='fa fa-edit'></i></a>";
            $delBtn = "<a href='".route('vendor.variants.items.destroy', ['item' => $query, 'variant' => $query->variant])."' class='btn btn-sm btn-danger delete-btn ml-2'><i class='fa fa-trash'></i></a>";
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
        ->addColumn('is_default', function($query){
            $yes = "<i class='badge badge-success'>Yes</i>";
            $no = "<i class='badge badge-danger'>No</i>";
            return $query->is_default == 1 ? $yes : $no ;
        })   
        ->rawColumns(['action', 'status', 'is_default']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model->newQuery()->where('product_variant_id', $this->variant->id)->orderBy('created_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productvariantitem-table')
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
            Column::make('price'),
            Column::make('status'),
            Column::make('is_default'),
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
        return 'ProductVariantItem_' . date('YmdHis');
    }
}
