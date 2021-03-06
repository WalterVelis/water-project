<?php

namespace App\Exports;

use App\CostFormat;
use App\MaterialFormat;
use App\Role;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithMapping;

use \Maatwebsite\Excel\Sheet;
use DB;

class Cost_Format_xlsx implements FromCollection, ShouldAutoSize, WithHeadings, WithCustomStartCell, WithEvents, WithTitle, WithDrawings, WithMapping
{

    protected $project_id;

    function __construct($project_id) {
            $this->project_id = $project_id;
    }

	 public function collection()    // Function containing the query to get the data.
    {
        $data = CostFormat::with('costs')->where('format_id', $this->project_id)->get();
        return $data;

    }

    public function headings(): array   // Function where the headers are specified.
    {
        return [
            __('Días'),
            __('Especialidad'),
            __('Precio unitario'),
            __('Total'),
        ];
    }

    public function map($data): array
    {
        return [
            $data->day,
            $data->costs->name,
            $data->cost,
            "$".$data->cost * $data->day,
         ];
     }

    public function startCell(): string
    {
        return 'A6';
    }

    public function title(): string  // Is where the file name is specified.
    {
        return "Mano de Obra";
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Cotizador Agua H2O');
        $drawing->setDescription('H2O');
        $drawing->setPath(public_path('/email/logo-bf.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(15);
        $drawing->setOffsetY(9);

        return $drawing;
    }

    public function registerEvents(): array  // Function where styles are detailed.
    {
        return [

    	   	Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
			 	$sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
			}),

    		AfterSheet::class => function(AfterSheet $event) {

    			$col='D';  // We pass the column where it ends the headers

                $event->sheet->mergeCells('A1:'.$col.'5');    // combine cells
	            $event->sheet->setCellValue('A1', ' Mano de Obra');    // Insert text
				$event->sheet->getRowDimension('5')->setRowHeight(20);
				$event->sheet->getRowDimension('6')->setRowHeight(23);  // Assign cell height

                $event->sheet->getStyle('A1:'.$col.'6')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000000'],
                        'size' => 16,
                    ],
                    'alignment' => [
					    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
					],
                ]);

	            $event->sheet->getStyle('A6:'.$col.'6')->applyFromArray([
	            	'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFF'],
                        'size' => 12,
                    ],
                    'fill' => [
    			        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    			        'color' => [
    			            'argb' => '0b6696',
    			        ]
    			    ],
                ]);

       			// $conteo=DB::table('roles') // Query to get the number of rows
   				// 		->select(DB::raw('count(*) as cantidad'))->get();

   				// foreach ($conteo as $c){
                // 	$cant= $c->cantidad;
            	// }

            	// $cant+=6;
       			// $cellRange='A7:'.$col.$cant;
				// $event->sheet->styleCells($cellRange,   // Add border to table, we pass the parameter of the number of rows.
				//     [
				//         'borders' => [
				//             'outline' => [
				//                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				//                 'color' => ['argb' => '00000000'],
				//             ],
				//         ],
        	   	// 		'font' => [
        	    //              'color' => ['argb' => '000000'],
        	    //              'size' => 11,
                //         ]
				//     ]
				// );
        	}
        ];
    }
}
