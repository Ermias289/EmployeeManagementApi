<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this -> id, 
            "first_name" => $this -> first_name,
            "last_name" => $this -> last_name,
            "email" => $this -> email,
            "phone_number"=> $this -> phone_number,
            "department_id" => $this -> department_id,
            "hire_date" => $this -> hire_date,
            "salary" => $this -> salary,
            "job_title" => $this -> job_title,
            "status" => $this -> status,
            
            "department" => [
                "id" => $this->department->id,
                "name" => $this->department->name,
                "description" => $this -> department->description
            ]
        ];
    }
}
