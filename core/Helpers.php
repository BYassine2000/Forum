<?php

class Helpers {

	public function input($id, $label, $type) {
		return "
		<div class='mb-3'>
            <label for='{$id}' class='form-label'>$label</label>
            <input type='{$type}' name='{$id}' id='{$id}' class='form-control'>
        </div>
		";
	}

	public function textarea($id, $label) {
		return "
		<div class='mb-3'>
            <label for='{$id}' class='form-label'>$label</label>
            <textarea name='{$id}' id='{$id}' class='form-control'></textarea>
        </div>
		";
	}

	public function datetime($id, $label, $name) {
		return "
		<div class='mb-3'>
            <label for='{$id}' class='form-label'>$label</label>
            <input type='datetime-local' name='{$name}' id='{$id}' class='form-control'>
        </div>
		";
	}

	public function textareaEdit($name, $value) {
		return "<textarea name='{$name}' class='form-control'>$value</textarea>";
	}

	public function edit($type, $name, $value) {
		return "<input type='{$type}' name='{$name}' class='form-control' value='{$value}'>";
	}

	public function select($id, $texte, $name, $options = array()) {
		$html = "<label for='{$id}' class='form-label'>$texte</label>
		<select id='{$id}' name='{$name}' class='form-select'>";
		foreach ($options as $key => $value) {
			$html .= "<option value='{$key}'>$value</option>";
		}
		$html .= "</select>";
		return $html;
	}

}

?>
