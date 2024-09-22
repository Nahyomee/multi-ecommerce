<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    public function __construct(private $status)
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
            ->addColumn('action', function($query){
                $Btn = '';
                if($this->status != 'delivered'){
                    $Btn .= "<a href='".route('admin.orders.show', ['order' => $query])."' class='btn btn-primary'><i class='fa fa-eye'></i></a>";
                }
                if($this->status != 'pending'){
                $Btn .= "<a href='".route('admin.orders.destroy', ['order' => $query])."' class='btn btn-danger delete-btn ml-2'><i class='fa fa-trash'></i></a>";
                }
                return $Btn;
            })
            ->addColumn('amount', function($query){
                return $query->currency_icon.number_format($query->amount,2);
            })
            ->addColumn('customer', function($query){
                return $query->user->name;
            })
            ->addColumn('date', function($query){
                return date('d-m-Y', strtotime($query->created_at));
            })
            ->addColumn('status', function($query){
                switch ($query->status) {
                    case 'pending':
                        return '<span class="badge bg-warning text-white">Pending</span>';
                        break;
                    case 'processed_and_ready_to_ship':
                        return '<span class="badge bg-info text-white">Processed</span>';
                        break;
                    case 'dropped_off':
                        return '<span class="badge bg-info text-white">Dropped off</span>';
                        break;
                    case 'shipped':
                        return '<span class="badge bg-info text-white">Shipped</span>';
                        break;
                    case 'out_for_delivery':
                        return '<span class="badge bg-primary text-white">Out for Delivery</span>';
                        break;
                    case 'delivered':
                            return '<span class="badge bg-success text-white">Delivered</span>';
                            break;
                    case 'cancelled':
                        return '<span class="badge bg-danger text-white">Cancelled</span>';
                        break;
                    
                    default:
                        # code...
                        break;
                }
                return '<span class="badge bg-warning text-white">'.$query->status.'</span>';
            })
            ->addColumn('payment_status', function($query){
                return '<span class="badge bg-success text-white">'.$query->payment_status.'</span>';
            })
            ->rawColumns(['status', 'action','payment_status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        if($this->status != null){
            return $model->newQuery()->where('status', $this->status)->orderBy('created_at', 'desc');
        }
        return $model->newQuery()->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('order-table')
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
            Column::make('invoice_id'),
            Column::make('customer'),
            Column::make('date'),
            Column::make('amount'),
            Column::make('qty'),
            Column::make('payment_method'),
            Column::make('payment_status'),
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
        return 'Order_' . date('YmdHis');
    }
}
