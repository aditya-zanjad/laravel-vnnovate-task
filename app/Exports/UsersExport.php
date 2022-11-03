<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;

class UsersExport implements FromCollection
{
    /**
     * Define name of the exported excel file
     *
     * @var string $fileName
     */
    private $fileName = 'users.xlsx';

    /**
     * Optional writer type
     *
     * @var \Maatwebsite\Excel\Excel $writerType
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     *
     * @var array<string, string> $headers
     */
    private $headers = ['Content-Type' => 'text/csv'];

    /**
     * Genders short forms and their real values
     *
     * @var array<string, string>
     */
    protected $gender = [
        'm' => 'Male',
        'f' => 'Female',
        'o' => 'Other'
    ];

    /**
     * To Decide the number of items per page in the pagination
     *
     * @var int $perPage
     */
    protected $perPage = 0;

    /**
     * To decide the page number in the pagination
     *
     * @var int $page
     */
    protected $page = 0;

    /**
     * To be used as a filter to get particular users data
     *
     * @var string $city
     */
    protected $city = 0;

    /**
     * To be used as a filter to get particular users data
     *
     * @var string $startDate
     */
    protected $startDate = '';

    /**
     * To be used as a filter to get particular users data
     *
     * @var string $endDate
     */
    protected $endDate = '';

    /**
     * Initialize class variables to be used in the eloquent query below.
     *
     * $size                    =>  users per page.
     * $page                    =>  page number.
     * $city                    =>  The ID of the city for filtering out the users by their 'city_id'.
     * '$startDate & $endDate'  =>  users' 'registration_date' range for filtering out the users by their 'registration_date'.
     *
     * @param   int     $size
     * @param   int     $page
     * @param   int     $city
     * @param   string  $startDate
     * @param   string  $endDate
     *
     * @return  void
     */
    public function __construct(int $perPage, int $page, int $city, string $startDate = '', string $endDate = '')
    {
        $this->perPage      =   $perPage;
        $this->page         =   $page;
        $this->city         =   $city;
        $this->startDate    =   $startDate;
        $this->$endDate     =   $endDate;
    }

    /**
     * Specify headings in the excel document for each column
     *
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            '#',
            'ID',
            'Name',
            'Email',
            'Gender',
            'Registration Date',
            'City',
            'State',
            'Country'
        ];
    }

    /**
     * Map the data that needs to be added as a row
     *
     * @param   \App\Models\User $user
     *
     * @return  array<int, mixed>
     */
    public function map($user): array
    {
        return [
            $user->index,
            $user->id,
            $user->name,
            $user->email,
            $user->gender,
            $user->registration_date,
            $user->city->name,
            $user->city->state->name,
            $user->city->state->country->name
        ];
    }

    /**
     * Build dynamic query based upon the provided data in the constructor & return its results.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function collection()
    {
        $query = User::query();

        // If city ID is given, filter by city ID
        if (!empty($this->city)) {
            $query->where('city_id', $this->city);
        }

        // If only the first date is given, filter by given 'registration_date'
        if (!empty($this->startDate)) {
            $query->where('registration_date', $this->startDate);
        }

        // If both dates are given, filter by dates range
        if (!empty($this->startDate) && !empty($this->endDate)) {
            $query->whereBetween('registration_date', [$this->startDate, $this->endDate]);
        }

        $users = $query->paginate(perPage: $this->size, page: $this->page);

        // Modify & organize data into appropriate format
        $index = 0;
        $users->through(function ($user) use (&$index) {
            $index++;
            $user->{'index'} = $index;

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

            $user->registration_date = date('Y-m-d', strtotime($user->registration_date));
            return $user;
        });

        return $users;
    }
}
