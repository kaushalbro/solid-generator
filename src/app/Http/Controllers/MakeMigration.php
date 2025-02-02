<?php
namespace Devil\Solidprinciple\app\Http\Controllers;

use Devil\Solidprinciple\app\Traits\FileFolderManage;
use Devil\Solidprinciple\app\Traits\GetStubContents;
use Illuminate\Support\Str;

class MakeMigration extends BaseController
{
    use FileFolderManage, GetStubContents;

    protected $model_data;

    protected string $stub_path;

    protected string $dir_name='database/migrations';

    public function __construct($model_data)
    {
            parent::__construct();
            $data =is_array($model_data)?$model_data[1]:file_get_contents($model_data);
            $this->model_data =$data;
            $this->stub_path =__DIR__.'/../../stubs/migration.stub';
//            $this->dir_name=base_path('database/migrations');
            if (config('solid.migration_path')) $this->dir_name=config('solid.migration_path');
            $this->make();
    }

    public function make(): void
    {
        $model_data  = json_decode($this->model_data);
        foreach ($model_data as $key => $model){
            $table_name = $model->table_name??strtolower(Str::plural($model->model_name));
            $table_column = $model->model_attributes->db_rules;
            $column= "";
            foreach ($table_column as $key_1 => $value){
                $column_name='';
                $column_datatype='';
                $is_required = true ;
                $default= null;
                $is_enum=null;
                $enum_values= null;
                $is_unique=null;
                $min= null;
                $max = null;
                $is_precision=false;
                $is_foreign_key= null;
                $cascade_update=false;
                $cascade_delete=false;
                $cascade_restrict=false;
                $attributes= explode('|',$value);
                $column_whole=array_shift($attributes);
                $column_name= explode(':',$column_whole)[0];
                $column_datatype= explode('(',explode(':',$column_whole)[1]);
                if (($column_datatype[0] == 'enum')){
                    $is_enum=true;
                    $enum_values=explode(')',$column_datatype[1])[0];
                    $default=$default??explode(',',$enum_values)[0];
                }
                $column_datatype=$column_datatype[0];
                foreach ($attributes as $key_2 => $attribute){
                    $attribute_whole= explode(':',$attribute);
                    $attribute = $attribute_whole[0];
                    if ($attribute=='required') $is_required=true;
                    if ($attribute=='nullable') $is_required=false;
                    if ($attribute=='default'){$default = $attribute_whole[1];}
                    if ($attribute=='unique') $is_unique=true;
                    if ($attribute=='min') $min=$attribute_whole[1];
                    if ($attribute=='max') $max=$attribute_whole[1];
                    if ($attribute=='precision') $is_precision=$attribute_whole[1];
                    if ($attribute=='cascade'){
                      $cascade_actions=explode(',',$attribute_whole[1]);
                      if (in_array('update',$cascade_actions)) $cascade_update=true;
                      if (in_array('delete',$cascade_actions)) $cascade_delete=true;
                      if (in_array('restrict',$cascade_actions)) $cascade_restrict=true;
                    }
                }
                $col_rest='("'.$column_name.'")';
                if ($column_datatype =='enum'){
                        $enum_value ="[";
                        foreach (explode(',', $enum_values )as $key_2 =>$enumval ){
                            $enum_value.="'".$enumval."',";
                        }
                    $col_rest = '("'.$column_name.'",'.$enum_value.'])';
                }
                if (($min && $max) && !$is_enum){
                    $col_rest = '("'.$column_name.'",'.$min.','.$max.')';
                }
                if ($column_datatype=='file')$column_datatype='string';
                $col_attributes= (
                    ($is_required?'':'->nullable()').
                    ($is_unique?'->unique()':'').
                    ($default?  "->default(".((!is_numeric($default) && !($default=="true"||$default=="false"))?"'".$default."'":$default).")":'')
                    );
                if ($column_datatype=='foreign_key') {
                    $is_foreign_key= true;
                    $column_datatype = 'unsignedBigInteger';
                }
                $col='$table->'.$column_datatype.$col_rest.$col_attributes;
                if ($is_foreign_key){
                    $reference_table=Str::lower(Str::plural(explode('_',$column_name)[0]));
                    $reference_column=Str::lower(explode('_',$column_name)[1]);
                    $reference_migration='$table->foreign("'.$column_name.'")->references("'.$reference_column.'")->on("'.$reference_table.'")';
                    $reference_migration.=$cascade_delete?'->onDelete("cascade")':'';
                    $reference_migration.=$cascade_update?'->onupdate("cascade")':'';
                    $reference_migration.=$cascade_restrict?'->onDelete("restrict")':'';
                    $col.=';'."\n\t\t\t".$reference_migration;
                }
                $column .= $col .';'."\n\t\t\t";
            }
            $contents =$this->getStubContents($this->stub_path,[
                'classname'=> ucwords($table_name),
                'tablename'=> strtolower($table_name),
                'table_column_name'=>$column
            ]);
            $dateString = date("Y_m_d_His").'_';
            $migration_name = 'create_'.strtolower($table_name).'_table.php';
            if (!$this->migrationCreated($migration_name)){
                $this->makeFile($this->dir_name.'/'.$dateString.$migration_name, $contents);
            }else if (config('solid.show_folder_already_exists_warning')){
                error_log(sprintf("\033[33m%s\033[0m", $migration_name.' migration already created.'));
            }
        }
    }

