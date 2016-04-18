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

	"accepted"             => "A(z) :attribute nem elfogadott.",
	"active_url"           => "A(z) :attribute nem érvényes URL.",
	"after"                => "A(z) :attribute dátumnak :date-nél későbbinek kell lennie.",
	"alpha"                => "A(z) :attribute csak betűket tartalmazhat.",
	"alpha_dash"           => "A(z) :attribute csak betűket, számokat kötőjelet tartalmazhat.",
	"alpha_num"            => "A(z) :attribute csak betűket és számoat tartalmazhat.",
	"array"                => "A(z) :attribute tömbnek kell lennie.",
	"before"               => "A(z) :attribute dátumnak :date-nél későbbinek kell lennie.",
	"between"              => array(
		"numeric" => "A(z) :attribute értékének :min és :max között kell lennie.",
		"file"    => "A(z) :attribute méretének :min és :max kilobyte között kell lennie.",
		"string"  => "A(z) :attribute hosszának :min és :max karakter között kell lennie.",
		"array"   => "A(z) :attribute elemszámának :min és :max között kell lennie.",
	),
	"boolean"              => "A(z) :attribute csak igaz vagy hamis lehet.",
	"confirmed"            => "A(z) :attribute nincs megerősítve.",
	"date"                 => "A(z) :attribute nem érvényes dátum.",
	"date_format"          => "A(z) :attribute nem megfelelő formátumú.  A helyes formátum: :format.",
	"different"            => "A(z) :attribute és :other megegyezik.",
	"digits"               => "A(z) :attribute  számjegyeinek :digits kell lenni.",
	"digits_between"       => "A(z) :attribute  :min és :max számjegy között kell lennie.",
	"email"                => "A(z) :attribute érvényes e-mail címnek kell lennie.",
	"exists"               => "A kiválasztott :attribute érvénytelen.",
	"image"                => "A(z) :attribute képnek kell lennie.",
	"in"                   => "A(z) kiválaszott :attribute érvénytelen",
	"integer"              => "A(z) :attribute nem egész szám.",
	"ip"                   => "A(z) :attribute nem érvényes IP-cím.",
	"max"                  => array(
		"numeric" => "A(z) :attribute nem lehet nagyobb, mint :max.",
		"file"    => "A(z) :attribute mérete nem lehet nagyobb, mint :max kilobyte.",
		"string"  => "A(z) :attribute hossza legfeljebb :max karakter.",
		"array"   => "A(z) :attribute elemszáma legfeljebb :max.",
	),
	"mimes"                => "A(z) :attribute csak a következő típusúak lehetnek: :values.",
	"min"                  => array(
		"numeric" => "A(z) :attribute értéke legalább :min.",
		"file"    => "A(z) :attribute legalább :min kilobyte méretűnek kell lenni.",
		"string"  => "A(z) :attribute legalább :min karakter hosszúnak kell lennie.",
		"array"   => "A(z) :attribute legalább :min elemet tartalmaznia kell.",
	),
	"not_in"               => "A(z) kiválasztott :attribute érvénytelen.",
	"numeric"              => "A(z) :attribute nem szám.",
	"regex"                => "Helytelen formátum!",
	"required"             => "A(z) :attribute kitöltése kötelező.",
	"required_if"          => "A(z) :attribute kötelező, ha :other értéke :value.",
	"required_with"        => "A(z) :attribute kötelező, ha :values adott.",
	"required_with_all"    => "A(z) :attribute kötelező ,ha :values adott.",
	"required_without"     => "A(z) :attribute kötelező, ha :values nincs megadva.",
	"required_without_all" => "A(z) :attribute kötelező, ha egyik sincs megadva :values közül.",
	"same"                 => "A(z) :attribute and :oA(z)r must match.",
	"size"                 => array(
		"numeric" => "A(z) :attribute értékének :size. kell lenni",
		"file"    => "A(z) :attribute méretének :size kilobytes kell lenni.",
		"string"  => "A(z) :attribute hosszának :size kell lenni.",
		"array"   => "A(z) :attribute elemszmának :size kell lenni.",
	),
	"unique"               => "A(z) :attribute már foglalt.",
	"url"                  => "A(z) :attribute formátuma érvénytelen.",
	"timezone"             => "A(z) :attribute érvényes időzóna",

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
