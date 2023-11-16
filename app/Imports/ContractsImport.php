<?php

namespace App\Imports;

use App\Contract;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContractsImport implements ToModel//, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
    //    dd($row);
        return new Contract([
            //

            'contract_number' => $row[0],
            'description' => $row[1],
            'status' => $row[3],
            'start_date' => $row[4],
            'original_end_date' => $row[5],
            'new_end_date' => $row[6],
            'contract_type' => $row[7],
            'contract_relation' => $row[8],
            'budget_holder_department' => $row[9],
            'budget_holder_person' => $row[10],
            'technical_coordinator_department' => $row[11],
            'technical_coordinator_person' => $row[12],
            'commercial_coordinator_department' => $row[13],
            'commercial_coordinator_person' => $row[14],
            'linked_to_number' => $row[15],
            'reference_number' => $row[16],
            'last_edited' => $row[17],
            'product_and_service_groups' => $row[18]

            /*'contract_number' => $row['Number'],
            'description' => $row['Description'],
            'status' => $row['Status'],
            'start_date' => $row['Start date'],
            'original_end_date' => $row['Original end date'],
            'new_end_date' => $row['New end date'],
            'contract_type' => $row['Contract type'],
            'contract_relation' => $row['Contract relation'],
            'budget_holder_department' => $row['Budget holder (department)'],
            'budget_holder_person' => $row['Budget holder (person)'],
            'technical_coordinator_department' => $row['Technical co-ordinator (department)'],
            'technical_coordinator_person' => $row['Technical co-ordinator (person)'],
            'commercial_coordinator_department' => $row['Commercial co-ordinator (department)'],
            'commercial_coordinator_person' => $row['Commercial co-ordinator (person)'],
            'linked_to_number' => $row['Linked to number'],
            'reference_number' => $row['Reference number'],
            'last_edited' => $row['Last edited'],
            'product_and_service_groups' => $row['Product and service groups']*/
        ]);
    }
}
