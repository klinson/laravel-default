<?php
namespace App\Admin\Extensions\Exporters;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExporter extends AbstractExporter
{
    protected $fileName = '导出文件';
    protected $fields = [];

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function export()
    {
        Excel::create($this->fileName . '-' . date('YmdHis'), function($excel) {

            $excel->sheet('Sheetname', function($sheet) {

                $sheet->rows(collect([array_values($this->fields)]));

                // 这段逻辑是从表格数据中取出需要导出的字段
                $rows = collect($this->getData())->map(function ($item) {
                    return array_map(function ($item_c) use ($item) {
                        $tmp = explode('.', $item_c);
                        if (count($tmp) <= 1) {
                            return $item[$item_c];
                        } else {
//                            dump($item, $tmp);
                            return $item[$tmp[0]][$tmp[1]];
                        }
                    }, array_keys($this->fields));
//                    return array_only($item, array_keys($this->fields));
                });
                $sheet->rows($rows);

            });

        })->export('xls');
    }
}