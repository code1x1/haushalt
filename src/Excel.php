<?php

namespace Bsp\PhpUnitProjekt;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Cell;
use Box\Spout\Reader\ReaderInterface;
use Box\Spout\Writer\WriterInterface;

class Excel {
    
    private ReaderInterface $reader;
    private WriterInterface $writer;
    private string $tmpName = '-tmp.xlsx';

    public function __construct(
        private string $filePath
    ) {
        $this->reader = ReaderEntityFactory::createReaderFromFile($filePath);
        $this->writer = WriterEntityFactory::createWriterFromFile($filePath);
    }

    public function printAll() {
        $this->reader->open($this->filePath);
        echo '<table>';
        foreach ($this->reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowCount => $row) {

                if($rowCount === 1):
                    echo "<thead><tr>";
                else:
                    echo "<tbody><tr>";
                endif;

                /**
                 * @var Cell[]
                 */
                $cells = $row->getCells();
                foreach ($cells as $cellCount => $cell) {
                    if($rowCount === 1):
                        echo "<td>{$cell->getValue()}</td>";
                    else:
                        echo "<td>{$cell->getValue()}</td>";
                    endif;
                }

                if($rowCount === 1):
                    echo "</tr></thead>";
                else:
                    echo "</tr></tbody>";
                endif;
            }
            echo '</table>';
        }

        $this->reader->close();
    }

    public function getRows() {
        $this->reader->open($this->filePath);
        $rows = [];
        foreach ($this->reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowCount => $row) {
                $rows[] = $row;
            }
        }

        $this->reader->close();
        return $rows;
    }

    public function getRow($goto) {
        $this->reader->open($this->filePath);
        foreach ($this->reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowCount => $row) {
                if ($rowCount > 1) {
                    /**
                     * @var Cell[]
                     */
                    $cells = $row->getCells();
                    if ($cells[1]->getValue() == $goto) {
                        $this->reader->close();
                        return $row;
                    }
                }
            }
        }

        $this->reader->close();
        return null;
    }

    public function addRow(array $values): string {
        $row = $this->getRow($values['name']);
        if ($row === null) {
            $this->_addRow($values);
            return "Zeile hinzugefügt!";
        } else {
            $this->_updateRow($values);
            return "Zeile geändert!";
        }
    }

    public function _addRow(array $values) {
        $this->reader->open($this->filePath);
        $this->writer = WriterEntityFactory::createWriterFromFile($this->filePath.$this->tmpName);
        $this->writer->openToFile($this->filePath.$this->tmpName);
        unset($values['submit']);
        $rowFromValues = WriterEntityFactory::createRowFromArray($values);
        // let's read the entire spreadsheet...
        foreach ($this->reader->getSheetIterator() as $sheetIndex => $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                // ... and copy each row into the new spreadsheet
                $this->writer->addRow($row);
            }
        }
        $startDate = WriterEntityFactory::createCell($values['start']);
        $startDate->setType(Cell::TYPE_STRING);
        $rowFromValues->setCellAtIndex($startDate, 6);
        $endDate = WriterEntityFactory::createCell($values['end']);
        $endDate->setType(Cell::TYPE_STRING);
        $rowFromValues->setCellAtIndex($endDate, 7);
        $this->writer->addRow(
            $rowFromValues
        );
        $this->writer->close();
        $this->reader->close();
        unlink($this->filePath);
        rename($this->filePath.$this->tmpName, $this->filePath);
    }

    public function _updateRow(array $values) {
        $this->reader->open($this->filePath);
        $this->writer = WriterEntityFactory::createWriterFromFile($this->filePath.$this->tmpName);
        $this->writer->openToFile($this->filePath.$this->tmpName);
        foreach ($this->reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowCount => $row) {
                foreach ($row->getCells() as $cellCount => $cell) {
                    if ($rowCount > 1 && $cell->getValue() == $values['name']) {
                        $row->setCellAtIndex(WriterEntityFactory::createCell($values['name']), 0);
                        $row->setCellAtIndex(WriterEntityFactory::createCell($values['wert']), 1);
                        $row->setCellAtIndex(WriterEntityFactory::createCell($values['description']), 2);
                        $startDate = WriterEntityFactory::createCell($values['start']);
                        $startDate->setType(Cell::TYPE_STRING);
                        $row->setCellAtIndex($startDate, 6);
                        $endDate = WriterEntityFactory::createCell($values['end']);
                        $endDate->setType(Cell::TYPE_STRING);
                        $row->setCellAtIndex($endDate, 7);
                        break;
                    } else {
                        $row->setCellAtIndex(WriterEntityFactory::createCell($cell->getValue()), $cellCount);
                    }
                }
                $this->writer->addRow($row);
            }
        }
        $this->writer->close();
        $this->reader->close();
        unlink($this->filePath);
        rename($this->filePath.$this->tmpName, $this->filePath);
    }
}
