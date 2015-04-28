<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "Il campo  :attribute deve essere accettato.",
	"active_url"           => "Il campo :attribute non è un URL valido",
	"after"                => "Il campo :attribute deve essere seguente a :date.",
	"alpha"                => "Il campo :attribute deve contenere soltanto lettere",
	"alpha_dash"           => "Il campo :attribute deve contenere soltanto lettere, numeri, e trattini.",
	"alpha_num"            => "Il campo :attribute deve contenere soltanto lettere e numeri.",
	"array"                => "Il campo :attribute deve essere un array",
	"before"               => "Il campo :attribute deve essere precedente a :date.",
	"between"              => array(
		"numeric" => "Il campo :attribute deve essere compreso tra :min e :max.",
		"file"    => "Il campo :attribute deve essere compreso tra  :min e :max kilobytes.",
		"string"  => "Il campo :attribute deve essere compreso tra :min e :max caratteri.",
		"array"   => "Il campo :attribute deve essere compreso tra :min e :max elementi.",
	),
	"confirmed"            => "La conferma del campo :attribute non corrisponde.",
	"date"                 => "Il campo :attribute non è una data valida.",
	"date_format"          => "Il campo :attribute non soddisfa il formato :format.",
	"different"            => "Il campo :attribute e :other non devono corrispondere.",
	"digits"               => "Il campo :attribute deve essere a :digits cifra/e.",
	"digits_between"       => "Il campo :attribute deve essere compreso tra :min e :max cifre.",
	"email"                => "Il campo :attribute deve essere un indirizzo e-mail valido.",
	"exists"               => "Il campo :attribute selezionato non è valido",
	"image"                => "Il campo :attribute deve essere una immagine",
	"in"                   => "Il campo :attribute selezionato non è valido",
	"integer"              => "Il campo :attribute deve essere un numero intero",
	"ip"                   => "Il campo :attribute deve essere un indirizzo IP valido.",
	"max"                  => array(
		"numeric" => "Il campo :attribute non deve essere più grande di :max.",
		"file"    => "Il campo :attribute non deve essere più grande di :max kilobytes.",
		"string"  => "Il campo :attribute non deve essere più grande di :max caratteri.",
		"array"   => "Il campo :attribute non deve essere più grande di :max elementi.",
	),
	"mimes"                => "Il campo :attribute deve essere un file di tipo: :values.",
	"min"                  => array(
		"numeric" => 'Il campo :attribute deve essere minimo di :min ',
		"file"    => 'Il campo :attribute deve essere minimo di :min kilobytes ',
		"string"  => 'Il campo :attribute deve essere minimo di :min caratteri',
		"array"   => 'Il campo :attribute deve essere minimo di :min elementi',
	),
	"not_in"               => "Il campo :attribute selezionato non è valido",
	"numeric"              => "Il campo :attribute deve essere un numero",
	"regex"                => "Il formato del campo :attribute non è valido",
	"required"             => "Il campo :attribute &egrave; obbligatorio",//"The :attribute field is required.",
	"required_if"          => "Il campo :attribute è obbligatorio quando il campo :other corrisponde a :value.",
	"required_with"        => "Il campo :attribute è obbligatorio quando è presente :values.",
	"required_with_all"    => "Il campo :attribute è obbligatorio quando è presente :values.",
	"required_without"     => "Il campo :attribute è obbligatorio quando non è presente :values.",
	"required_without_all" => "Il campo :attribute è obbligatorio quando nessuno dei valori :values sono presenti",
	"same"                 => "Il campo :attribute e :other devono essere uguali.",
	"size"                 => array(
		"numeric" => "Il campo :attribute deve essere :size.",
		"file"    => "Il campo :attribute deve essere di :size kilobytes.",
		"string"  => "Il campo :attribute deve essere di :size caratteri.",
		"array"   => "Il campo :attribute deve essere di :size elementi.",
	),
	"unique"               => "Il campo :attribute è già presente nel sistema.", 
	"url"                  => "Il formato di :attribute non è valido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
