<?php

namespace PHPMaker2022\school;

/**
 * Class for export to Excel5 by PhpSpreadsheet
 */
class ExportExcel5 extends ExportBase
{
    public $PhpSpreadsheet;
    public $RowType = 0;
    public $PageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT;
    public $PageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
    public static $TextWidthMultiplier = 2; // Cell width multipler for text fields
    public static $WidthMultiplier = 0.15; // Cell width multipler for image fields
    public static $HeightMultiplier = 0.8; // Row height multipler for image fields
    public static $MaxImageWidth = 400; // Max image width <= 400 is recommended

    // Constructor
    public function __construct(&$tbl, $style = "")
    {
        parent::__construct($tbl, $style);
        $this->PhpSpreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $this->PhpSpreadsheet->setActiveSheetIndex(0);
        if ($tbl->ExportExcelPageOrientation != "") {
            $this->PageOrientation = $tbl->ExportExcelPageOrientation;
        }
        if ($tbl->ExportExcelPageSize != "") {
            $this->PageSize = $tbl->ExportExcelPageSize;
        }
        $this->PhpSpreadsheet->getActiveSheet()->getPageSetup()->setOrientation($this->PageOrientation);
        $this->PhpSpreadsheet->getActiveSheet()->getPageSetup()->setPaperSize($this->PageSize);
    }

    // Convert to UTF-8
    public function convertToUtf8($value)
    {
        $value = RemoveHtml($value);
        $value = HtmlDecode($value);
        //$value = HtmlEncode($value); // No need to encode (unlike PHPWord)
        return ConvertToUtf8($value);
    }