    public function migrationCreated($migration_name): bool
    {
        // TO check if the migration is already created or not
        $files = scandir(base_path($this->dir_name));
        foreach ($files as $file) {
            $file_name = substr($file,  18);
             if ($migration_name == $file_name){
                return true;
             }
        }
        return false;
    }

    function laravelMigrationDataType(): array
    {
         return [
            'bigIncrements',    // Auto-incrementing UNSIGNED BIGINT
            'bigInteger',       // BIGINT
            'binary',           // BLOB
            'boolean',          // BOOLEAN
            'char',             // CHAR
            'date',             // DATE
            'dateTime',         // DATETIME
            'dateTimeTz',       // DATETIME with timezone
            'decimal',          // DECIMAL
            'double',           // DOUBLE
            'enum',             // ENUM
            'float',            // FLOAT
            'foreignId',        // UNSIGNED BIGINT with foreign key constraint
            'foreignIdFor',     // Foreign key column for a specific model
            'geometry',         // GEOMETRY
            'geometryCollection', // GEOMETRYCOLLECTION
            'id',               // Auto-incrementing UNSIGNED BIGINT (alias for bigIncrements)
            'increments',       // Auto-incrementing UNSIGNED INTEGER
            'integer',          // INTEGER
            'ipAddress',        // VARCHAR for storing IP addresses
            'json',             // JSON
            'jsonb',            // JSONB (PostgreSQL-specific)
            'lineString',       // LINESTRING
            'longText',         // LONGTEXT
            'macAddress',       // VARCHAR for storing MAC addresses
            'mediumIncrements', // Auto-incrementing UNSIGNED MEDIUMINT
            'mediumInteger',    // MEDIUMINT
            'mediumText',       // MEDIUMTEXT
            'morphs',           // Adds `id` and `type` for polymorphic relationships
            'multiLineString',  // MULTILINESTRING
            'multiPoint',       // MULTIPOINT
            'multiPolygon',     // MULTIPOLYGON
            'nullableMorphs',   // Nullable `id` and `type` for polymorphic relationships
            'nullableTimestamps', // Nullable TIMESTAMPS
            'point',            // POINT
            'polygon',          // POLYGON
            'rememberToken',    // VARCHAR(100) for "remember me" tokens
            'set',              // SET
            'smallIncrements',  // Auto-incrementing UNSIGNED SMALLINT
            'smallInteger',     // SMALLINT
            'softDeletes',      // Adds a `deleted_at` column (nullable TIMESTAMP)
            'softDeletesTz',    // Adds a `deleted_at` column with timezone (nullable TIMESTAMP)
            'string',           // VARCHAR
            'text',             // TEXT
            'time',             // TIME
            'timeTz',           // TIME with timezone
            'timestamp',        // TIMESTAMP
            'timestampTz',      // TIMESTAMP with timezone
            'tinyIncrements',   // Auto-incrementing UNSIGNED TINYINT
            'tinyInteger',      // TINYINT
            'unsignedBigInteger', // UNSIGNED BIGINT
            'unsignedDecimal',  // UNSIGNED DECIMAL
            'unsignedInteger',  // UNSIGNED INTEGER
            'unsignedMediumInteger', // UNSIGNED MEDIUMINT
            'unsignedSmallInteger',  // UNSIGNED SMALLINT
            'unsignedTinyInteger',   // UNSIGNED TINYINT
            'uuid',             // CHAR(36) for UUIDs
            'year',             // YEAR
        ];

    }
}
