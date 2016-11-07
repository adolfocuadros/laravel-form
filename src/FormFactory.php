<?php
namespace Adolfocuadros\LaravelForm;


class FormFactory
{
    public static function make($form)
    {
        $formClass = '\\App\\Forms\\'.$form;
        $numArgs = func_num_args();
        if($numArgs > 1) {
            $argList = func_get_args();
            //dd($argList);
            $genArgs = '';
            for ($i = 1; $i < $numArgs; $i++) {
                $genArgs = $i == 1 ? '"'.$argList[$i].'"' : ',"'.$argList[$i].'"';
            }
            $gen = '';
            eval('$gen = '.$formClass.'::generate('.$genArgs.');');
            return $gen;
        }
        return $formClass::generate();
    }

    public static function generate($inputs)
    {
        $form = new Form();
        $form->setInputs($inputs);
        $form->render();
        return $form->getGenerate();
    }
}