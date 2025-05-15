<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithTitle,WithHeadings
{
	// private $request;

 //    public function __construct($request)
 //    {
 //    	$this->request = $request;
 //    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return collect([['name' => "Umar Hayat", 'email' => "abc@gmail.com"], ['name' => "Jeremiah", 'email' => "jeremiah@gmail.com"]]);
        $data = [];
        $i = 0;
        $users = User::where([['created_at', '>', $this->request->from], ['created_at', '<', $this->request->to]])->get();
        foreach($users as $user)
        {
            $data[$i] = array(['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
            $i++;
        }
        return collect($data);
        // $usersData = User::all()->first();
        // dd($usersData);
        // return $usersData;
        // foreach ($usersData as $user) {
        //     $user->first();
        // }
        // return User::where([['created_at', '>', $this->request->from], ['created_at', '<', $this->request->to]])->get();
        // return User::first();
    }

    public function title() : string
    {
    	return "Users Sheet";
    }

    public function headings(): array
    {
        return [
           ['id', 'Name', 'Email']
        ];
    }
}
