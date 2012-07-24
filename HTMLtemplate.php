<?php

/*HTML page template class*/
class HTML_page extends HTML_container
{
// members

	var $title = "Default HTML Page (c) Andrew Pham";
	var $description = "default description";
	var $keywords = array();
	var $styleSheetLink;
	
	function __construct($title, $desc, $keywords, $styleSheetLink)
	{
		$this->title = $title;
		$this->description = $desc;
		$this->keywords = $keywords;
		$this->styleSheetLink = $styleSheetLink;	
	}
	
	function display()
	{
		echo <<<_HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />  
    <meta name="description" content="$this->description" />  
    <meta name="keywords" content="
_HTML;
		foreach ($this->keywords as &$key){
			echo $key.", ";
		}
	echo <<<_HTML
	" />  
    <title>$this->title</title>  
    <link rel="stylesheet" href="$this->styleSheetLink" type="text/css"/>  
</head>
<body>
_HTML;
parent::displayChildren();
echo <<<_HTML
</body>
_HTML;
	
	}

}

class HTML_element
{
	var $name;
	var $title;
	var $id;
	var $class_name;
	var $parent;
	var $innerText="";
	public static function innerText($innerText)
	{
		$instance = new self();
		$instance->innerText = $innerText;
		return $instance;
	}
	function displayProperties()
	{
		if($this->name!=NULL)
		echo 'name="'.$this->name.'"'; 
		if($this->title!=NULL)
		echo 'title="'.$this->title.'"';
		if($this->id!=NULL)
		echo 'id="'.$this->id.'" ';
		if($this->class_name!=NULL)
		echo 'class="'.$this->class_name.'"';
	}
}

class HTML_container extends HTML_element
{
	
	var $children = array();
	function addChild($child)
	{
		$this->children[] = $child;
	}
	function displayChildren()
	{
		foreach($this->children as $child)
		{
			$child->display();
		}
	}
}

class HTML_form extends HTML_container
{
	var $method;
	var $action;
	function display()
	{
		echo '
		<form method="'.$this->method.'" action="'.$this->action.'" ';
		
		parent::displayProperties();
		echo '>
		';
		parent::displayChildren();
		echo ' 
			<input type="submit" value="Search">
		</form>
		';
	}
}

class HTML_input_field extends HTML_element
{
	var $type ="";
	var $value ="";
	var $label;
	function display()
	{
		$this->label->display();
		echo '<input type = "'.$this->type.'" value="'.$this->value.'" ';
		parent::displayProperties();
		echo '>'."\n";
	}
}
class HTML_label extends HTML_element
{
	
	function display()
	{
		echo '<span ';
		parent::displayProperties();
		echo '>'.$this->innerText.'</span>'."\n";
		
	}
	public static function innerText($innerText)
	{
		$instance = new self();
		$instance->innerText = $innerText;
		return $instance;
	}
}
class HTML_drop_list extends HTML_element
{
	var $items = array();
	var $keys = array();
	var $label;
	function __construct($items)
	{
		$this->items = $items;
		$this->keys  = array_keys($items);
	}
	function display()
	{
		$this->label->display();
		echo '<select ';
		parent::displayProperties();
		echo '>';
		foreach($this->keys as $key)
		{
			echo '<option value="'.$key.'">'.$this->items[$key].'</option>'."\n";
		}
		echo '</select>';
	}
}

class HTML_div extends HTML_container
{
	function display()
	{
		echo '<div ';
		parent::displayProperties();
		echo '>'."\n";
		parent::displayChildren();
		echo "</div>\n";
	}
}

class HTML_table extends HTML_container
{
	var $dataSet= array();
	function addRow($dataRow)
	{
		$this->dataSet[]=$dataRow;
	}
	function display()
	{
		echo '<table ';
		parent::displayProperties();
		echo '>'."\n";
		parent::displayChildren();
		echo "</table>\n";
	}	
}
class HTML_table_cell extends HTML_container
{
	function display()
	{
		echo '<td ';
		parent::displayProperties();
		echo '>'."\n";
		parent::displayChildren();
		echo "</td>\n";
	}
}

class HTML_table_row extends HTML_container
{
	function display()
	{
		echo '<tr ';
		parent::displayProperties();
		echo '>'."\n";
		parent::displayChildren();
		echo "</tr>\n";
	}
}
class HTML_table_header extends HTML_container
{
	function display()
	{
		echo '<th ';
		parent::displayProperties();
		echo '>'."\n";
		parent::displayChildren();
		echo "</th>\n";
	}
}