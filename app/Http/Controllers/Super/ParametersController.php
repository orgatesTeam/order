<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use File;

class ParametersController extends Controller
{
    private $space = '    ';

    public function index()
    {
        return view('super.parameters.index');
    }

    public function all()
    {
        $parameters = config('super');
        return response()->json(['parameters' => $parameters]);
    }

    public function update()
    {
        $super = config('super');
        $newSuper = $super;

        foreach ($super as $key => $value) {
            //request 存在 config key
            if ($value = request($key)) {
                $newSuper[$key]['value'] = $value;
            }
        }

        $newSuperFile = $this->array2File($newSuper);
        try {
            file_put_contents(config_path() . '/super.php', $newSuperFile);
        } catch (\Exception $e) {

            // 刪除錯誤檔案
            File::delete(config_path() . '/super.php');

            //產生未錯誤的版本
            $newSuperFile = $this->array2File($super);
            file_put_contents(config_path() . '/super.php', $newSuperFile);
            return response()->json(['status' => 'fail']);
        }

        return response()->json(['parameters' => $newSuper]);
    }

    protected function array2File($super)
    {
        $file = sprintf("<?php %sreturn [%s", PHP_EOL, PHP_EOL);
        $space = $this->space;
        foreach ($super as $item => $parameter) {
            if (gettype($parameter) === 'array') {
                $parameter = $this->parameterParser($parameter, $space);
            }
            $file .= sprintf("%s'%s' => %s", $space, $item, $parameter);
        }

        return $file .= '];';
    }

    protected function parameterParser(array $parameter, $space)
    {
        $oldSpace = $space;
        $space = $space . $this->space;

        $newParameter = '[' . PHP_EOL;
        foreach ($parameter as $key => $value) {
            if (gettype($value) === 'array') {
                $value = $this->parameterParser($value, $space);
            } else {
                $value = sprintf("'%s',%s", $value, PHP_EOL);
            }
            $newParameter .= sprintf("%s'%s' => %s", $space, $key, $value);
        }
        return $newParameter .= sprintf("%s],%s", $oldSpace, PHP_EOL);
    }
}