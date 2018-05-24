<?php

namespace AppBundle\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;


class LevRatio extends FunctionNode
{
    // (1)
    public $firstDateExpression = null;

    public $secondDateExpression = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); // (2)
        $parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
        $this->firstDateExpression = $parser->StringExpression(); // (4)
        $parser->match(Lexer::T_COMMA); // (5)
        $this->secondDateExpression = $parser->StringExpression(); // (6)
        $parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        dump($this->secondDateExpression);
        return 'levenshtein_ratio('
            . $this->firstDateExpression->dispatch($sqlWalker) . ','
            . $this->secondDateExpression->dispatch($sqlWalker) .
        ')'; // (7)
    }
}