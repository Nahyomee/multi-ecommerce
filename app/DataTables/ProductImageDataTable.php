<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductImageDataTable extends DataTable
{
    public function __construct(private Product $product)
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
            ->addColumn('image', function($query){
                return "<img width = '100px' src = '".asset('product/'.$query->image)."'></img>";
            })
            ->addColumn('action', function ($query) {
                return "<a href='".route('admin.products.images.destroy', ['product' => $query->product, 'image' => $query])."' class='btn btn-sm btn-danger delete-btn ml-2'><i class='fa fa-trash'></i></a>";
                
            })
            ->rawColumns(['action', 'image']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductImage $model): QueryBuilder
    {
        return $model->newQuery()->where('product_id', $this->product->id)->orderBy('created_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productimage-table')
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
            Column::make('image'),
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
        return 'ProductImage_' . date('YmdHis');
    }
}
