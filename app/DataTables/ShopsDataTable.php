<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Shop;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

/**
 * This class contains methods for building datatable for Shop model
 *
 * @author  Aditya Zanjad <adityazanjad474@gmail.com>
 * @version 1.0
 * @access  public
 */
class ShopsDataTable extends DataTable
{
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
            ->setTransformer(function ($shop) {
                return $this->getTransformedModelData($shop);
            })->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Shop $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shop $model): QueryBuilder
    {
        return $model->newQuery()
            ->select([
                'id',
                'name',
                'address',
                'city_id',
                'created_at',
                'updated_at'
            ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('shops_table')
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
                'data'          =>  'action',
                'title'         =>  'View Products',
                'searchable'    =>  false,
                'sortable'      =>  false
            ]),

            Column::make([
                'name'          =>  'id',
                'data'          =>  'id',
                'title'         =>  'ID',
            ]),

            Column::make([
                'name'          =>  'name',
                'data'          =>  'name',
                'title'         =>  'Name',
            ]),

            Column::make([
                'name'          =>  'address',
                'data'          =>  'address',
                'title'         =>  'Address',
            ]),

            Column::make([
                'name'          => 'city_id',
                'data'          => 'city_id',
                'title'         => 'City'
            ]),

            Column::make([
                'name'          =>  'created_at',
                'data'          =>  'created_at',
                'title'         =>  'Created At',
            ]),

            Column::make([
                'name'          =>  'updated_at',
                'data'          =>  'updated_at',
                'title'         =>  'Updated At',
            ])
        ];
    }

    /**
     * Get initComplete function for the datatable
     *
     * @return string
     */
    private function getInitComplete(): string
    {
        $cities = collect(City::select(['id', 'name', 'state_id'])
            ->get()
            ->map(function ($city) {
                $city->{'state_name'}   =   $city->state->name;
                $city->{'country_name'} =   $city->state->country->name;
                return $city;
            })->sortBy('id'))
            ->mapWithKeys(function ($city) {
                return [
                    $city->id => $city->name
                        . ', ' . $city->state_name
                        . ', ' . $city->country_name
                ];
            });

        return "
            function() {
                var api = this.api();

                // For each column
                api.columns().eq(0).each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                    var title = $(cell).text();

                    var inputShouldBeDisabled = colIdx == 0;

                    if (inputShouldBeDisabled) {
                        $(cell).html(
                            '<input class=\"form-control\" type=\"text\" placeholder=\"' + title + '\" disabled />'
                        );
                        return;
                    }

                    var useSelectMenuForInput = colIdx == 4 || colIdx == 5
                        || colIdx == 6;

                    // For 'input type' text filter
                    if (!useSelectMenuForInput) {
                        $(cell).html('<input class=\"form-control\" type=\"text\" placeholder=\"' + title + '\" />');

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
                        case 5:
                        case 6:
                            data = api.column(colIdx).data().unique().sort();
                            $.each(data, function (key, value) {
                                options += '<option value=\"' + value + '\">' + value + '</option>'
                            });
                            break;

                        case 4:
                            data = " . json_encode($cities) .  ";
                            $.each(data, function (key, value) {
                                options += '<option value=\"' + key + '\">' + value + '</option>'
                            });
                            break;
                    }

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
     * Get column definitions for the datatable
     *
     * @return array
     */
    private function getColumnDefs(): array
    {
        return [
            [
                'targets'   =>    [0, 1, 2, 3, 4, 5],
                'class'     =>  'text-center'
            ],

            [
                'targets'   =>   4,
                'width'     =>  250,
                'render'    =>  "
                    function (data, type, row, meta) {
                        return row.city_name;
                    }
                "
            ],

            [
                'targets'   =>   0,
                'width'     =>  75,
                'render'    =>  "
                    function (data, type, row, meta) {
                        return '<a href=\"' + row.action + '\"><i class=\"fas fa-eye mr-2\"></i> View Products</a>'
                    }
                "
            ],

            ['targets' =>   [1, 5, 6],      'width' =>  100],
            ['targets' =>   1,              'width' =>  250],
            ['targets' =>   [3, 4],         'width' =>  200],
        ];
    }

    /**
     * Get lengthMenu for the datatable.
     *
     * @return array<array, array>
     */
    private function getLengthMenu()
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
     * Get custom buttons for the datatable
     *
     * @return array
     */
    private function getCustomButtons()
    {
        return [
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
     * Transform models data before sending it into the json response
     *
     * @param \App\Models\Shop $shop
     *
     * @return array
     */
    private function getTransformedModelData(Shop $shop): array
    {
        return [
            'id'            =>  $shop->id,
            'name'          =>  $shop->name,
            'address'       =>  Str::limit($shop->address, 75, '...'),
            'city_id'       =>  $shop->city_id,
            'city_name'     =>  $shop->city->name,
            'created_at'    =>  Carbon::parse($shop->created_at)->toDateTimeString(),
            'updated_at'    =>  Carbon::parse($shop->updated_at)->toDateTimeString(),
            'action'        =>  route('shops.products.index', $shop->id)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Shops_' . Carbon::now()->format('Y-m-d');
    }
}
