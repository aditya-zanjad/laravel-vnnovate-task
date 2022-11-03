<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

/**
 * This class contains methods for building datatable of users list.
 *
 * @author  Aditya Zanjad <adityazanjad474@gmail.com>
 * @version 1.0
 * @access  public
 */
class UsersDataTable extends DataTable
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
            ->setRowId('id')
            ->setTransformer(function ($user) {
                return $this->getTransformedModelData($user);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()
            ->select([
                'id',
                'name',
                'email',
                'gender',
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
            ->setTableId('users_table')
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
     * @return array<int, static>
     */
    public function getColumns(): array
    {
        return [
            Column::make([
                'name'          =>  'id',
                'data'          =>  'id',
                'title'         =>  'User ID',
                'searchable'    =>  true
            ]),

            Column::make([
                'name'          =>  'name',
                'data'          =>  'name',
                'title'         =>  'Name',
            ]),

            Column::make([
                'name'          =>  'email',
                'data'          =>  'email',
                'title'         =>  'E-Mail',
            ]),


            Column::make([
                'name'          =>  'gender',
                'data'          =>  'gender',
                'title'         =>  'Gender',
            ]),

            Column::make([
                'name'          =>  'city_id',
                'data'          =>  'city_id',
                'title'         =>  'City',
            ]),

            Column::make([
                'name'          =>  'created_at',
                'data'          =>  'created_at',
                'title'         =>  'Created At',
            ]),

            Column::make([
                'name'          =>  'created_at',
                'data'          =>  'updated_at',
                'title'         =>  'Last Updated'
            ]),
        ];
    }

    /**
     * Get text for the 'initComplete' function of the database.
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

        $genders = [
            'm' =>  'Male',
            'f' =>  'Female',
            'o' =>  'Other'
        ];

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

                    var useSelectMenuForInput = colIdx == 3 || colIdx == 4
                        || colIdx == 5 || colIdx == 6;

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

                        case 3:
                            data = " . json_encode($genders) . ";
                            $.each(data, function (key, value) {
                                options += '<option value=\"' + key + '\">' + value + '</option>'
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
     * Get column definitions for the datatable.
     *
     * @return array<int, array<string, array|int|string>>
     */
    private function getColumnDefs()
    {
        return [
            [
                'targets'   =>  [0, 1, 2, 3, 4, 5, 6],
                'class'     =>  'text-center'
            ],

            ['targets' =>   0,  'width' =>  75],
            ['targets' =>   1,  'width' =>  200],
            ['targets' =>   4,  'width' =>  200],

            [
                'targets'   =>  [0, 1, 2, 3, 4, 6],
                'width'     =>  150
            ],

            [
                'targets'   =>  4,
                'render'    =>  "
                    function (data, type, row, meta) {
                        return row.city_name
                    }
                "
            ],
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
     * Get custom buttons for the datatable.
     *
     * @return array<int, static>
     */
    private function getCustomButtons()
    {
        return [
            Button::make([
                'extend'    => 'pageLength',
                'className' => 'btn mb-3'
            ]),

            Button::make([
                'extend'    =>  'excel',
                'text'      =>  'Export To Excel',
                'className' =>  'btn mb-3'
            ]),

            Button::make([
                'extend'    =>  'csv',
                'text'      =>  'Export To CSV',
                'className' =>  'btn mb-3'
            ]),
        ];
    }

    /**
     * Transform data & return it as an array.
     *
     * @param \App\Models\User $user
     *
     * @return array<string, mixed>
     */
    private function getTransformedModelData(User $user): array
    {
        switch ($user->gender) {
            case 'm':
                $user->gender = 'Male';
                break;

            case 'f':
                $user->gender = 'Female';
                break;

            case 'o':
                $user->gender = 'Other';
                break;
        }

        return [
            'id'        =>  $user->id,
            'name'      =>  $user->name,
            'email'     =>  $user->email,
            'gender'    =>  $user->gender,
            'city_id'   =>  $user->city_id,

            'city_name' =>  $user->city->name
                . ', ' . $user->city->state->name
                . ', ' . $user->city->state->country->name,

            'created_at'    =>  Carbon::parse($user->created_at)->toDateTimeString(),
            'updated_at'    =>  Carbon::parse($user->updated_at)->toDateTimeString(),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Users_' . date('Y-M-d');
    }
}
