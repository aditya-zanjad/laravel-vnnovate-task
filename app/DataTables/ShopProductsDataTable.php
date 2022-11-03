<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductShop;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ShopProductsDataTable extends DataTable
{
    /**
     * @var int $shopID
     */
    private int $shopID = 0;

    /**
     * Initialize $shopID so that it can used to
     * fetch only those products that belong to the
     * current shop.
     *
     * @param int $shopID
     *
     * @return void
     */
    public function __construct(int $shopID)
    {
        $this->shopID = $shopID;
    }

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     *
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->setTransformer(function ($product) {
                return $this->getTransformedModelData($product);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $query): QueryBuilder
    {
        $columns = [
            'id',       'name',        'slug',
            'color',    'size',        'description',
            'image',    'created_at',   'updated_at'
        ];

        $productsIDs = ProductShop::select(['product_id'])
            ->orderBy('product_id')
            ->where('shop_id', $this->shopID)
            ->get()
            ->map(function ($shopProduct) {
                return $shopProduct->product_id;
            })->toArray();

        return $query->newQuery()->select($columns)
            ->whereIn('id', $productsIDs);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('shop_products_table')
            ->columns($this->getColumns())
            ->columnDefs($this->getColumnDefs())
            ->fixedHeader()
            ->orderCellsTop(true)
            ->pageLength(25)
            ->lengthMenu($this->getLengthMenu())
            ->searchDelay(1024)
            ->responsive(true)
            ->scrollX(true)
            ->initComplete($this->getInitComplete())
            ->dom('Bfrtip')
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->selectStyleSingle()
            ->buttons($this->getCustomButtons());
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make([
                'name'          =>  'id',
                'data'          =>  'id',
                'title'         =>  'ID'
            ]),

            Column::make([
                'name'          =>  'name',
                'data'          =>  'name',
                'title'         =>  'Name'
            ]),

            Column::make([
                'name'          =>  'slug',
                'data'          =>  'slug',
                'title'         =>  'Slug'
            ]),

            Column::make([
                'name'          =>  'color',
                'data'          =>  'color',
                'title'         =>  'Color'
            ]),

            Column::make([
                'name'          =>  'size',
                'data'          =>  'size',
                'title'         =>  'Size',
            ]),

            Column::make([
                'name'          =>  'description',
                'data'          =>  'description',
                'title'         =>  'Description'
            ]),

            Column::make([
                'name'          =>  'image',
                'data'          =>  'image',
                'title'         =>  'Image',
                'searchable'    =>  false,
                'sortable'      =>  false
            ]),

            Column::make([
                'name'          =>  'created_at',
                'data'          =>  'created_at',
                'title'         =>  'Created At'
            ]),

            Column::make([
                'name'          =>  'updated_at',
                'data'          =>  'updated_at',
                'title'         =>  'Updated At'
            ])
        ];
    }

    /**
     * Get initComplete for the datatable.
     *
     * @return string
     */
    private function getInitComplete(): string
    {
        $colors =   Product::pluck('color')->unique();
        $sizes  =   Product::pluck('size')->unique();

        return "
            function() {
                var api = this.api();

                // For each column
                api.columns().eq(0).each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                    var title = $(cell).text();

                    var inputShouldBeDisabled = colIdx == 6;

                    if (inputShouldBeDisabled) {
                        $(cell).html(
                            '<input class=\"form-control\" type=\"text\" placeholder=\"' + title + '\" disabled />'
                        );
                        return;
                    }

                    var useSelectMenuForInput = colIdx == 3 || colIdx == 4
                        || colIdx == 7 || colIdx == 8;

                    // For 'input type' text filter
                    if (!useSelectMenuForInput) {
                        $(cell).html('<input class=\"form-control\" type=\"text\" placeholder=\"' + title + '\">');

                        // On every keypress in this input
                        $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                            .off('keyup change')
                            .on('keyup change', function(e) {
                                e.stopPropagation();

                                // Get the search value
                                $(this).attr('title', $(this).val());

                                var regexp          =   '({search})'; //$(this).parents('th').find('select').val();
                                var cursorPosition  =   this.selectionStart;

                                // Search the column for that value
                                api.column(colIdx)
                                    .search((this.value != \"\") ? regexp.replace('{search}',
                                            '(((' + this.value + ')))') : \"\", this.value !=
                                        \"\", this.value == \"\")
                                    .draw();

                                $(this).focus()[0].setSelectionRange(cursorPosition,
                                    cursorPosition);
                            });

                        return;
                    }

                    // For columns that have 'select' element as a filter input
                    var currentColumnIndex  =   api.column(colIdx).index();
                    var select              =   $('<select class=\"form-control\"></select>');
                    var options             =   '<option value=\"\" selected>All</option>';
                    var data                =   {};

                    // According the the selected
                    switch (parseInt(colIdx)) {
                        case 3:
                            data = " . json_encode($colors) . ";
                            break;

                        case 4:
                            data = " . json_encode($sizes) . ";
                            break;

                        case 7:
                        case 8:
                            data = api.column(colIdx).data().unique().sort();
                            break;
                    }

                    $.each(data, function (key, value) {
                        options += '<option value=\"' + value + '\">' + value + '</option>'
                    });

                    $(cell).html(select.append(options));

                    // On select change input event
                    $('select', $('.filters th').eq($(api.column(colIdx).header()).index()))
                        .off('change')
                        .on('change', function(e) {
                            e.stopPropagation();

                            // Get the search value
                            $(this).attr('title', $(this).val());

                            var regexp          =   '({search})'; //$(this).parents('th').find('select').val();
                            var cursorPosition  =   this.selectionStart;

                            // Search the column for that value
                            api.column(colIdx).search(
                                (this.value != \"\")
                                    ? regexp.replace('{search}', '(((' + this.value + ')))')
                                    : \"\", this.value != \"\",
                                    this.value == \"\"
                            ).draw();
                    });
                });
            }
        ";
    }

    /**
     * Get column definitions for the datatable.
     *
     * @return array
     */
    private function getColumnDefs(): array
    {
        return [
            ['targets' =>   0,          'width' =>  75],
            ['targets' =>   [1, 3, 7],  'width' =>  150],
            ['targets' =>   [4, 5, 6],  'width' =>  200],

            [
                'targets'   =>  [0, 1, 2, 3, 4, 5, 6, 7],
                'class'     =>  'text-center'
            ],
        ];
    }

    /**
     * Get length menu for the datatable.
     *
     * @return array
     */
    private function getLengthMenu(): array
    {
        return [
            [
                10, 15, 20, 25, 30, 35, 40, 45,
                50, 55, 60, 65, 70, 75, 80, 85,
                90, 95, 100
            ],
            [
                '10 Rows', '15 Rows', '20 Rows', '25 Rows', '30 Rows', '35 Rows',
                '40 Rows', '45 Rows', '50 Rows', '55 Rows', '60 Rows', '65 Rows',
                '70 Rows', '75 Rows', '80 Rows', '85 Rows', '90 Rows', '95 Rows',
                '100 Rows'
            ]
        ];
    }

    /**
     * Get custom buttons for the datatable.
     *
     * @return array
     */
    private function getCustomButtons(): array
    {
        return  [
            Button::make([
                'extend'    => 'pageLength',
                'className' => 'btn mb-2'
            ]),

            Button::make([
                'extend'    =>  'excel',
                'text'      =>  'Export To Excel',
                'className' =>  'btn mb-2'
            ]),

            Button::make([
                'extend'    =>  'csv',
                'text'      =>  'Export To CSV',
                'className' =>  'btn mb-2'
            ]),
        ];
    }

    /**
     * Transform the provided model data before sending it in the response.
     *
     * @param \App\Models\Product $product
     *
     * @return array
     */
    private function getTransformedModelData(Product $product): array
    {
        return [
            'id'            =>  $product->id,
            'name'          =>  $product->name,
            'slug'          =>  $product->slug,
            'color'         =>  $product->color,
            'size'          =>  $product->size,
            'description'   =>  Str::limit($product->description, 75, '...'),
            'created_at'    =>  Carbon::parse($product->created_at)->toDateTimeString(),
            'updated_at'    =>  Carbon::parse($product->updated_at)->toDateTimeString(),

            'image'         =>  "
                <img src=\"$product->image\" alt=\"$product->name\"
                    height=\"100\" width=\"100\">
            ",
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Products_' . now()->format('Y-m-d');
    }
}
