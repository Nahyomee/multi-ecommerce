<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('thumbnail', function($query){
            return "<img width = '70px' src = '".asset('product/'.$query->thumb_img    )."'></img>";
        })
        ->addColumn('action', function($query){
            $editBtn = "<a href='".route('admin.products.edit', ['product' => $query])."' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i></a>";
            $delBtn = "<a href='".route('admin.products.destroy', ['product' => $query])."' class='btn btn-sm btn-danger delete-btn ml-2'><i class='fa fa-trash'></i></a>";
            $moreBtn = ' <div class="dropdown dropleft ml-2 d-inline">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-cog"></i>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item has-icon" href="'.route('admin.products.images.index', ['product' => $query]).'"><i class="far fa-images"></i> Image Gallery</a>
              <a class="dropdown-item has-icon" href="'.route('admin.products.variants.index', ['product' => $query]).'"><i class="fas fa-tags"></i> Variants</a>
           </div>
          </div>';
            return $editBtn.$delBtn.$moreBtn;
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
        ->addColumn('type', function($query){
            switch ($query->product_type) {
                case 'new arrival':
                    return "<i class='badge badge-danger'>New Arrival</i>";
                    break;
                case 'featured product':
                    return "<i class='badge badge-warning'>Featured Product</i>";
                    break;
                case 'top product':
                    return "<i class='badge badge-success'>Top Product</i>";
                    break;
                case 'best product':
                    return "<i class='badge badge-info'>Best Product</i>";
                    break;
                default:
                    return "<i class='badge badge-dark'>None</i>";
                    break;
            }
        })
        ->addColumn('brand', function($query){
            return $query->brand->name;
        })
        ->addColumn('vendor', function($query){
            return $query->vendor->user->name;
        })
        ->addColumn('category', function($query){
            return $query->category->name;
        })
        ->addColumn('subcategory', function($query){
            return $query->subcategory?->name;
        })
        ->addColumn('child_category', function($query){
            return $query->childcategory?->name;
        })
        ->rawColumns(['action', 'thumbnail', 'status', 'type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()->where('vendor_id', auth()->user()->vendor->id)->orderBy('created_at');

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
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
            Column::make('thumbnail'),
            Column::make('category'),
            Column::make('type')->width(100),
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
        return 'Product_' . date('YmdHis');
    }
}
