<?php
namespace Devil\Solidprinciple\app\Traits;

trait GetStubContents
{
    public function getStubContents($stub_path,$stubVariables = [])
    {
        $contents = file_get_contents($stub_path);
        $conditions = $stubVariables['stub_conditions']??[];
        unset($stubVariables['stub_conditions']);
        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('{{ '.$search.' }}' , $replace, $contents);
        }
        $conditionRemovedContent=  $this->replaceCondition($contents, $conditions);
        return $conditionRemovedContent;
    }
    public function removeDoubleQuote($array): string
    {
        $fillableCount = count($array);
        $newFillable = '[';
        if ($fillableCount == 0){
            $newFillable.="]";
        }else{
            foreach ($array as $key_1=> $fillable){
                $fillable=strtolower($fillable);
                if ($key_1 == $fillableCount-1) {
                    $newFillable.="'".$fillable."']";
                }else{
                    $newFillable.="'".$fillable."',";
                }
            }
        }
        return $newFillable;
    }


    protected function replaceCondition($content, array $data)
    {
        foreach ($data as $key => $value) {
            $content = preg_replace_callback(
                "/@if\('$key'\)(.*?)@else(.*?)@endif/s",
                function ($matches) use ($value) {
                    return $value ? $matches[1] : $matches[2];
                },
                $content
            );
            $content = preg_replace_callback(
                "/@if\('$key'\)(.*?)@endif/s",
                function ($matches) use ($value) {
                    return $value ? $matches[1] : '';
                },
                $content
            );
        }

        return $content;
    }
    public function removeEmptyLines($fileContents): array|string|null
    {
        // Read the contents of the file
        // Remove empty lines between curly braces
         $pattern = '/{(\s*?)}/';
         $replacement = '{}';
        // Write the modified contents back to the file
        return preg_replace($pattern, $replacement, $fileContents);
//        file_put_contents($filePath, $fileContents);
    }
    public function pathToNameSpace($directory): string
    {
        return implode("\\",
            array_map(
                fn($data)=> $data= \Illuminate\Support\Str::ucfirst($data),
                explode("/",$directory)
            )
        );
    }
}