    /**
     * Set value by column and row
     *
     * @param int $col Column (1-based)
     * @param int $row Row (1-based)
     * @param mixed $val Value (utf-8 encoded)
     * @return void
     */
    public function setCellValueByColumnAndRow($col, $row, $val)
    {
        $txt = $val instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText ? $val->getPlainText() : $val;
        $this->PhpSpreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $val);
        if ($this->Horizontal) {
            $letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet = $this->PhpSpreadsheet->getActiveSheet();
            $cd = $sheet->getColumnDimension($letter);
            $font = $this->PhpSpreadsheet->getDefaultStyle()->getFont();
            $multiplier = preg_match("/\p{Han}+/u", $txt) ? self::$TextWidthMultiplier : 1;
            $w = \PhpOffice\PhpSpreadsheet\Shared\Font::getTextWidthPixelsApprox($txt, $font, 0) * $multiplier;
            $cd->setWidth(max($w, $cd->getWidth("px")), "px"); // Set column width
        }
    }

    // Table header
    public function exportTableHeader()
    {
        // Example - Insert an image at column "A"
        // $this->RowCnt++; // Increase row count
        // $image = $this->createImage("./upload/logo.png"); // Create image from a physical path or a path relative to project folder
        // $image->setCoordinates("A" . $this->RowCnt); // Insert image
    }

    // Field aggregate
    public function exportAggregate(&$fld, $type)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        if ($this->Horizontal) {
            global $Language;
            $val = "";
            if (in_array($type, ["TOTAL", "COUNT", "AVERAGE"])) {
                $val = $Language->phrase($type) . ": " . $this->convertToUtf8($fld->exportValue());
            }
            $this->setCellValueByColumnAndRow($this->FldCnt, $this->RowCnt, $val);
        }
    }

    // Field caption
    public function exportCaption(&$fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        $this->exportCaptionBy($fld, $this->FldCnt, $this->RowCnt);
    }

    // Field caption by column and row
    public function exportCaptionBy(&$fld, $col, $row)
    {
        $val = $this->convertToUtf8($fld->exportCaption());
        $this->setCellValueByColumnAndRow($col, $row, $val); // Plain text
    }

    // Create image
    public function createImage($file)
    {
        $sheet = $this->PhpSpreadsheet->getActiveSheet();
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setWorksheet($sheet);
        $drawing->setPath($file);
        if (self::$MaxImageWidth > 0 && $drawing->getWidth() > self::$MaxImageWidth) {
            $drawing->setWidth(self::$MaxImageWidth);
        }
        return $drawing;
    }

    // Field value by column and row
    public function exportValueBy(&$fld, $col, $row)
    {
        $val = "";
        $sheet = $this->PhpSpreadsheet->getActiveSheet();
        $letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
        if ($fld->ExportFieldImage && $fld->ViewTag == "IMAGE") { // Image
            $imagefn = $fld->getTempImage();
            if (!$fld->UploadMultiple || !ContainsString($imagefn, ",")) {
                $fn = ServerMapPath($imagefn, true);
                if ($imagefn != "" && file_exists($fn) && !is_dir($fn)) {
                    $drawing = $this->createImage($fn);
                    $drawing->setCoordinates($letter . strval($row));
                    $size = [$drawing->getWidth(), $drawing->getHeight()]; // Get image size
                    if ($size[0] > 0) { // Width
                        $sheet->getColumnDimension($letter)->setWidth($size[0] * self::$WidthMultiplier); // Set column width
                    }
                    if ($size[1] > 0) { // Height
                        $sheet->getRowDimension($row)->setRowHeight($size[1] * self::$HeightMultiplier); // Set row height
                    }
                }
            } else {
                $totalW = 0;
                $maxH = 0;
                $ar = explode(",", $imagefn);
                foreach ($ar as $imagefn) {
                    $fn = ServerMapPath($imagefn, true);
                    if ($imagefn != "" && file_exists($fn) && !is_dir($fn)) {
                        $drawing = $this->createImage($fn);
                        $drawing->setOffsetX($totalW);
                        $drawing->setCoordinates($letter . strval($row));
                        $size = [$drawing->getWidth(), $drawing->getHeight()]; // Get image size
                        if ($size[0] > 0) { // Width
                            $totalW += $size[0];
                        }
                        $maxH = max($maxH, $size[1]); // Height
                    }
                }
                if ($totalW > 0 && $this->Horizontal) { // Width
                    $cd = $sheet->getColumnDimension($letter);
                    $cd->setWidth(max($totalW * self::$WidthMultiplier, $cd->getWidth())); // Set column width
                }
                if ($maxH > 0) { // Height
                    $sheet->getRowDimension($row)->setRowHeight($maxH * self::$HeightMultiplier); // Set row height
                }
            }
        } elseif ($fld->ExportFieldImage && $fld->ExportHrefValue != "") { // Export custom view tag
            $imagefn = $fld->ExportHrefValue;
            $fn = ServerMapPath($imagefn, true);
            if ($imagefn != "" && file_exists($fn) && !is_dir($fn)) {
                $drawing = $this->createImage($fn);
                $drawing->setCoordinates($letter . strval($row));
                $size = [$drawing->getWidth(), $drawing->getHeight()]; // Get image size
                if ($size[0] > 0 && $this->Horizontal) { // Width
                    $cd = $sheet->getColumnDimension($letter);
                    $cd->setWidth(max($size[0] * self::$WidthMultiplier, $cd->getWidth())); // Set column width
                }
                if ($size[1] > 0) { // Height
                    $sheet->getRowDimension($row)->setRowHeight($size[1] * self::$HeightMultiplier); // Set row height
                }
            }
        } else { // Formatted Text
            $val = $this->convertToUtf8($fld->exportValue());
            if ($this->RowType > 0) { // Not table header/footer
                if (in_array($fld->Type, [4, 5, 6, 14, 131]) && $fld->Lookup === null) { // If float or currency
                    $val = $this->convertToUtf8($fld->CurrentValue); // Use original value instead of formatted value
                }
            }
            $this->setCellValueByColumnAndRow($col, $row, $val);
        }
    }

    // Begin a row
    public function beginExportRow($rowCnt = 0, $useStyle = true)
    {
        $this->RowCnt++;
        $this->FldCnt = 0;
        $this->RowType = $rowCnt;
    }

    // End a row
    public function endExportRow($rowCnt = 0)
    {
    }

    // Empty row
    public function exportEmptyRow()
    {
        $this->RowCnt++;
    }

    // Page break
    public function exportPageBreak()
    {
    }

    // Export a field
    public function exportField(&$fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        if ($this->Horizontal) {
            $this->exportValueBy($fld, $this->FldCnt, $this->RowCnt);
        } else { // Vertical, export as a row
            $this->RowCnt++;
            $this->exportCaptionBy($fld, 1, $this->RowCnt);
            $this->exportValueBy($fld, 2, $this->RowCnt);
        }
    }

    // Table footer
    public function exportTableFooter()
    {
    }

    // Add HTML tags
    public function exportHeaderAndFooter()
    {
    }

    // Export
    public function export()
    {
        global $ExportFileName;
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $ExportFileName . ".xls");
        header("Cache-Control: max-age=0");
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->PhpSpreadsheet, "Xls");
        $objWriter->save("php://output");
        DeleteTempImages();
    }

    // Destructor
    public function __destruct()
    {
        DeleteTempImages();
    }
}
