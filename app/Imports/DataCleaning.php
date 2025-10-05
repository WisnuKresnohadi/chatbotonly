<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataCleaning
{
    protected $primaryKey;
    protected $specialExcelColumns;
    protected $specialModelDb;
    protected $additionalData;
    protected $formatInput;
    protected $table;
    protected $excelColumns;
    protected $dbColumns;   
    protected $restrictedByAdditional; 
    protected $validationRules;
    protected $validationMessages;
    protected $cleanedData;
    protected $newData;
    protected $duplicatedData;
    protected $failedData;

    public function __construct($primaryKey, $excelColumns, $dbColumns, $validationRules, $validationMessages, $table, $specialModelDb, $additionalData = [], $restrictedByAdditional = false)
    {
        $this->primaryKey = $primaryKey;
        $this->specialModelDb = $specialModelDb;
        $this->table = $table;
        $this->specialExcelColumns = isset($this->specialModelDb[$this->table]) ? (is_string($this->specialModelDb[$this->table]) ? [preg_replace('/\|.*/', '', $specialModelDb[$this->table])] : preg_replace('/\|.*/', '', $specialModelDb[$this->table])) : [];
        $this->additionalData = $additionalData;
        foreach ($excelColumns as $field => $rule) {
            [$column, $format] = array_pad(explode('|', $rule), 2, "");
            $this->excelColumns[] = $column;
            $this->formatInput[$column] = $format;
        }        
        $this->restrictedByAdditional = $restrictedByAdditional;
        $this->dbColumns = $dbColumns;
        $this->validationRules = $validationRules;
        $this->validationMessages = $validationMessages;
        $this->cleanedData = collect();
        $this->newData = collect();
        $this->duplicatedData = collect();
        $this->failedData = collect();
    }

    public function collection(Collection $rows)
    {
        //===============[1]================
        // Filter and map rows based on primary key
        $rows = $rows->map(function ($row) {
            return $row->only($this->excelColumns);
        })
            ->filter(function ($row) {
                return $this->isEmptyRow($row);
            });
        // }) ->filter(function ($row) {
        //     return !is_null($row[$this->primaryKey]) && $row[$this->primaryKey] !== '';
        // });

        $rows = $rows->map(function ($row) {
            $mappedRow = [];
            foreach ($this->excelColumns as $index => $excelColumn) {
                $dbColumn = $this->dbColumns[$index] ?? null;
                if ($dbColumn) {
                    $format = strtolower($this->formatInput[$excelColumn]) ?? '';

                    $value = $row[$excelColumn];
                    if (is_string($value)) {
                        $value = trim($value);
                        $value = $this->applyFormat($value, $format);
                    }

                    $mappedRow[$dbColumn] = $dbColumn == $this->primaryKey ? trim((string) $value) : $value;
                }
            }
            return collect($mappedRow);
        });

        // dd($rows);
        //===============[1]================

        //===============[2]================
        // Group by primary key
        if (!empty($this->primaryKey)) {
            // Jika primaryKey ada, gunakan primaryKey untuk groupBy
            $groupedRows = $rows->groupBy($this->primaryKey);
        } else {            
            $groupedRows = $rows->groupBy(function ($row) {
                // Gabungkan nilai dari semua kolom di $dbColumns untuk groupBy
                return implode('|', array_map(function ($column) use ($row) {
                    return $row[$column];
                }, $this->dbColumns));
            });
        }        

        // Remove duplicates within each group
        $dedupedGroupedRows = $groupedRows->map(function ($group) {
            return $group->unique(function ($item) {
                return implode('', $item->toArray());
            });
        });

        if (empty($this->primaryKey)) {
   
            $dedupedGroupedRows->flatten(1)->each(function ($item) {
                // Lakukan validasi untuk setiap item                
                $validator = Validator::make($item->toArray(), $this->validationRules, $this->validationMessages);
        
                // Jika ada error, tambahkan pesan error pada item
                $itemWithErrors = $this->addErrorMessages($item, $validator);
    
                // Cek jika ada error
                if (!$this->hasErrors($itemWithErrors)) {
                    // Jika tidak ada error, tambahkan ke cleanedData
                    $this->cleanedData->push($itemWithErrors);
                } else {
                    // Jika ada error, tambahkan ke failedData
                    $this->failedData[] = $itemWithErrors;
                }
            });
            return;
        }        
        
        //===============[2]================     

        //===============[3]================
        $seenPrimaryKeys = [];
        $primaryKeyGroups = $dedupedGroupedRows->flatten(1)->groupBy($this->primaryKey);
        $seenSpecialKeys = [];
        $groupedSpecialColumns = [];

        foreach ($this->specialExcelColumns as $column) {
            $seenSpecialKeys[$column] = [];
            $groupedSpecialColumns[$column] = $dedupedGroupedRows->flatten(1)->groupBy($column);
        }

        $dedupedGroupedRows->each(function ($group, $primaryKeyValue) use (&$seenSpecialKeys, &$seenPrimaryKeys, $primaryKeyGroups, $groupedSpecialColumns) {
            // Validate each item in the group
            $validatedGroup = $group->map(function ($item) {                
                $validator = Validator::make($item->toArray(), $this->validationRules, $this->validationMessages);
                return $this->addErrorMessages($item, $validator);
            });

            $isDuplicate = false;
            $duplicateMessage = '';

            if (in_array($primaryKeyValue, $seenPrimaryKeys) || $primaryKeyGroups[$primaryKeyValue]->count() > 1) {
                $isDuplicate = true;
                $duplicateMessage .= "- Duplicate {$this->primaryKey}";
            }

            $columnKeyValue = [];
            foreach ($this->specialExcelColumns as $column) {
                $columnKeyValue[$column] = $group->first()[$column];

                if (empty($columnKeyValue[$column])) {
                    continue;
                }

                if (in_array($columnKeyValue, $seenSpecialKeys[$column])) {
                    $isDuplicate = true;
                    $duplicateMessage .= ($duplicateMessage ? "<br>" : "") . "- Duplicate {$column}";
                }

                if ($groupedSpecialColumns[$column][$columnKeyValue[$column]]->count() > 1) {
                    $isDuplicate = true;
                    $duplicateMessage .= ($duplicateMessage ? "<br>" : "") . "- Duplicate {$column}";
                }
            }

            if ($group->count() === 1 && !$this->hasErrors($validatedGroup->first()) && !$isDuplicate) {
                $this->cleanedData->push($group->first());
                $seenPrimaryKeys[] = $primaryKeyValue;

                foreach ($this->specialExcelColumns as $column) {
                    $seenSpecialKeys[$column][] = $columnKeyValue[$column];
                }
            } else {
                if ($isDuplicate) {
                    $validatedGroup = $validatedGroup->map(function ($item) use ($duplicateMessage) {
                        $item[$this->primaryKey . '_error'] = str_contains($duplicateMessage, "- Duplicate {$this->primaryKey}") ? "Duplicate {$this->primaryKey}" : $item[$this->primaryKey . '_error'];
                        foreach ($this->specialExcelColumns as $column) {
                            $item[$column . '_error'] = str_contains($duplicateMessage, "- Duplicate {$column}") ? "Duplicate {$column}" : $item[$column . '_error'];
                        }

                        $item['duplicate_error'] = $duplicateMessage;
                        $item['messages'] .= $item['messages'] ? "<br>" . $item['duplicate_error'] : $item['duplicate_error'];
                        return $item;
                    });
                }
                $this->failedData[$primaryKeyValue] = $validatedGroup;
            }
        });
        //===============[3]================

        $this->failedData = $this->failedData->flatten(1);

        // Move all instances of duplicate emails to failedData
        $duplicateSpecialKeys = [];
        foreach ($this->specialExcelColumns as $column) {
            $duplicateSpecialKeys[$column] = $groupedSpecialColumns[$column]->filter(function ($group) {
                return $group->count() > 1;
            })->keys();
        }

        foreach ($this->specialExcelColumns as $column) {
            $this->cleanedData = $this->cleanedData->reject(function ($item) use ($duplicateSpecialKeys, $column) {

                if ($duplicateSpecialKeys[$column]->contains($item[$column])) {
                    $item['duplicate_error'] = "Duplicate {$column}";
                    $item['messages'] .= $item['messages'] ? "<br>" . $item['duplicate_error'] : $item['duplicate_error'];
                    $this->failedData->push($item);
                    return true;
                }
                return false;
            });
        }
    }

    public function cleanDuplicateData()
    {
        $existingAllData = DB::table($this->table);

        if (!empty($this->primaryKey)) {
            // Jika ada primaryKey, gunakan primaryKey untuk whereIn
            $existingAllData = $existingAllData->whereIn($this->primaryKey, $this->cleanedData->pluck($this->primaryKey));
        } else {
            // Jika tidak ada primaryKey, lakukan pencocokan berdasarkan semua field di $dbColumns
            $existingAllData = $existingAllData->where(function ($query) {
                $this->cleanedData->each(function ($cleanedRow) use ($query) {
                    $query->orWhere(function ($subQuery) use ($cleanedRow) {
                        foreach ($this->dbColumns as $column) {
                            $subQuery->where($column, $cleanedRow[$column]);
                        }
                    });
                });
            });
        }
        
        // Memproses kolom khusus yang perlu diperhatikan
        foreach ($this->specialExcelColumns as $specialColumn) {
            $existingAllData = $existingAllData->orWhereIn($specialColumn, $this->cleanedData->pluck($specialColumn));
        }
        
        // Ambil data dan simpan dalam bentuk keyed collection
        $existingAllData = $existingAllData->get();
        
        if (!empty($this->primaryKey)) {
            $existingAllData = $existingAllData->keyBy($this->primaryKey);
        } else {
            // Jika tidak ada primaryKey, keyBy menggunakan kombinasi semua field
            
            $existingAllData = $existingAllData->keyBy(function ($row) {
                return implode('-', array_map(function ($column) use ($row) {                    
                    return $row->{$column};
                }, $this->dbColumns));
            });
        }
        
        // Menyimpan model yang terkait dengan data yang diambil
        $relatedModel = [$existingAllData];
        
        // Menangani specialModelDb jika ada
        if ($this->specialModelDb) {
            foreach ($this->specialModelDb as $key => $specialModel) {
                if ($key == $this->table) continue;
        
                if ($specialModel) {
                    $query = DB::table($key)->select(
                        columns: is_string($specialModel) ?
                            explode('|', $specialModel)[0] :
                            array_reduce($specialModel, function ($carry, $item) {
                                return array_merge($carry, explode('|', $item));
                            }, [])
                    );
        
                    // Menggunakan orWhereIn logic untuk specialModel
                    if (is_string($specialModel)) {
                        $specialKey = explode('|', $specialModel);
                        $query->orWhereIn($specialKey[0], $this->cleanedData->pluck($specialKey[1])->toArray());
                    } else {
                        // Jika specialModel adalah array, iterasi setiap kolom
                        foreach ($specialModel as $column) {
                            $specialKey = explode('|', $column);
                            $query->orWhereIn($specialKey[0], $this->cleanedData->pluck($specialKey[1])->toArray());
                        }
                    }
        
                    // Tambahkan hasil query ke dalam $relatedModel
                    $relatedModel[] = $query->get();
                }
            }
        }
        
        // Flatten the relatedModel array menjadi satu dimensi
        $relatedModel = collect($relatedModel)->flatten(1)->toArray();        

        foreach ($this->cleanedData as $row) {
            $hasDuplicate = false;
            $existingDataCurrent = null;
            $duplicateMessage = '';
        
            // Cek berdasarkan primaryKey jika ada, jika tidak ada gunakan semua field
            if (!empty($this->primaryKey) && $existingAllData->has($row[$this->primaryKey])) {
                $existingDataCurrent = $existingAllData[$row[$this->primaryKey]];
            } elseif (empty($this->primaryKey)) {
                // Cek berdasarkan kombinasi semua field
                $existingDataCurrent = $existingAllData->first(function ($existingRow) use ($row) {
                    foreach ($this->dbColumns as $column) {                        
                        if ($existingRow->{$column} != $row[$column]) {
                            return false; 
                        }
                    }

                    foreach ($this->additionalData as $restrictField => $restrictValue) {
                        if ($existingRow->$restrictField != $restrictValue) {
                            return false;
                        }
                    }
                    return true; 
                });
            }
        
            // Periksa specialModelDb
            foreach ($this->specialModelDb as $tableName => $columnMapping) {
                $columnsToCheck = is_string($columnMapping)
                    ? [explode('|', $columnMapping)]
                    : array_map(fn($col) => explode('|', $col), $columnMapping); // Array case
        
                foreach ($columnsToCheck as $specialKey) {
                    $specialColumn = $specialKey[1];
        
                    $existingData = collect($relatedModel)->first(function ($item) use ($specialKey, $row, $specialColumn) {
                        if (!isset($item->{$specialKey[0]})) return null;
        
                        if (isset($specialKey[2])) {
                            if ($specialKey[2] === 'restrict') {
                                foreach ($this->additionalData as $field => $value) {
                                    if ($item->{$field} != $value) {
                                        return null;
                                    }
                                }
                            }
                        }
        
                        if (is_string($item->{$specialKey[0]}) && is_string($row[$specialColumn])) {
                            return strtolower($item->{$specialKey[0]}) === strtolower($row[$specialColumn]);
                        }
        
                        return $item->{$specialKey[0]} == $row[$specialColumn];
                    });
        
                    if ($existingData && (!$existingDataCurrent ||
                        (is_string($existingDataCurrent->{$specialColumn}) && is_string($existingData->{$specialKey[0]})
                            ? strtolower($existingDataCurrent->{$specialColumn}) != strtolower($existingData->{$specialKey[0]})
                            : $existingDataCurrent->{$specialColumn} != $existingData->{$specialKey[0]}))) {
        
                        $hasDuplicate = true;
                        $validator = Validator::make(collect($row)->toArray(), $this->validationRules, $this->validationMessages);
                        $row =  $this->addErrorMessages(collect($row), $validator);
                        if (strpos($duplicateMessage, $specialColumn) === false) {
                            $duplicateMessage .= ($duplicateMessage ? "<br>" : "") . "- {$specialColumn} sudah ada";
                        }
                        $row[$specialColumn . '_error'] = "{$specialColumn} sudah ada";
                    }
                }
            }
        
            if ($existingDataCurrent) {
                if ($hasDuplicate) {
                    $row['messages'] = $duplicateMessage;
                    $this->failedData->push($row);
                } else {
                    $differences = $this->findDifferences($existingDataCurrent, $row);
                    if ($differences) {
                        $isRestrictionValid = true;
        
                        if($this->restrictedByAdditional) {
                            foreach ($this->additionalData as $restrictField => $restrictValue) {
                                if ($existingDataCurrent->$restrictField != $restrictValue) {
                                    $isRestrictionValid = false;
                                }
                            }
            
                            if (!$isRestrictionValid) {
                                $validator = Validator::make(collect($row)->toArray(), $this->validationRules, $this->validationMessages);
                                $row = $this->addErrorMessages(collect($row), $validator);
                                if (strpos($duplicateMessage, $this->primaryKey) === false) {
                                    $duplicateMessage .= ($duplicateMessage ? "<br>" : "") . "- {$this->primaryKey} sudah ada";
                                }
                                $row[$this->primaryKey . '_error'] = "{$this->primaryKey} sudah ada";
                                $row['messages'] = $duplicateMessage;
                                $this->failedData->push($row);
                                continue;
                            }
            
                        }
                        
                        $this->duplicatedData->push([
                            'existing' => (array) $existingDataCurrent,
                            'new' => $row,
                            'differences' => $differences
                        ]);
                    }
                }
            } else {
                if ($hasDuplicate) {
                    $row['messages'] = $duplicateMessage;
                    $this->failedData->push($row);
                } else {
                    $this->newData->push($row);
                }
            }
        }        
    }

    private function addErrorMessages($item, $validator)
    {
        $itemWithErrors = $item->toArray();
        $messages = [];
        foreach ($this->dbColumns as $column) {
            $errorMessage = $validator->errors()->first($column);
            $itemWithErrors["{$column}_error"] = $errorMessage ?? "";

            if ($errorMessage && !in_array("- " . $errorMessage, $messages)) {
                $messages[] = "- " . $errorMessage;
            }
        }

        $itemWithErrors['messages'] = implode('<br>', $messages);
        return $itemWithErrors;
    }

    private function hasErrors($item)
    {
        return collect($item)
            ->filter(function ($value, $key) {
                return str_ends_with($key, '_error');
            })
            ->filter()
            ->isNotEmpty();
    }

    private function isEmptyRow($newData)
    {
        $isEmptyRow = [];

        foreach ($this->excelColumns as $field) {
            if ($newData[$field] == '') {
                $isEmptyRow[$field] = true;
            }
        }

        if (count($isEmptyRow) == count($this->excelColumns)) {
            return false;
        }

        return true;
    }

    private function findDifferences($existingData, $newData)
    {
        $differences = [];
        
        $newData = array_merge($newData->toArray(), $this->additionalData);
        $dbColumnsWithAdditional = array_merge($this->dbColumns, array_keys($this->additionalData) ?? []);

        foreach ($dbColumnsWithAdditional as $field) {
            if (is_string($existingData->$field) && is_string($newData[$field])) {
                if (strcasecmp($existingData->$field, $newData[$field]) != 0) {
                    $differences[$field] = true;
                }
            } else {
                if ($existingData->$field != $newData[$field]) {
                    $differences[$field] = true;
                }
            }
        }

        return $differences;
    }

    public function getCleanedData()
    {
        return $this->cleanedData;
    }

    public function getFailedData()
    {
        return $this->failedData;
    }

    public function getNewData()
    {
        return $this->newData;
    }

    public function getDuplicatedData()
    {
        return $this->duplicatedData;
    }

    protected function applyFormat($value, $format)
    {
        switch ($format) {
            case 'lowercase':
                return strtolower($value);
            case 'uppercase':
                return strtoupper($value);
            case 'capitalize':
                return ucwords(strtolower($value));
            default:
                return $value; // No format applied
        }
    }
}
