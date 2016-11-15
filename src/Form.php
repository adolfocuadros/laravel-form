<?php
namespace Adolfocuadros\LaravelForm;


class Form
{
    protected $inputs = [];

    protected $title = 'Titulo';
    protected $action = '';
    protected $vueAction = '';
    protected $inputsOnly = true;

    public $buffer = '';

    public function __construct($inputsOnly = true)
    {
        $this->inputsOnly = $inputsOnly;
    }

    public static function generate($inputsOnly = true) {
        $thisClass = get_called_class();
        $form = new $thisClass($inputsOnly);
        $form->render();
        return $form->getGenerate();
    }

    public function render() {
        for ($i = 0; $i < count($this->inputs); $i++) {
            if(isset($this->inputs[$i]['type']) && $this->inputs[$i]['type'] == 'select') {
                $this->addSelect($this->inputs[$i]);
            } else {
                $this->addInput($this->inputs[$i]);
            }
        }
    }

    public function addInput(array $data)
    {
        $name       = !empty($data['name']) ? $data['name'] : 'Input';
        $type       = !empty($data['type']) ? $data['type'] : 'text';
        $classCol   = !empty($data['class_col']) ? $data['class_col'] : 'col-sm-12';
        $vueModel    = !empty($data['vue_model']) ? $data['vue_model'] : null;
        $id         = !empty($data['id']) ? $data['id'] : null;
        $required   = !empty($data['required']) ? $data['required'] : false;
        $errorShow  = !empty($data['error_show']) ? $data['error_show'] : false;
        $moreAttr   = !empty($data['more_attr']) ? ' '.$data['more_attr'] : '';
        $value      = !empty($data['value']) ? $data['value'] : '';
        $errorModel = !empty($data['error_model']) ? $data['error_model'] : $vueModel;

        $this->buffer .= '<div class="'.$classCol.'" '.($errorShow ? 'v-bind:class="{\'has-error\' : error.'.$errorModel.' != null}"':'').'>
    <div class="sg-group">
        <div class="input-group input-group-sm">
            <label '.($id != null ? 'for="'.$id.'" ' : '').'class="input-group-addon text-bold">'.($required ? '<span class="text-red">(*)</span> ':'').$name.':</label>
            <input type="'.$type.'" class="form-control" '.($id != null ? 'id="'.$id.'" ' : '').'placeholder="'.$name.'" '.($value ? 'value="'.$value.'"':'').' '.($required?'required ':'').($vueModel != null ? 'v-model="'.$vueModel.'"' : '').$moreAttr.'>
        </div>
        '.($errorShow ? '<span class="help-block" v-if="error.'.$errorModel.' != null">{{ error.'.$errorModel.' }}</span>':'').'
    </div>
</div>';
    }

    public function addTextArea() {}

    public function addSelect(array $data)
    {
        $name       = !empty($data['name']) ? $data['name'] : 'Input';
        $classCol   = !empty($data['class_col']) ? $data['class_col'] : 'col-sm-12';
        $vueModel    = !empty($data['vue_model']) ? $data['vue_model'] : null;
        $id         = !empty($data['id']) ? $data['id'] : null;
        $required   = !empty($data['required']) ? $data['required'] : false;
        $errorShow  = !empty($data['error_show']) ? $data['error_show'] : false;
        $moreAttr   = !empty($data['more_attr']) ? ' '.$data['more_attr'] : '';
        $options    = !empty($data['options']) ? $data['options'] : [];
        $add        = !empty($data['add']) ? $data['add'] : null;
        $errorModel = !empty($data['error_model']) ? $data['error_model'] : $vueModel;

        $this->buffer .= '<div class="'.$classCol.'" '.($errorShow ? 'v-bind:class="{\'has-error\' : error.'.$errorModel.' != null}"':'').'>
    <div class="sg-group">
        <div class="input-group input-group-sm">
            <label '.($id != null ? 'for="'.$id.'" ' : '').'class="input-group-addon text-bold">'.($required ? '<span class="text-red">(*)</span> ':'').$name.': </label>
            <select class="form-control" '.($vueModel != null ? 'v-model="'.$vueModel.'"' : '').($required?' required':'').$moreAttr.'>';

        foreach ($options as $option) {
            $this->buffer .= '<option '.(!empty($option['v_for']) ? 'v-for="'.$option['v_for'].'"' : '').' '.(!empty($option['value']) ? 'value="'.$option['value'].'"' : '').'>'.$option['name'].'</option>';
        }

        $this->buffer .= '</select>
            '.($add != null ? '<span class="input-group-btn">
                <button type="button" class="btn btn-xs btn-info" @click="'.$add.'"><i class="fa fa-plus"></i></button>
            </span>' : '').'
        </div>
        '.($errorShow ? '<span class="help-block" v-if="error.'.$errorModel.' != null">{{ error.'.$errorModel.' }}</span>':'').'
    </div>
</div>';
    }

    public function addButton() {}

    public function setInputs($inputs) {
        $this->inputs = $inputs;
    }

    public function getGenerate() {
        if($this->inputsOnly == true) {
            return $this->buffer;
        }
        return '';
    }

}