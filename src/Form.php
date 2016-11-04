<?php
namespace Adolfocuadros\LaravelForm;


class Form
{
    public $inputs = [
        [
            'name'      =>  'Apellido Paterno',
            'type'      =>  'text',
            'class_col' =>  'col-md-4',
            'vue_data'  =>  'persona.apPaterno',
            'id'        =>  'apPaterno',
            'required'  =>  true,
            'error_show'=>  false,
            'more_attr' =>  ':readonly="flags.existePersona"'
        ]
    ];
    
    private $buffer = '';

    public function __construct()
    {

    }

    public function render() {}

    public function addInput(array $data) {
        $name = !empty($data['name']) ? $data['name'] : 'Input';
        $type = !empty($data['type']) ? $data['type'] : 'text';
        $classCol = !empty($data['class_col']) ? $data['class_col'] : 'col-sm-12';
        $vueData = !empty($data['vue_data']) ? $data['vue_data'] : null;
        $id = !empty($data['id']) ? $data['id'] : null;
        $required = !empty($data['required']) ? $data['required'] : false;
        $errorShow = !empty($data['error_show']) ? $data['error_show'] : false;
        $moreAttr = !empty($data['more_attr']) ? ' '.$data['more_attr'] : '';

        $this->buffer .= '<div class="'.$classCol.'" '.($errorShow ? 'v-bind:class="{\'has-error\' : error.'.$vueData.' != null}"':'').'>
        <div class="sg-group">
            <div class="input-group input-group-sm">
                <label '.($id != null ? 'for="'.$id.'" ' : '').'class="input-group-addon text-bold">'.($required ? '<span class="text-red">(*)</span> ':'').$name.':</label>
                <input type="'.$type.'" class="form-control" '.($id != null ? 'id="'.$id.'" ' : '').'placeholder="'.$name.'" v-model="'.$vueData.'"'.$moreAttr.'>
            </div>
            '.($errorShow ? '<span class="help-block" v-if="error.'.$vueData.' != null">{{ error.'.$vueData.' }}</span>':'').'
        </div>
    </div>';
    }

    public function addTextArea() {}

    public function addSelect() {}

    public function addButton() {}

}