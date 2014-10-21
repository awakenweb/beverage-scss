<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Awakenweb\BeverageScss;

use Awakenweb\Beverage\Modules\Module;

/**
 * Description of Scss
 *
 * @author Mathieu
 */
class Scss implements Module
{

    const compressed = 'scss_formatter_compressed';
    const nested     = 'scss_formatter_nested ';
    const normal     = 'scss_formatter';

    protected $compiler;

    public function __construct($importPath = 'scss', $useCompass = false, $formatter = self::nested)
    {
        $this->compiler = new \Leafo\ScssPhp\Compiler();
        $this->compiler->addImportPath($importPath);
        $this->compiler->setFormatter($formatter);

        if ($useCompass) {
            new \scss_compass($this->compiler);
        }
    }

    public function process(array $current_state)
    {
        $updated_state = [];

        foreach ($current_state as $filename => $content) {
            $updated_state[str_replace('.scss', '.css', $filename)] = $this->compiler->compile($content);
        }

        return $updated_state;
    }

}
